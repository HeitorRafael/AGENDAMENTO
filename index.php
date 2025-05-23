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
                    <?php foreach ($tipos as $tipo): ?>
                        <option value="<?= $tipo['cod_tip'] ?>"><?= htmlspecialchars($tipo['nome']) ?></option>
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
                <input type="text" name="aluno1" placeholder="Aluno 1" required>
                <input type="text" name="aluno2" placeholder="Aluno 2 (opcional)">
                <input type="text" name="aluno3" placeholder="Aluno 3 (opcional)">
            </div>

            <!-- Professores -->
            <div class="form-group">
                <label for="orientador">Professor Orientador:</label>
                <select name="orientador" id="orientador" required>
                    <option value="">Selecione</option>
                    <?php foreach ($professores as $prof): ?>
                        <option value="<?= $prof['cod_prof'] ?>"><?= htmlspecialchars($prof['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="coorientador">Professor Co-orientador: <span class="optional">(opcional)</span></label>
                <select name="coorientador" id="coorientador">
                    <option value="">Nenhum</option>
                    <?php foreach ($professores as $prof): ?>
                        <option value="<?= $prof['cod_prof'] ?>"><?= htmlspecialchars($prof['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="professor2">Professor Convidado 1:</label>
                <select name="professor2" id="professor2" required>
                    <option value="">Selecione</option>
                    <?php foreach ($professores as $prof): ?>
                        <option value="<?= $prof['cod_prof'] ?>"><?= htmlspecialchars($prof['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="professor3">Professor Convidado 2:</label>
                <select name="professor3" id="professor3" required>
                    <option value="">Selecione</option>
                    <?php foreach ($professores as $prof): ?>
                        <option value="<?= $prof['cod_prof'] ?>"><?= htmlspecialchars($prof['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
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

    <?php
    require 'db.php';

    // Buscar tipos de TCC
    $tipos = $pdo->query("SELECT cod_tip, nome FROM tipo")->fetchAll();

    // Buscar professores
    $professores = $pdo->query("SELECT cod_prof, nome FROM prof")->fetchAll();
    ?>

</body>
</html>
