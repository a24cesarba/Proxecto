<?php 
require_once 'session_db.php';
session_start();

// Comprobamos si hay sesión iniciada
if (!isset($_SESSION['usuario'])) {
    header("Location:login.php");
    exit();
}

$mensaje = "";

if (isset($_POST['subir'])) {
    
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        
        $nombreArchivo = basename($_FILES['imagen']['name']);
        $nomeph = $_POST["nome"];
        $descph = $_POST["desc"];
        $famph = $_POST["familia"];

        $rutaDestino = '/app/almacenamiento/' . $nombreArchivo;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            
            $pdo = getDbConnection();
            try {
                $pdoStatement = $pdo->prepare("INSERT INTO produto (nome,descricion,familia,imaxe) VALUES (:nomeprod,:descripcion,:familia,:nombre)");
                $pdoStatement->bindParam(":nomeprod", $nomeph);
                $pdoStatement->bindParam(":descripcion", $descph);
                $pdoStatement->bindParam(":familia", $famph);
                $pdoStatement->bindParam(":nombre", $nombreArchivo);
                $pdoStatement->execute();
                
                $mensaje = "<span style='color:green;'>Imagen subida y guardada con éxito.</span>";
            } catch (Exception $e) {
                $mensaje = "<span style='color:red;'>Error al guardar en base de datos.</span>";
            }
            
        } else {
            $mensaje = "<span style='color:red;'>Error al mover la imagen a /app/almacenamiento. Revisa los permisos de la carpeta.</span>";
        }
    } else {
        $mensaje = "<span style='color:red;'>Por favor, selecciona una imagen válida.</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Subir Imagen</title>
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
            margin: 0;
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

        input[type="file"] {
            margin: 15px 0;
            display: block;
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
        <h1>Subir una imagen</h1>
        
        <?php if ($mensaje != "") echo "<p>$mensaje</p>"; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="imagen" accept="image/*" required>
            <label for="nome">Nome de produto: </label>
            <input type="text" name="nome"><br>
            <label for="desc">Descrición de produto: </label>
            <input type="text" name="desc"><br>
            <select name="familia">
                <option value="fruta">Fruta</option>
                <option value="lacteo" selected>Lacteo</option>
            </select><br>
            <input type="submit" method="post" name="subir" value="SUBIR IMAGEN">
        </form>
        
        <br>
        <a href="mostra.php"><button>A MOSTRA</button></a>
    </div>

</body>

</html>