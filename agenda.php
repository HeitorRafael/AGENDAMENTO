<?php
require 'db.php';

$sql = "SELECT 
            tcc.cd_tcc,
            tcc.titulo,
            tipo.nome AS tipo,
            ag.data_def AS apresentacao
        FROM tcc
        LEFT JOIN tipo ON tcc.cd_tip = tipo.cd_tip
        LEFT JOIN agenda_tcc ag ON ag.cd_tcc = tcc.cd_tcc";
$tccs = $pdo->query($sql)->fetchAll();
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
            <?php foreach ($tccs as $tcc): ?>
                <div class="tcc-card">
                    <h3><?= htmlspecialchars($tcc['titulo']) ?></h3>
                    <p><strong>Tipo:</strong> <?= htmlspecialchars($tcc['tipo']) ?></p>
                    <p><strong>Data:</strong> 
                        <?= $tcc['apresentacao'] ? date('d/m/Y H:i', strtotime($tcc['apresentacao'])) : 'Não definida' ?>
                    </p>
                    <div class="botoes-card">
                        <a href="showTcc.php?id=<?= $tcc['cd_tcc'] ?>" class="btn-vermelho">Abrir</a>
                        <a href="excluir_tcc.php?id=<?= $tcc['cd_tcc'] ?>" class="btn-preto" onclick="return confirm('Tem certeza que deseja excluir este TCC?')">Excluir</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <a href="index.php" class="btn-agenda-completa">Novo TCC</a>
</body>
</html>
