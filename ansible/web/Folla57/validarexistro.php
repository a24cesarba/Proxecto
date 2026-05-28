<?php
if (isset($_GET['rexistrar'])) {
    $servidor = "db";
    $usuario = "tarefa";
    $passwd = "Tarefa5.7";
    $base = "tarefa5.7";
    try {
        //CONECTAMOS
        $pdo = new PDO("mysql:host=$servidor;dbname=$base;charset=utf8mb4", $usuario, $passwd);
        //Para xerar excepcións cando se informe dun erro
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo "Erro ao conectar co servidor MySQL: " . $e->getMessage();
    }
    $pdoStatement = $pdo->prepare("INSERT into usuarios values(:nome, :contrasinal, :completo, :email, :datacreacion, :rol)");

    $nomestrip = strip_tags($_GET['usuario']);
    $constrip = strip_tags($_GET['contrasinal']);
    $comstrip = strip_tags($_GET['completo']);
    $emailstrip = strip_tags($_GET['email']);
    $data=date("Y-m-d");
    $rol="usuario";
    $conhash=password_hash($constrip, PASSWORD_DEFAULT);
    
    $pdoStatement->bindParam(":nome", $nomestrip);
    $pdoStatement->bindParam(":contrasinal", $conhash);
    $pdoStatement->bindParam(":completo", $comstrip);
    $pdoStatement->bindParam(":email", $emailstrip);
    $pdoStatement->bindParam(":datacreacion", $data);
    $pdoStatement->bindParam(":rol", $rol);
    $pdoStatement->execute();
    header("Location:login.php");
} else {
    header("Location:rexistra.html");
}
?>