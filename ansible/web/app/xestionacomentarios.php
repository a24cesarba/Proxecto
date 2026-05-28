<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location:login.php");
}
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
if (isset($_GET["aceptar"])) {
    $data = date("Y-m-d");
    $pdoStatement = $pdo->query("update comentarios set moderado='si', dataModeración='$data' where Comentario='" . $_GET["com"] . "'");
    header("Location:xestionacomentarios.php");
}
if (isset($_GET["rexeitar"])) {
    $pdoStatement = $pdo->query("delete from comentarios where Comentario='" . $_GET["com"] . "'");
    header("Location:xestionacomentarios.php");
}
$pdoStatement = $pdo->query("SELECT * from comentarios where moderado='no' order by dataCreación desc");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xestión de comentarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px 0;
            text-align: center;
            <?php if (isset($_COOKIE['tema'])) {
                if ($_COOKIE['tema'] == 'claro') {
                    echo "background-color: #f9f9f9; color: #000;";
                } elseif ($_COOKIE['tema'] == 'escuro') {
                    echo "background-color: #121212; color: #fff;";
                }
            } else {
                echo "background-color: #f9f9f9; color: #000;";
            } ?>
        }

        #contenedor {
            text-align: left;
            width: 70%;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        div {
            background:
                <?php echo (isset($_COOKIE['tema']) && $_COOKIE['tema'] == 'escuro') ? '#1e1e1e' : '#fff'; ?>
            ;
            color:
                <?php echo (isset($_COOKIE['tema']) && $_COOKIE['tema'] == 'escuro') ? '#fff' : '#000'; ?>
            ;
            width: 100%;
            min-height: 100px;
            padding: 15px;
            border: 1px solid
                <?php echo (isset($_COOKIE['tema']) && $_COOKIE['tema'] == 'escuro') ? '#333' : '#ccc'; ?>
            ;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        div form {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        div input[type="submit"] {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            color: #fff;
        }

        div input[name="aceptar"] {
            background-color: #4CAF50;
        }

        div input[name="aceptar"]:hover {
            background-color: #45a049;
        }

        div input[name="rexeitar"] {
            background-color: #f44336;
        }

        div input[name="rexeitar"]:hover {
            background-color: #d32f2f;
        }

        a button {
            margin-top: 15px;
            margin-right: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            background-color: #2196F3;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        a button:hover {
            background-color: #1e88e5;
        }
    </style>

</head>

<body>

    <article id="contenedor">
        <?php
        while ($fila = $pdoStatement->fetch()) {
            echo "<div>" . $fila['Comentario'] . "<form action='xestionacomentarios.php' method='get'><input type='hidden' name='com' value='" . $fila['Comentario'] . "'><input type='submit' name='aceptar' value='ACEPTAR'><input type='submit' name='rexeitar' value='REXEITAR'></form></div>";
        }
        ?>
    </article>
    <a href="pechasesion.php"><button>PECHAR SESIÓN</button></a>
    <a href="mostra.php"><button>IR A MOSTRA</button></a>
</body>

</html>