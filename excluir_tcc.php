<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    // Exclui da agenda primeiro (por FK)
    $stmt = $pdo->prepare("DELETE FROM agenda_tcc WHERE cd_tcc = ?");
    $stmt->execute([$id]);
    // Exclui o TCC
    $stmt = $pdo->prepare("DELETE FROM tcc WHERE cd_tcc = ?");
    $stmt->execute([$id]);
}
header("Location: agenda.php");
exit;
?>