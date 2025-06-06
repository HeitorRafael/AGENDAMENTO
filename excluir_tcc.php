<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    //9.4 Deleção
    $stmt = $pdo->prepare("DELETE FROM agenda_tcc WHERE cd_tcc = ?");
    $stmt->execute([$id]);
    $stmt = $pdo->prepare("DELETE FROM tcc WHERE cd_tcc = ?");
    $stmt->execute([$id]);
}
header("Location: agenda.php");
exit;
?>