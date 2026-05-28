<?php
require_once 'session_db.php';
session_start();
setcookie("tema", $_GET['tema'], time() + 300);

if (isset($_GET['iniciar'])) {
    try {
        $pdo = getDbConnection();

        $nomestrip  = strip_tags($_GET['usuario']);
        $contrastrip = strip_tags($_GET["contrasinal"]);

        $pdoStatement = $pdo->prepare("SELECT * FROM usuarios WHERE nome = :nome");
        $pdoStatement->bindParam(":nome", $nomestrip);
        $pdoStatement->execute();
        $info = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        if (!$info) throw new Exception("Usuario no existe");

        if (password_verify($contrastrip, $info["contrasinal"])) {
            $_SESSION["rol"]     = $info["rol"];
            $_SESSION["usuario"] = $info["nome"];
            session_regenerate_id(true);
            $_SESSION['logueado'] = true;
            header("Location: mostra.php");
            exit;
        } else {
            header("Location: login.php?erro=2");
            exit;
        }
    } catch (Exception $e) {
        header("Location: login.php?erro=1");
        exit;
    }
} else {
    header("Location:login.php");
}
?>