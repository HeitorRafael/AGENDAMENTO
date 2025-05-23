<?php
// Carrega os TCCs salvos utilizando dados de exemplo
$tccs = [];

if (file_exists('data/tccs.json')) {
    $json = file_get_contents('data/tccs.json');
    $tccs = json_decode($json, true);
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
            <?php foreach ($tccs as $index => $tcc): ?>
                <div class="tcc-card">
                    <h3><?= htmlspecialchars($tcc['titulo']) ?></h3>
                    <p><strong>Tipo:</strong> <?= $tcc['tipo'] ?></p>
                    <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($tcc['apresentacao'])) ?></p>
                    <div class="botoes-card">
                        <a href="showTcc.php?id=<?= $index ?>" class="btn-vermelho">Abrir</a>
                        <a href="excluir_tcc.php?id=<?= $index ?>" class="btn-preto" onclick="return confirm('Tem certeza que deseja excluir este TCC?')">Excluir</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>
