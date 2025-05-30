
<?php
require 'db.php';
//1.1 Comentários
//2.1 Camel Case/Snake Case snake_case para variaveis e camelCase para funções
//3.3 Atribuição

//8.1 Funções com passagem de parâmetros
function getOrCreateAluno($pdo, $nome) {
    //3.6 Lógico
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

// Função para inserir professor se não existir e retornar o cd_prof
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

// Recebe os dados do formulário
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
$data_cad = date('Y-m-d');

// Insere alunos e pega os IDs
$aluno1_id = getOrCreateAluno($pdo, $aluno1);
$aluno2_id = $aluno2 ? getOrCreateAluno($pdo, $aluno2) : null;
$aluno3_id = $aluno3 ? getOrCreateAluno($pdo, $aluno3) : null;

// Insere professores e pega os IDs
$orientador = getOrCreateProf($pdo, $orientador_nome);
$coorientador = $coorientador_nome ? getOrCreateProf($pdo, $coorientador_nome) : null;
$prof_conv1 = getOrCreateProf($pdo, $prof_conv1_nome);
$prof_conv2 = getOrCreateProf($pdo, $prof_conv2_nome);

// Insere o TCC
$stmt = $pdo->prepare("INSERT INTO tcc (titulo, data_cad, cd_tip, prof_orient, prof_coorient, aluno1, aluno2, aluno3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
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
$cd_tcc = $pdo->lastInsertId();

// Insere a agenda da apresentação
$stmt = $pdo->prepare("INSERT INTO agenda_tcc (cd_tcc, data_def, prof_conv1, prof_conv2) VALUES (?, ?, ?, ?)");
$stmt->execute([
    $cd_tcc,
    $apresentacao,
    $prof_conv1,
    $prof_conv2
]);

header("Location: agenda.php");
exit;
?>