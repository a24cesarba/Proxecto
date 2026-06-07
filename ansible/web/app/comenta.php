<?php 
require_once 'session_db.php';
session_start();
if (!isset($_GET['id'])) {
    header("Location:login.php");
    exit;
}
if (isset($_GET['comentar'])) {
    $pdo = getDbConnection();
    try {
        $pdoStatement = $pdo->prepare("INSERT into comentarios(usuario, idProduto, Comentario, dataCreación) values (:usuario, :idProduto, :comentario, :dataCreacion)");
        $usuario = $_SESSION["usuario"];
        $id = $_GET["id"];
        $comentario = strip_tags($_GET["comentario"]);
        $dataC = date("Y-m-d");
        $pdoStatement->bindParam(":usuario", $usuario);
        $pdoStatement->bindParam(":idProduto", $id);
        $pdoStatement->bindParam(":comentario", $comentario);
        $pdoStatement->bindParam(":dataCreacion", $dataC);
        $pdoStatement->execute();
    } catch (Exception $e) {
        header("Location:mostra.php?comentado=2");
        exit;
    }
    header("Location:mostra.php?comentado=1");
    exit;
} ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comenta</title>
    <style>
        body {
            <?php if (isset($_COOKIE['tema'])) {
                if ($_COOKIE['tema'] == 'claro') {
                    echo "background-color: white; color: black;";
                } elseif ($_COOKIE['tema'] == 'escuro') {
                    echo "background-color: black; color: white;";
                }
            } ?>
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .contenedor {
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            margin-bottom: 15px;
        }

        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-weight: bold;
        }

        textarea {
            width: 100%;
            max-width: 400px;
            height: 120px;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            background-color: lightblue;
            border: 1px solid #ccc;
            resize: none;
            /* evita cambiar el tamaño */
            font-family: Arial, sans-serif;
        }

        textarea:focus {
            outline: none;
            border-color: #4CAF50;
        }

        input[type="submit"] {
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        button {
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1e88e5;
        }
    </style>
</head>

<body>

    <div class="contenedor">
        <h1>Escribe tu comentario</h1>
        <form action="comenta.php" method="get">
            <label for="comentario">Comentario:</label>
            <textarea name="comentario" required></textarea>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" name="comentar" value="COMENTAR">
        </form>
        <a href="mostra.php"><button>A MOSTRA</button></a>
        <a href="pechasesion.php"><button>PECHAR SESIÓN</button></a>
    </div>

</body>

</html>