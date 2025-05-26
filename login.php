<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=crud', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $senha2 = $_POST['senha2'] ?? '';

    $sql = "SELECT * FROM usuarios WHERE login = :login AND senha2 = :senha2";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':login', $login);
    $stmt->bindValue(':senha2', $senha2);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['admin'] = $login;
        header('Location: dashboard.php');
        exit;
    } else {
        $erro = "Login ou senha inválidos!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
</head>
<body>
    <form method="POST">
        <h1>Login Admin</h1>
        <p>Digite seu login e senha para acessar o painel administrativo.</p>
        <input type="text" name="login" placeholder="Login" required>
        <input type="password" name="senha2" placeholder="Senha" required>
        <input type="submit" value="Entrar">
    </form>
    <?php if (!empty($erro)) echo $erro; ?>
</body>
</html>