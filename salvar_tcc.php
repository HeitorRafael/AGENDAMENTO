<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];
    $titulo = $_POST['titulo'];
    $aluno1 = $_POST['aluno1'];
    $aluno2 = $_POST['aluno2'] ?? '';
    $aluno3 = $_POST['aluno3'] ?? '';
    $orientador = $_POST['orientador'];
    $coorientador = $_POST['coorientador'] ?? '';
    $apresentacao = $_POST['apresentacao'];

    $stmt = $pdo->prepare("INSERT INTO tccs (tipo, titulo, aluno1, aluno2, aluno3, orientador, coorientador, apresentacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$tipo, $titulo, $aluno1, $aluno2, $aluno3, $orientador, $coorientador, $apresentacao]);

    header('Location: agenda.php');
    exit;
}
?>