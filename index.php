<?php
require 'db.php';
//4.1 Array busca um tcc em um array fetchAll()
// Buscar tipos de TCC
$tipos = $pdo->query("SELECT cd_tip, nome FROM tipo")->fetchAll();

// Buscar professores
$professores = $pdo->query("SELECT cd_prof, nome FROM prof")->fetchAll();
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

            <!-- Tipo de TCC -->
            <div class="form-group">
                <label for="tipo">Tipo de TCC:</label>
                <select name="tipo" id="tipo" required>
                    <option value="">Selecione</option>
                    <!--5.2 Foreach-->
                    <?php foreach ($tipos as $tipo): ?>
                        <option value="<?= $tipo['cd_tip'] ?>"><?= htmlspecialchars($tipo['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Título -->
            <div class="form-group">
                <label for="titulo">Título do TCC:</label>
                <input type="text" name="titulo" id="titulo" required>
            </div>

            <!-- Alunos -->
            <div class="form-group">
                <label>Alunos Integrantes (até 3):</label>
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <input type="text" name="aluno<?= $i ?>" placeholder="Aluno <?= $i ?>" <?= $i == 1 ? 'required' : '' ?>>
                <?php endfor; ?>
            </div>

            <!-- Professores -->
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

            <!-- Data e hora -->
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