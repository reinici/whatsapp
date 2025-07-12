<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp RPC</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="logo.jpg" type="image/jpg">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 800px;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-success {
            background-color: #2ecc71;
            border: none;
        }
        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-salvar {
            background-color: #e74c3c;
            border: none;
        }
        .btn-salvar:hover {
            background-color: #c0392b;
        }

        .btn-conf {
            background-color: #8d6e63;
            border: none;
        }
        .btn-conf:hover {
            background-color: #6d4c41;
        }

        .form-control {
            font-size: 14px;
        }

        .btn-small {
            font-size: 12px;
            width: 100%;
            margin-top: 5px;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<?php
/**********************************************
 * Sección de LÓGICA
 **********************************************/

// Inicializamos variables
$nombre    = isset($_POST['nombre'])    ? trim($_POST['nombre'])    : '';
$telefono  = isset($_POST['telefono'])  ? trim($_POST['telefono'])  : '';
$mensaje   = isset($_POST['mensaje'])   ? trim($_POST['mensaje'])   : '';
$comentario = '';

// Cargamos los comentarios desde el archivo .sav
$comentarios = array();
if (file_exists("comentarios.sav")) {
    $contenido = file_get_contents("comentarios.sav");
    if ($contenido !== false) {
        $comentarios = unserialize($contenido);
        if (!is_array($comentarios)) {
            $comentarios = [];
        }
    }
}

// Función para cargar el comentario según el botón presionado
function cargarComentario($comentarios, $indice) {
    return isset($comentarios[$indice]) ? $comentarios[$indice] : '';
}

// Manejamos la lógica de los botones C1, C2, C3, C4
if (isset($_POST['c1'])) {
    $comentario = cargarComentario($comentarios, 1);
} elseif (isset($_POST['c2'])) {
    $comentario = cargarComentario($comentarios, 2);
} elseif (isset($_POST['c3'])) {
    $comentario = cargarComentario($comentarios, 3);
} elseif (isset($_POST['c4'])) {
    $comentario = cargarComentario($comentarios, 4);
}

// Si el usuario ingresó nombre, reemplazamos "client@"
if (!empty($nombre)) {
    $comentario = str_replace("client@", $nombre, $comentario);
}

// Si se va a salvar, el mensaje actual es el que persiste en el textarea
if (isset($_POST['salvar'])) {
    $comentario = $mensaje; 
}

// Preparamos el enlace de WhatsApp Web (solo si hay un teléfono válido)
$waLink = "";
if (!empty($telefono) && ctype_digit($telefono)) {
    // Cambiamos a WhatsApp Web:
    $waLink = "https://web.whatsapp.com/send?phone=34{$telefono}&text=" . urlencode($mensaje);
}

/**********************************************
 * Fin de la Sección LÓGICA
 **********************************************/
?>

<div class="container">
    <div class="text-center mb-4">
        <img src="logowha.png" alt="Logo" width="60" align="right">
        <h2 class="mt-3">Enviar a WhatsApp</h2>
    </div>

    <!-- Formulario principal -->
    <form action="index.php" method="post">
        <table>
            <tr>
                <th>Nombre:</th>
                <td>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="nombre" 
                        value="<?php echo htmlspecialchars($nombre, ENT_QUOTES); ?>"
                    />
                </td>
            </tr>
            <tr>
                <th>Teléfono:</th>
                <td>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="telefono" 
                        value="<?php echo htmlspecialchars($telefono, ENT_QUOTES); ?>"
                        placeholder="Solo dígitos" 
                    />
                </td>
            </tr>
            <tr>
                <th>Mensaje:</th>
                <td>
                    <textarea 
                        class="form-control" 
                        name="mensaje" 
                        cols="50" 
                        rows="6"
                    ><?php
                        // Si cargamos un cX, $comentario tiene prioridad
                        // En caso de "salvar", el $mensaje es el que va al textarea
                        echo htmlspecialchars(!empty($comentario) ? $comentario : $mensaje, ENT_QUOTES);
                    ?></textarea>
                </td>
                <td rowspan="3" style="vertical-align: top;">
                    <div class="button-group">
                        <button class="btn btn-small btn-primary" name="c1">C1</button>
                        <button class="btn btn-small btn-primary" name="c2">C2</button>
                        <button class="btn btn-small btn-primary" name="c3">C3</button>
                        <button class="btn btn-small btn-primary" name="c4">C4</button>
                        <a class="btn btn-small btn-primary btn-conf" href="configuracion.php">Conf.</a>
                    </div>
                </td>
            </tr>
            <!-- Botón salvar -->
            <tr>
                <th>
                    <button 
                        type="submit" 
                        class="btn btn-success btn-block btn-salvar" 
                        name="salvar"
                    >
                        1. Salvar
                    </button>
                </th>
                <td>
                    <div class="text-center">
                        <?php if (!empty($waLink)): ?>
                            <!-- Enlace a WhatsApp Web solo si el teléfono es válido -->
                            <a 
                                href="<?php echo $waLink; ?>" 
                                target="_blank" 
                                class="btn btn-success" 
                                style="width:400px;"
                            >
                                2. A Whatsapp Web
                            </a>
                        <?php else: ?>
                            <p style="color:red;">
                                Ingresa un teléfono válido para activar el enlace a WhatsApp.
                            </p>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <details>
                        <summary style="font-weight: bold; cursor: pointer;">¿Necesitas Ayuda?</summary>
                        <p style="font-size: 14px; margin-top: 10px;">
                            <strong>¡Bienvenido al formulario de envío de mensajes por WhatsApp!</strong><br><br>
                            Aquí tienes cómo funciona:<br>
                            1. Ingresa el nombre y el número de teléfono del destinatario.<br>
                            2. Escribe un mensaje personalizado o elige uno predefinido con los botones "C1", "C2", "C3" o "C4".<br>
                            3. Si ingresaste un nombre, reemplazaremos "client@" en el mensaje por ese nombre.<br>
                            4. Usa el botón "1. Salvar" para guardar un mensaje personalizado.<br>
                            5. Usa "2. A Whatsapp Web" para ir a WhatsApp Web con el mensaje y el número prellenados (no necesitas la app de escritorio).<br><br>
                            ¡Listo para enviar tus mensajes de manera rápida y sencilla!
                        </p>
                    </details>
                </td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>
