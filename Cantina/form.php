<?php
require "conexao.php";
$id = $_GET['id'] ?? null;
$produto = ['nome' => '', 'unidade' => '', 'quantidade' => '', 'preco' => '', 'id_categoria' => ''];

if ($id) {
    $s = $pdo->prepare("SELECT * FROM produto WHERE id = ?");
    $s->execute([$id]);
    $produto = $s->fetch() ?: die("Produto não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        trim($_POST['nome']),
        trim($_POST['unidade']),
        $_POST['quantidade'],
        $_POST['preco'],
        $_POST['id_categoria']
    ];
    if ($id) {
        $dados[] = $id;
        $sql = "UPDATE produto SET nome=?, unidade=?, quantidade=?, preco=?, id_categoria=? WHERE id=?";
    } else {
        $sql = "INSERT INTO produto (nome, unidade, quantidade, preco, id_categoria) VALUES (?, ?, ?, ?, ?)";
    }
    $pdo->prepare($sql)->execute($dados);
    header("Location: index.php?msg=ok");
    exit;
}
$categorias = $pdo->query("SELECT id, nome FROM categoria ORDER BY nome")->fetchAll();
include "topo.php";
?>
<h2><?= $id ? "Editar produto" : "Novo produto" ?></h2>
<form method="post">
<label>Nome</label>
<input type="text" name="nome" required value="<?= htmlspecialchars($produto['nome']) ?>">
<label>Categoria</label>
<select name="id_categoria" required>
<option value="">Selecione...</option>
<?php foreach ($categorias as $c): ?>
    <option value="<?= $c['id'] ?>" <?= $c['id'] == $produto['id_categoria'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($c['nome']) ?>
    </option>
<?php endforeach; ?>
</select>
<label>Unidade (un, pct, L...)</label>
<input type="text" name="unidade" required maxlength="10" value="<?= htmlspecialchars($produto['unidade']) ?>">
<label>Quantidade</label>
<input type="number" step="0.01" min="0" name="quantidade" required value="<?= $produto['quantidade'] ?>">
<label>Preço (R$)</label>
<input type="number" step="0.01" min="0" name="preco" required value="<?= $produto['preco'] ?>">
<br><br>
<button type="submit">Salvar</button>
<a class="btn" href="index.php">Cancelar</a>
</form>
<?php include "rodape.php"; ?>