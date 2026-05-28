<?php
if (isset($_GET['rexistrar'])) {
    require_once 'db.php';
    $pdo = getDbConnection();
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