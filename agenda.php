<?php
require 'db.php';
require 'classes/classes.php';

$sql = "SELECT
            tcc.cd_tcc,
            tcc.titulo,
            t.cd_tip,
            t.nome AS tipo_nome,
            ag.data_def AS apresentacao,
            p_orient.cd_prof AS orientador_id,
            p_orient.nome AS orientador_nome
        FROM tcc
        LEFT JOIN tipo t ON tcc.cd_tip = t.cd_tip
        LEFT JOIN agenda_tcc ag ON ag.cd_tcc = tcc.cd_tcc
        LEFT JOIN prof p_orient ON tcc.prof_orient = p_orient.cd_prof";
$stmt = $pdo->query($sql);
$tccs = [];
while ($row = $stmt->fetch()) {
    $tipo = new Tipo($row['cd_tip'], $row['tipo_nome']);
    $orientador = new Orientador($row['orientador_id'], $row['orientador_nome']);
    $tccs[] = new Tcc($row['cd_tcc'], $row['titulo'], null, $tipo, $orientador);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agenda Completa - TCCs</title>
    <link rel="stylesheet" href="style/agenda.css">
</head>
<body>

    <header>
        <h1>Agenda Completa - TCCs</h1>
    </header>

    <div class="tcc-listagem">
        <?php if (empty($tccs)): ?>
            <p style="text-align: center;">Nenhum TCC cadastrado ainda.</p>
        <?php else: ?>
            <?php $i = 0; while ($i < count($tccs)): $tccObj = $tccs[$i]; ?>
                <div class="tcc-card">
                    <h3><?= htmlspecialchars($tccObj->getTitulo()) ?></h3>
                    <p><strong>Tipo:</strong>
                    <?php
                    $tipoNome = $tccObj->getTipo()->getNome();
                    switch ($tipoNome) {
                        case 'Artigo': echo "Artigo Científico"; break;
                        case 'Monografia': echo "Monografia"; break;
                        default: echo htmlspecialchars($tipoNome);
                    }
                    ?>
                    </p>
                    <p><strong>Data:</strong>
                        <?php
                        // Para obter a data de apresentação, precisamos fazer outra consulta
                        $stmtAgenda = $pdo->prepare("SELECT data_def FROM agenda_tcc WHERE cd_tcc = ?");
                        $stmtAgenda->execute([$tccObj->getCdTcc()]);
                        $agenda = $stmtAgenda->fetch();
                        if ($agenda && $agenda['data_def']) {
                            echo date('d/m/Y H:i', strtotime($agenda['data_def']));
                        } else {
                            echo 'Não definida';
                        }
                        ?>
                    </p>
                    <div class="botoes-card">
                        <a href="show_tcc.php?id=<?= $tccObj->getCdTcc() ?>" class="btn-vermelho">Abrir</a>
                        <a href="editar_tcc.php?id=<?= $tccObj->getCdTcc() ?>" class="btn-editar">Editar</a>
                        <a href="excluir_tcc.php?id=<?= $tccObj->getCdTcc() ?>" class="btn-preto" onclick="return confirm('Tem certeza que deseja excluir este TCC?')">Excluir</a>
                    </div>
                </div>
            <?php $i++; endwhile; ?>
        <?php endif; ?>
    </div>

    <p>Total de TCCs cadastrados: <?= count($tccs) ?></p>

    <a href="index.php" class="btn-agenda-completa">Novo TCC</a>

    <?php $num = 1; foreach ($tccs as $tccObj): ?>
        <p>Número: <?= $num++ ?></p>
    <?php endforeach; ?>
</body>
</html>