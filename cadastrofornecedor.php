<?php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Fornecedores</title>
</head>
<body>
<?php
$pdo = new PDO('mysql:host=localhost;dbname=VKadega', 'root', '');

$id = '';
$nome = '';
$contato = '';
$editando = false;

// DELETE
if (isset($_GET['act']) && $_GET['act'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM fornecedores WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    header("Location: cadastrofornecedor.php");
    exit;
}

// EDIT
if (isset($_GET['act']) && $_GET['act'] === 'edit' && isset($_GET['id'])) {
    $editando = true;
    $id = $_GET['id'];
    $sql = "SELECT * FROM fornecedores WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($fornecedor) {
        $nome = $fornecedor['nome'];
        $contato = $fornecedor['contato'];
    }
}

// CREATE ou UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $contato = $_POST['contato'] ?? '';

    if (empty($nome) || empty($contato)) {
        echo "<div style='color: red;'>Preencha todos os campos.</div>";
    } else {
        try {
            if (!empty($id)) {
                $sql = "UPDATE fornecedores SET nome = :nome, contato = :contato WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', $id);
            } else {
                $sql = "INSERT INTO fornecedores (nome, contato) VALUES (:nome, :contato)";
                $stmt = $pdo->prepare($sql);
            }
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':contato', $contato);
            $stmt->execute();
            header("Location: cadastrofornecedor.php");
            exit;
        } catch (PDOException $e) {
            echo "<div style='color: red;'>Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
}
?>
<form method="POST">
    <h1><?php echo $editando ? "Editar Fornecedor" : "Cadastrar Fornecedor"; ?></h1>
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>"><br>
    Contato: <input type="text" name="contato" value="<?php echo htmlspecialchars($contato); ?>"><br>
    <input type="submit" value="<?php echo $editando ? "Salvar" : "Cadastrar"; ?>">
</form>
<h2>Fornecedores Cadastrados</h2>
<table border="1">
    <tr>
        <th>ID</th><th>Nome</th><th>Contato</th><th>Ações</th>
    </tr>
    <?php
    $sql = "SELECT * FROM fornecedores";
    $stmt = $pdo->query($sql);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($row['contato']) . "</td>";
        echo "<td>
                <a href='?act=edit&id=" . urlencode($row['id']) . "'>Editar</a> |
                <a href='?act=delete&id=" . urlencode($row['id']) . "' onclick=\"return confirm('Excluir?');\">Excluir</a>
              </td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>
