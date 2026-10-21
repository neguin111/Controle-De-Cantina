<?php
require "conexao.php";
$busca = $_GET['busca'] ?? '';
$sql = "SELECT p.*, c.nome AS categoria 
        FROM produto p 
        JOIN categoria c ON c.id = p.id_categoria 
        WHERE p.nome LIKE :busca 
        ORDER BY p.nome";
$stmt = $pdo->prepare($sql);
$stmt->execute([':busca' => "%$busca%"]);
$produtos = $stmt->fetchAll();
include "topo.php";
?>
<h2>Produtos cadastrados</h2>
<?php if (isset($_GET['msg'])): ?>
<div class="msg">Operação realizada com sucesso!</div>
<?php endif; ?>
<form method="get">
<input type="text" name="busca" placeholder="Buscar por nome..." value="<?= htmlspecialchars($busca) ?>">
<button type="submit">Buscar</button>
</form>
<br>
<table>
<tr>
<th>Nome</th><th>Categoria</th><th>Qtd.</th><th>Preço (R$)</th><th>Ações</th>
</tr>
<?php foreach ($produtos as $p): ?>
<tr>
<td><?= htmlspecialchars($p['nome']) ?></td>
<td><?= htmlspecialchars($p['categoria']) ?></td>
<td><?= $p['quantidade'] . ' ' . htmlspecialchars($p['unidade']) ?></td>
<td><?= number_format($p['preco'], 2, ',', '.') ?></td>
<td>
<a href="form.php?id=<?= $p['id'] ?>">Editar</a>
<form method="post" action="excluir.php" style="display:inline" onsubmit="return confirm('Excluir este produto?');">
<input type="hidden" name="id" value="<?= $p['id'] ?>">
<button type="submit">Excluir</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php include "rodape.php"; ?>