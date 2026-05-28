<?php
require_once 'session_db.php';
session_start();
if (isset($_GET["erro"])) {
    if ($_GET['erro'] == 1) {
        echo "<script>alert('Nome de usuario incorrecto');</script>";
    } elseif ($_GET['erro'] == 2) {
        echo "<script>alert('Contrasinal incorrecto');</script>";
    } elseif ($_GET['erro'] == 0) {
        echo "<script>alert('Inicio de sesión non válido');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>
        /* Estilo general del select */
        select {
            width: 100%;
            max-width: 400px;
            /* igual que tus inputs */
            padding: 8px 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            font-family: Arial, sans-serif;
            font-size: 14px;
            cursor: pointer;
        }

        /* Cambiar el borde al enfocarlo */
        select:focus {
            outline: none;
            border-color: #4CAF50;
        }

        /* Opciones dentro del select (sólo visual) */
        select option {
            padding: 5px;
        }

        /* Si quieres, un pequeño efecto hover sobre el select (solo la caja) */
        select:hover {
            border-color: #2196F3;
        }

        body {
            background: #f2f2f2;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .contenedor {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            margin-bottom: 10px;
        }

        label {
            display: block;
            text-align: left;
            margin-top: 12px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input:focus {
            outline: none;
            border-color: #4CAF50;
        }

        input[type="submit"] {
            margin-top: 20px;
            background: #4CAF50;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background: #45a049;
        }

        button {
            margin-top: 10px;
            width: 100%;
            padding: 8px;
            background: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #1e88e5;
        }
    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Formulario de inicio de sesión</h1>
        <form action="validalogin.php" method="get">
            <label for="usuario">Nome de usuario: </label>
            <input type="text" name="usuario"><br>
            <label for="contrasinal">Contrasinal: </label>
            <input type="password" name="contrasinal"><br>
            <select name="tema">
                <option value="escuro">Escuro</option>
                <option value="claro" selected>Claro</option>
            </select><br>
            <input type="submit" name="iniciar" value="INICIAR SESIÓN">
        </form>
        <a href="pechasesion.php"><button>PECHAR SESIÓN</button></a><br>
        <a href="rexistro.html"><button>IR A REXISTRO</button></a>
    </div>

</body>

</html>