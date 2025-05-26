<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Sistema</title>
      <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <form action="?act=save" method="POST" name="form1">
        <h1>Cadastro de Administradores</h1>
        <hr>
        <input type="hidden" name="id">
        <input type="text" name="nomecompleto" placeholder="Nome Completo"/>
        <input type="text" name="login" placeholder="Login"/>
        <input type="password" name="senha2" placeholder="Senha"/>

        <input type="submit" value="Cadastrar" />
        <hr>
        <br>
    </form>
         <button onclick="window.location.href='dashboard.php'">Voltar</button>
    <?php
$pdo = new PDO('mysql:host=localhost;dbname=crud', 'root', '');

if (isset($_GET['act']) && $_GET['act'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    exit;
}

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nomecompleto = $_POST['nomecompleto'] ?? '';
        $login = $_POST['login'] ?? '';
        $senha2 = $_POST['senha2'] ?? '';

     if (empty($nomecompleto) || empty($login) || empty($senha2)) {
        echo " Preencha todos os campos pra cadastrar";
    } else {
        try {
            $sql = "INSERT INTO usuarios (nomecompleto, login, senha2 ) VALUES (:nomecompleto, :login, :senha2)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':nomecompleto', $nomecompleto);
            $stmt->bindValue(':login', $login);
            $stmt->bindValue(':senha2', $senha2);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
    ?>
    <h2>Administradores Cadastrados</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome Completo</th>
            <th>Login</th>
            <th>Ações</th>
        </tr>
        <?php
        $sql = "SELECT id, nomecompleto, login FROM usuarios";
        $stmt = $pdo->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nomecompleto']) . "</td>";
            echo "<td>" . htmlspecialchars($row['login']) . "</td>";
            echo "<td>
                    <a href='?act=edit&id=" . ($row['id']) . "'>Editar</a> |
                    <a href='?act=delete&id=" . ($row['id']) . "' onclick=\"return confirm('Tem certeza que deseja excluir?');\">Excluir</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
