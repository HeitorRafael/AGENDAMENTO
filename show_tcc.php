<?php
require 'db.php';

// Pega o ID via GET
//6.3 Operador Ternário
$id = $_GET['id'] ?? null;
$tcc = null;
//3.4 Comparação
if ($id !== null) {
    $sql = "SELECT 
                tcc.titulo,
                tcc.data_cad,
                tipo.nome AS tipo,
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
    <title>Visualizar TCC</title>
    <link rel="stylesheet" href="style/show_tcc.css">
    <style>
        .detalhes-container {
            max-width: 800px;
            margin: 30px auto;
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(139, 0, 0, 0.7);
        }

        .detalhes-container p {
            font-size: 1.1em;
            margin-bottom: 15px;
        }

        .voltar {
            display: inline-block;
            margin-top: 20px;
            background-color: #8B0000;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .voltar:hover {
            background-color: #a80000;
        }

        .btn-editar, .btn-preto {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .btn-editar {
            background-color: #007bff;
            color: #fff;
        }

        .btn-editar:hover {
            background-color: #0056b3;
        }

        .btn-preto {
            background-color: #343a40;
            color: #fff;
        }

        .btn-preto:hover {
            background-color: #23272b;
        }
    </style>
</head>
<body>

    <header>
        <h1><?= $tcc ? htmlspecialchars($tcc['titulo']) : 'TCC não encontrado' ?></h1>
    </header>

    <div class="detalhes-container">
        <!--6.1 If/Else-->
        <?php if ($tcc): ?>
            <p><strong>Tipo de TCC:</strong> <?= htmlspecialchars($tcc['tipo']) ?></p>
            <p><strong>Aluno 1:</strong> <?= htmlspecialchars($tcc['aluno1']) ?></p>
            <?php if (!empty($tcc['aluno2'])): ?>
                <p><strong>Aluno 2:</strong> <?= htmlspecialchars($tcc['aluno2']) ?></p>
            <?php endif; ?>
            <?php if (!empty($tcc['aluno3'])): ?>
                <p><strong>Aluno 3:</strong> <?= htmlspecialchars($tcc['aluno3']) ?></p>
            <?php endif; ?>
            <p><strong>Professor Orientador:</strong> <?= htmlspecialchars($tcc['orientador']) ?></p>
            <?php if (!empty($tcc['coorientador'])): ?>
                <p><strong>Professor Co-orientador:</strong> <?= htmlspecialchars($tcc['coorientador']) ?></p>
            <?php endif; ?>
            <?php if (!empty($tcc['prof_conv1'])): ?>
                <p><strong>Professor Convidado 1:</strong> <?= htmlspecialchars($tcc['prof_conv1']) ?></p>
            <?php endif; ?>
            <?php if (!empty($tcc['prof_conv2'])): ?>
                <p><strong>Professor Convidado 2:</strong> <?= htmlspecialchars($tcc['prof_conv2']) ?></p>
            <?php endif; ?>
            <p><strong>Data e Hora da Apresentação:</strong> 
                <?= $tcc['apresentacao'] ? date('d/m/Y H:i', strtotime($tcc['apresentacao'])) : 'Não definida' ?>
            </p>

            <a href="agenda.php" class="voltar">← Voltar para Agenda</a>
            <a href="editar_tcc.php?id=<?= $id ?>" class="btn-editar">Editar</a>
            <a href="excluir_tcc.php?id=<?= $id ?>" class="btn-preto" onclick="return confirm('Tem certeza que deseja excluir este TCC?')">Excluir</a>
        <?php else: ?>
            <p>TCC não encontrado.</p>
            <a href="agenda.php" class="voltar">← Voltar para Agenda</a>
        <?php endif; ?>
    </div>

</body>
</html>

