<?php
require "conexao.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("DELETE FROM produto WHERE id = ?");
    $stmt->execute([$_POST['id']]);
}
header("Location: index.php?msg=excluido");
exit;
?>