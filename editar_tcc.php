<?php
require 'db.php';
require 'classes/classes.php';

// Funções utilitárias (as mesmas do salvar_tcc.php)
function getOrCreateAluno($pdo, $nome) {
    if (empty($nome)) return null;
    $stmt = $pdo->prepare("SELECT cd_aluno FROM aluno WHERE nome = ?");
    $stmt->execute([$nome]);
    $aluno = $stmt->fetch();
    if ($aluno) {
        return $aluno['cd_aluno'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO aluno (nome) VALUES (?)");
        $stmt->execute([$nome]);
        return $pdo->lastInsertId();
    }
}
function getOrCreateProf($pdo, $nome) {
    if (empty($nome)) return null;
    $stmt = $pdo->prepare("SELECT cd_prof FROM prof WHERE nome = ?");
    $stmt->execute([$nome]);
    $prof = $stmt->fetch();
    if ($prof) {
        return $prof['cd_prof'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO prof (nome) VALUES (?)");
        $stmt->execute([$nome]);
        return $pdo->lastInsertId();
    }
}

// Buscar tipos de TCC
$tiposData = $pdo->query("SELECT cd_tip, nome, descricao FROM tipo")->fetchAll();
$tipos = [];
foreach ($tiposData as $tipoData) {
    $tipos[] = new Tipo($tipoData['cd_tip'], $tipoData['nome'], $tipoData['descricao']);
}

// Pega o ID do TCC
$id = $_GET['id'] ?? null;

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $aluno1 = trim($_POST['aluno1']);
    $aluno2 = trim($_POST['aluno2']);
    $aluno3 = trim($_POST['aluno3']);
    $orientador_nome = trim($_POST['orientador']);
    $coorientador_nome = trim($_POST['coorientador']);
    $prof_conv1_nome = trim($_POST['professor2']);
    $prof_conv2_nome = trim($_POST['professor3']);
    $apresentacao = $_POST['apresentacao'];
    $nota = isset($_POST['nota']) ? floatval($_POST['nota']) : null;

    // Atualiza alunos e professores
    $aluno1_id = getOrCreateAluno($pdo, $aluno1);
    $aluno2_id = $aluno2 ? getOrCreateAluno($pdo, $aluno2) : null;
    $aluno3_id = $aluno3 ? getOrCreateAluno($pdo, $aluno3) : null;
    $orientador = getOrCreateProf($pdo, $orientador_nome);
    $coorientador = $coorientador_nome ? getOrCreateProf($pdo, $coorientador_nome) : null;
    $prof_conv1 = getOrCreateProf($pdo, $prof_conv1_nome);
    $prof_conv2 = getOrCreateProf($pdo, $prof_conv2_nome);

    //9.3 Atualização
    $stmt = $pdo->prepare("UPDATE tcc SET titulo=?, cd_tip=?, prof_orient=?, prof_coorient=?, aluno1=?, aluno2=?, aluno3=?, nota=? WHERE cd_tcc=?");
    $stmt->execute([
        $titulo,
        $tipo,
        $orientador,
        $coorientador,
        $aluno1_id,
        $aluno2_id,
        $aluno3_id,
        $nota,
        $id
    ]);

    // Atualiza agenda
    $stmt = $pdo->prepare("UPDATE agenda_tcc SET data_def=?, prof_conv1=?, prof_conv2=? WHERE cd_tcc=?");
    $stmt->execute([
        $apresentacao,
        $prof_conv1,
        $prof_conv2,
        $id
    ]);

    header("Location: show_tcc.php?id=$id");
    exit;
}

// Busca dados atuais do TCC para preencher o formulário
$tcc = null;
if ($id) {
    $sql = "SELECT 
                tcc.titulo,
                tcc.cd_tip,
                tcc.nota,
                a1.nome AS aluno1,
                a2.nome AS aluno2,
                a3.nome AS aluno3,
                p_orient.nome AS orientador,
                p_coorient.nome AS coorientador,
                ag.data_def AS apresentacao,
                p_conv1.nome AS prof_conv1,
                p_conv2.nome AS prof_conv2
            FROM tcc
            LEFT JOIN tipo ON tcc.cd_tip = tipo.cd_tip
            LEFT JOIN aluno a1 ON tcc.aluno1 = a1.cd_aluno
            LEFT JOIN aluno a2 ON tcc.aluno2 = a2.cd_aluno
            LEFT JOIN aluno a3 ON tcc.aluno3 = a3.cd_aluno
            LEFT JOIN prof p_orient ON tcc.prof_orient = p_orient.cd_prof
            LEFT JOIN prof p_coorient ON tcc.prof_coorient = p_coorient.cd_prof
            LEFT JOIN agenda_tcc ag ON ag.cd_tcc = tcc.cd_tcc
            LEFT JOIN prof p_conv1 ON ag.prof_conv1 = p_conv1.cd_prof
            LEFT JOIN prof p_conv2 ON ag.prof_conv2 = p_conv2.cd_prof
            WHERE tcc.cd_tcc = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $tcc = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar TCC</title>
    <link rel="stylesheet" href="style/index.css">
</head>
<body>
    <header>
        <h1>Editar TCC</h1>
    </header>
    <div class="container">
        <?php if ($tcc): ?>
        <form method="POST">
            <div class="form-group">
                <label for="tipo">Tipo de TCC:</label>
                <select name="tipo" id="tipo" required>
                    <option value="">Selecione</option>
                    <?php foreach ($tipos as $tipoObj): ?>
                        <option value="<?= $tipoObj->getCdTip() ?>" <?= $tcc['cd_tip'] == $tipoObj->getCdTip() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tipoObj->getNome()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="titulo">Título do TCC:</label>
                <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($tcc['titulo']) ?>" required>
            </div>
            <div class="form-group">
                <label>Alunos Integrantes (até 3):</label>
                <input type="text" name="aluno1" value="<?= htmlspecialchars($tcc['aluno1']) ?>" required>
                <input type="text" name="aluno2" value="<?= htmlspecialchars($tcc['aluno2']) ?>">
                <input type="text" name="aluno3" value="<?= htmlspecialchars($tcc['aluno3']) ?>">
            </div>
            <div class="form-group">
                <label for="orientador">Professor Orientador:</label>
                <input type="text" name="orientador" id="orientador" value="<?= htmlspecialchars($tcc['orientador']) ?>" required>
            </div>
            <div class="form-group">
                <label for="coorientador">Professor Co-orientador: <span class="optional">(opcional)</span></label>
                <input type="text" name="coorientador" id="coorientador" value="<?= htmlspecialchars($tcc['coorientador']) ?>">
            </div>
            <div class="form-group">
                <label for="professor2">Professor Convidado 1:</label>
                <input type="text" name="professor2" id="professor2" value="<?= htmlspecialchars($tcc['prof_conv1']) ?>" required>
            </div>
            <div class="form-group">
                <label for="professor3">Professor Convidado 2:</label>
                <input type="text" name="professor3" id="professor3" value="<?= htmlspecialchars($tcc['prof_conv2']) ?>" required>
            </div>
            <div class="form-group">
                <label for="apresentacao">Data e Hora da Apresentação:</label>
                <input type="datetime-local" name="apresentacao" id="apresentacao"
                       value="<?= $tcc['apresentacao'] ? date('Y-m-d\TH:i', strtotime($tcc['apresentacao'])) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="nota">Nota do TCC:</label>
                <input type="number" step="0.01" min="0" max="10" name="nota" id="nota"
                       value="<?= isset($tcc['nota']) ? htmlspecialchars($tcc['nota']) : '' ?>">
            </div>
            <button type="submit">Salvar Alterações</button>
            <a href="show_tcc.php?id=<?= $id ?>" class="voltar">Cancelar</a>
        </form>
        <?php else: ?>
            <p>TCC não encontrado.</p>
            <a href="agenda.php" class="voltar">← Voltar para Agenda</a>
        <?php endif; ?>
    </div>
</body>
</html>