<?php
require "conexao.php";
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->prepare("INSERT INTO categoria (nome) VALUES (?)")->execute([trim($_POST['nome'])]);
        header("Location: categorias.php");
        exit;
    } catch (PDOException $e) {
        $erro = "Categoria já existe ou nome inválido.";
    }
}
$categorias = $pdo->query("SELECT * FROM categoria ORDER BY nome")->fetchAll();
include "topo.php";
?>
<h2>Categorias</h2>
<?php if ($erro): ?><div class="msg"><?= $erro ?></div><?php endif; ?>
<form method="post">
<label>Nova categoria</label>
<input type="text" name="nome" required maxlength="60">
<br><br>
<button type="submit">Cadastrar</button>
</form>
<br>
<table>
<tr><th>ID</th><th>Nome</th></tr>
<?php foreach ($categorias as $c): ?>
<tr>
<td><?= $c['id'] ?></td>
<td><?= htmlspecialchars($c['nome']) ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php include "rodape.php"; ?>