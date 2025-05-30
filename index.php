<?php
require 'db.php';
require 'classes.php';

// Buscar tipos de TCC
$tiposData = $pdo->query("SELECT cd_tip, nome, descricao FROM tipo")->fetchAll();
$tipos = [];
foreach ($tiposData as $tipoData) {
    $tipos[] = new Tipo($tipoData['cd_tip'], $tipoData['nome'], $tipoData['descricao']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Agenda TCC's Praia Grande</title>
    <link rel="stylesheet" href="style/index.css">
</head>

<body>

    <header>
        <h1>Agenda TCC's Praia Grande</h1>
    </header>

    <div class="container">
        <form action="salvar_tcc.php" method="POST">

            <div class="form-group">
                <label for="tipo">Tipo de TCC:</label>
                <select name="tipo" id="tipo" required>
                    <option value="">Selecione</option>
                    <?php foreach ($tipos as $tipoObj): ?>
                        <option value="<?= $tipoObj->getCdTip() ?>"><?= htmlspecialchars($tipoObj->getNome()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="titulo">Título do TCC:</label>
                <input type="text" name="titulo" id="titulo" required>
            </div>

            <div class="form-group">
                <label>Alunos Integrantes (até 3):</label>
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <input type="text" name="aluno<?= $i ?>" placeholder="Aluno <?= $i ?>" <?= $i == 1 ? 'required' : '' ?>>
                <?php endfor; ?>
            </div>

            <div class="form-group">
                <label for="orientador">Professor Orientador:</label>
                <input type="text" name="orientador" id="orientador" required>
            </div>

            <div class="form-group">
                <label for="coorientador">Professor Co-orientador: <span class="optional">(opcional)</span></label>
                <input type="text" name="coorientador" id="coorientador">
            </div>

            <div class="form-group">
                <label for="professor2">Professor Convidado 1:</label>
                <input type="text" name="professor2" id="professor2" required>
            </div>

            <div class="form-group">
                <label for="professor3">Professor Convidado 2:</label>
                <input type="text" name="professor3" id="professor3" required>
            </div>

            <div class="form-group">
                <label for="apresentacao">Data e Hora da Apresentação:</label>
                <input type="datetime-local" name="apresentacao" id="apresentacao" required>
            </div>

            <button type="submit">Cadastrar TCC</button>
        </form>
    </div>
    <a href="agenda.php" class="btn-agenda-completa">Agenda Completa</a>

</body>

</html>