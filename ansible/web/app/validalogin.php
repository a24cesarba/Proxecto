<?php
session_start();
setcookie("tema", $_GET['tema'], time() + 300);

if (isset($_GET['iniciar'])) {
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
    }try {
    $nomestrip = strip_tags($_GET['usuario']);
    $contrastrip = strip_tags($_GET["contrasinal"]);

    $pdoStatement = $pdo->prepare("SELECT * FROM usuarios WHERE nome = :nome");
    $pdoStatement->bindParam(":nome", $nomestrip);
    $pdoStatement->execute();

    $info = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    if (!$info) {
        // Usuario no encontrado -> lanzamos excepción para catch
        throw new Exception("Usuario no existe");
    }

    if (password_verify($contrastrip, $info["contrasinal"])) {
        $_SESSION["rol"] = $info["rol"];
        $_SESSION["usuario"] = $info["nome"];
        session_regenerate_id(true);
        $_SESSION['logueado'] = true;

        header("Location: mostra.php");
        exit;
    } else {
        // Contraseña incorrecta
        header("Location: login.php?erro=2");
        exit;
    }

} catch (Exception $e) {
    // Aquí entrará si hubo un error de BD o usuario no encontrado
    header("Location: login.php?erro=1");
    exit;
}

} else {
    header("Location:login.php");
}
?>