<?php
require_once 'session_db.php';
session_start();

// ── Control de acceso: solo administradores ───────────────────────────────────
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// ── CSRF: generar token si no existe ─────────────────────────────────────────
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ── Constantes de validación ──────────────────────────────────────────────────
const MAX_SIZE_BYTES      = 10 * 1024 * 1024; // 10 MB
const EXTENSIONES_VALIDAS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
const MIMES_VALIDOS       = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subir'])) {

    // ── Validar token CSRF ────────────────────────────────────────────────────
    if (empty($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        $mensaje = "<span class='error'>Petición no válida (CSRF).</span>";

    // ── Comprobar que el fichero llegó sin errores ─────────────────────────────
    } elseif (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        $mensaje = "<span class='error'>Erro ao recibir o ficheiro.</span>";

    } else {
        $file    = $_FILES['imagen'];
        $tmpPath = $file['tmp_name'];
        $ext     = strtolower(pathinfo(basename($file['name']), PATHINFO_EXTENSION));

        // ── Validar tamaño ────────────────────────────────────────────────────
        if ($file['size'] > MAX_SIZE_BYTES) {
            $mensaje = "<span class='error'>A imaxe supera o tamaño máximo de 10 MB.</span>";

        // ── Validar extensión (whitelist) ─────────────────────────────────────
        } elseif (!in_array($ext, EXTENSIONES_VALIDAS, true)) {
            $mensaje = "<span class='error'>Tipo de ficheiro non permitido. Usa JPG, PNG, GIF ou WEBP.</span>";

        } else {
            // ── Validar MIME real (contido do ficheiro, non só a extensión) ────
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $tmpPath);
            finfo_close($finfo);

            if (!in_array($mime, MIMES_VALIDOS, true)) {
                $mensaje = "<span class='error'>O contido do ficheiro non corresponde a unha imaxe válida.</span>";

            } else {
                // ── Validar campos de texto obrigatorios ──────────────────────
                $nomeph = strip_tags(trim($_POST['nome']    ?? ''));
                $descph = strip_tags(trim($_POST['desc']    ?? ''));
                $famph  = strip_tags(trim($_POST['familia'] ?? ''));

                if ($nomeph === '' || $famph === '') {
                    $mensaje = "<span class='error'>Nome e familia son obrigatorios.</span>";

                } else {
                    // ── Nome único para evitar colisións e sobreescrituras ─────
                    $nombreFinal = uniqid('img_', true) . '.' . $ext;
                    $rutaDestino = '/app/almacenamiento/imaxes/' . $nombreFinal;

                    if (!move_uploaded_file($tmpPath, $rutaDestino)) {
                        $mensaje = "<span class='error'>Erro ao mover a imaxe. Revisa os permisos da carpeta.</span>";

                    } else {
                        // ── Insertar en base de datos ─────────────────────────
                        try {
                            $pdo  = getDbConnection();
                            $stmt = $pdo->prepare(
                                "INSERT INTO produto (nome, descricion, familia, imaxe)
                                 VALUES (:nome, :descricion, :familia, :imaxe)"
                            );
                            $stmt->execute([
                                ':nome'       => $nomeph,
                                ':descricion' => $descph,
                                ':familia'    => $famph,
                                ':imaxe'      => 'imaxes/' . $nombreFinal,
                            ]);

                            // Rotar token CSRF tras operación exitosa
                            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                            $mensaje = "<span class='ok'>Imaxe subida e gardada con éxito.</span>";

                        } catch (Exception $e) {
                            // Revertir: borrar ficheiro se falla la BD
                            @unlink($rutaDestino);
                            $mensaje = "<span class='error'>Erro ao gardar na base de datos.</span>";
                        }
                    }
                }
            }
        }
    }
}

// ── Helper tema ───────────────────────────────────────────────────────────────
$tema       = $_COOKIE['tema'] ?? 'claro';
$estiloBody = ($tema === 'escuro')
    ? 'background-color: black; color: white;'
    : 'background-color: white; color: black;';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Subir Imagen</title>
    <style>
        body {
            <?= $estiloBody ?>
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

        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"],
        select {
            width: 100%;
            max-width: 400px;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
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

        .error {
            color: #e53935;
            font-weight: bold;
        }

        .ok {
            color: #43a047;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="contenedor">
        <h1>Subir una imagen</h1>

        <?php if ($mensaje !== ''): ?>
            <p><?= $mensaje ?></p>
        <?php endif; ?>

        <form action="imaxe.php" method="POST" enctype="multipart/form-data">

            <!-- Token CSRF oculto -->
            <input type="hidden" name="csrf_token"
                   value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <!-- Límite de tamaño para el navegador (sugerencia, no sustituye la validación PHP) -->
            <input type="hidden" name="MAX_FILE_SIZE" value="<?= MAX_SIZE_BYTES ?>">

            <label for="imagen">Imaxe (JPG, PNG, GIF, WEBP — máx. 10 MB):</label>
            <input type="file" id="imagen" name="imagen"
                   accept="image/jpeg,image/png,image/gif,image/webp" required>

            <label for="nome">Nome do produto:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="desc">Descrición do produto:</label>
            <input type="text" id="desc" name="desc">

            <label for="familia">Familia:</label>
            <select id="familia" name="familia">
                <option value="fruta">Fruta</option>
                <option value="lacteo">Lacteo</option>
            </select>

            <input type="submit" name="subir" value="SUBIR IMAGEN">
        </form>

        <br>
        <a href="mostra.php"><button>A MOSTRA</button></a>
    </div>

</body>

</html>