<?php
require_once 'conexao.php';

$host = "localhost";
$db = "crud";
$user = "root";
$pass = "";



try {
    $conexao = new PDO(
        "mysql:host=localhost;dbname=VKadega;charset=utf8mb4",
        "root",
        ""
        echo "Conexão bem-sucedida!"
    );
} catch (PDOException $erro) {
    echo "A conexão falhou: " . $erro->getMessage();
}
