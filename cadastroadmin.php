<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Sistema</title>
</head>
<body>
    <form action="?act=save" method="POST" name="form1">
        <h1>Cadastro de Administradores</h1>
        <hr>
        <input type="hidden" name="id">
        <input type="text" name="nomecompleto" placeholder="Nome Completo"/>
        <input type="text" name="login" placeholder="Login"/>
        <input type="password" name="senha2" placeholder="Senha"/>

        <input type="submit" value="salvar" />
        <hr>
        <br>
    </form>
         <button onclick="window.location.href='dashboard.php'">Voltar</button>
    <?php
    $pdo = new PDO('mysql:host=localhost;dbname=VKadega', 'root', '');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nomecompleto = $_POST['nomecompleto'] ?? '';
        $login = $_POST['login'] ?? '';
        $senha2 = $_POST['senha2'] ?? '';

        try {
            $sql = "INSERT INTO usuarios (nomecompleto, login, senha2 ) VALUES (:nomecompleto, :login, :senha2)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':nomecompleto', $nomecompleto);
            $stmt->bindValue(':login', $login);
            $stmt->bindValue(':senha2', $senha2);
            $stmt->execute();
            echo "Cadastro realizado com sucesso!";
        } catch (Exception $e) {
            echo "Erro ao inserir: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
