<?php
require_once 'session_db.php';
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["comentado"])) {
    if ($_GET["comentado"] == 1) {
        echo "<script>alert('Comentario enviado');</script>";
    } elseif ($_GET["comentado"] == 2) {
        echo "<script>alert('Comentario no enviado');</script>";
    }
}

$pdo = getDbConnection();

$productos = $pdo->query("SELECT * FROM produto");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mostra</title>

    <style>
        body {
            text-align: center;
            <?php if (isset($_COOKIE['tema'])) {
                if ($_COOKIE['tema'] == 'claro') {
                    echo "background-color: white; color: black;";
                } elseif ($_COOKIE['tema'] == 'escuro') {
                    echo "background-color: black; color: white;";
                }
            } ?>
        }

        #contenedor {
            width: 70%;
            margin: 20px auto;
        }

        .exterior {
            border: 1px solid black;
            display: flex;
            height: 350px;
            font-family: Arial;
            margin-bottom: 15px;
        }

        .intizq,
        .intder {
            width: 50%;
            padding: 10px;
            box-sizing: border-box;
        }

        .intizq {
            overflow-y: auto;
        }

        .caixacom {
            height: 200px;
            overflow-y: auto;
        }

        .com {
            margin: 5px;
        }

        .usu {
            text-align: right;
            color: gray;
            font-style: italic;
        }

        img {
            width: 130px;
            height: 130px;
        }

        hr {
            color: white;
        }
    </style>
</head>

<body>

    <article id="contenedor">

        <?php
        while ($fila = $productos->fetch()) {

            echo "<div class='exterior'>";

            // IZQUIERDA
            echo "<div class='intizq'>
        <img src='/app/almacenamiento/{$fila['imaxe']}'><br>
        <p><b>ID:</b> {$fila['idProduto']}</p>
        <p><b>Nome:</b> {$fila['nome']}</p>
        <p><b>Descrición:</b> {$fila['descricion']}</p>
        <p><b>Familia:</b> {$fila['familia']}</p>
    </div>";

            // DERECHA
            echo "<div class='intder'>
        <p><b>Comentarios:</b></p>
        <div class='caixacom'>";

            $stmt = $pdo->prepare("SELECT * FROM comentarios WHERE idProduto = :id AND moderado='si'");
            $stmt->execute(["id" => $fila["idProduto"]]);

            while ($com = $stmt->fetch()) {
                echo "
        <div class='com'>
            <div>{$com['Comentario']}</div>
            <div class='usu'>{$com['usuario']}</div>
            <hr>
        </div>";
            }

            echo "</div>
        <a href='comenta.php?id={$fila['idProduto']}'><button>Engadir comentario</button></a>
        <a href='imaxe.php'><button>Engadir imaxe</button></a>
    </div>";

            echo "</div>";
        }
        ?>

    </article>

    <?php
    if ($_SESSION["rol"] == "administrador") {
        echo "<a href='xestionacomentarios.php'><button>Xestionar comentarios</button></a>";
    }
    ?>

    <br><br>
    <a href="pechasesion.php"><button>PECHAR SESIÓN</button></a>

</body>

</html>