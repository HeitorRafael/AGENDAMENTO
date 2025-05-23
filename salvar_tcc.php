<?php
require 'db.php';

// Função para inserir aluno se não existir e retornar o cod_aluno
function getOrCreateAluno($pdo, $nome) {
    if (empty($nome)) return null;
    $stmt = $pdo->prepare("SELECT cod_aluno FROM aluno WHERE nome = ?");
    $stmt->execute([$nome]);
    $aluno = $stmt->fetch();
    if ($aluno) {
        return $aluno['cod_aluno'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO aluno (nome) VALUES (?)");
        $stmt->execute([$nome]);
        return $pdo->lastInsertId();
    }
}

// Recebe os dados do formulário
$titulo = $_POST['titulo'];
$tipo = $_POST['tipo'];
$aluno1 = trim($_POST['aluno1']);
$aluno2 = trim($_POST['aluno2']);
$aluno3 = trim($_POST['aluno3']);
$orientador = $_POST['orientador'];
$coorientador = !empty($_POST['coorientador']) ? $_POST['coorientador'] : null;
$prof_conv1 = $_POST['professor2'];
$prof_conv2 = $_POST['professor3'];
$apresentacao = $_POST['apresentacao'];
$data_cad = date('Y-m-d');

// Insere alunos e pega os IDs
$aluno1_id = getOrCreateAluno($pdo, $aluno1);
$aluno2_id = $aluno2 ? getOrCreateAluno($pdo, $aluno2) : null;
$aluno3_id = $aluno3 ? getOrCreateAluno($pdo, $aluno3) : null;

// Insere o TCC
$stmt = $pdo->prepare("INSERT INTO tcc (titulo, data_cad, cod_tip, prof_orient, prof_coorient, aluno1, aluno2, aluno3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([
    $titulo,
    $data_cad,
    $tipo,
    $orientador,
    $coorientador,
    $aluno1_id,
    $aluno2_id,
    $aluno3_id
]);
$cod_tcc = $pdo->lastInsertId();

// Insere a agenda da apresentação
$stmt = $pdo->prepare("INSERT INTO agenda_tcc (cod_tcc, data_def, prof_conv1, prof_conv2) VALUES (?, ?, ?, ?)");
$stmt->execute([
    $cod_tcc,
    $apresentacao,
    $prof_conv1,
    $prof_conv2
]);

header("Location: agenda.php");
exit;
?>