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

        .btn-success {
            background-color: #2ecc71;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .number {
            font-weight: bold;
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

        /* Estilos para el botón Salvar */
        .btn-salvar {
            background-color: #e74c3c;
            border: none;
        }

        .btn-salvar:hover {
            background-color: #c0392b;
        }

        /* Estilos para el botón Whatsapp Web */
        .btn-whatsapp-web {
            background-color: #2ecc71;
            border: none;
        }

        .btn-whatsapp-web:hover {
            background-color: #27ae60;
        }
        /* Estilos para el botón conf de comentarios*/
        .btn-conf {
            background-color: #8d6e63;
            border: none;
        }

        .btn-conf:hover {
            background-color: #6d4c41;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-4">
        <img src="logowha.png" alt="" width="60" align=right><h2 class="mt-3">Enviar a WhatsApp</h2>
        </div>

        <form action="index.php" method="post">
            <table>
                <!-- Filas para Nombre, Teléfono y Mensaje -->
                <tr>
                    <th>Nombre:</th>
                    <td><input type="text" class="form-control" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" /></td>

                </tr>
                <tr>
                    <th>Teléfono:</th>
                    <td><input type="text" class="form-control" name="telefono" value="<?php echo isset($_POST['telefono']) ? $_POST['telefono'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <th>Mensaje:</th>
                    <td>
                        <textarea class="form-control" name="mensaje" cols="50" rows="6"><?php
                            $comentario = '';

                            $comentarios = array_fill(1, 4, '');
                            if (file_exists("comentarios.sav")) {
                                $cData = file_get_contents("comentarios.sav");
                                if ($cData !== false) {
                                    $tmp = unserialize($cData);
                                    if (is_array($tmp)) {
                                        $comentarios = $tmp + $comentarios;
                                    }
                                }
                            }

                            if (isset($_POST['c1'])) {
                                $comentario = $comentarios[1];
                            } elseif (isset($_POST['c2'])) {
                                $comentario = $comentarios[2];
                            } elseif (isset($_POST['c3'])) {
                                $comentario = $comentarios[3];
                            } elseif (isset($_POST['c4'])) {
                                $comentario = $comentarios[4];
                            }

                            if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
                                $comentario = str_replace("fulanoa", $_POST['nombre'], $comentario);
                            }

                            if (isset($_POST['salvar']) && isset($_POST['mensaje'])) {
                                $comentario = $_POST['mensaje'];
                            }

                            echo trim($comentario);
                            ?></textarea>
                    </td>
                    <td rowspan="4" style="vertical-align: top;">
                        <div class="button-group">
                            <button class='btn btn-small btn-primary' name="c1">C1</button>
                            <button class='btn btn-small btn-primary' name="c2">C2</button>
                            <button class='btn btn-small btn-primary' name="c3">C3</button>
                            <button class='btn btn-small btn-primary' name="c4">C4</button>
                            <a class='btn btn-small btn-primary btn-conf' href='configuracion.php'>Conf.</a>

                        </div>
                    </td>                   
                </tr>
                <tr>
                    <th><button type="submit" class="btn btn-success btn-block btn-salvar" name="salvar">
                            1. Salvar
                        </button>
                    </form>

                    <?php
                    $mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';
                    //$formato1 = str_replace("\r", "<br>", $mensaje);
                    $formato2 = str_replace("\r", "%0A", $mensaje);
                    ?>
                    </th>
                    <td><form target="_blank" name="formulario" method="post" action='https://wa.me/34<?php echo isset($_POST['telefono']) ? (int)$_POST['telefono'] : ''; ?>?text=<?php echo $formato2; ?>'>
                        <button type="submit" value="whatsappWeb" class="btn btn-success btn-block btn-whatsapp-web">2. A Whatsapp Web</button>
                    </form></td>
                </tr> 
                <tr>
                    
                <td colspan="4">
                <div>
    <details>
        <summary style="font-weight: bold; cursor: pointer;">¿Necesitas Ayuda?</summary>
        <p style="font-size: 14px; margin-top: 10px;">
            <strong>¡Bienvenido al formulario de envío de mensajes por WhatsApp!</strong><br><br>
            Aquí tienes cómo funciona:<br>
            1. Ingresa el nombre y el número de teléfono del destinatario.<br>
            2. Escribe un mensaje personalizado o elige uno predefinido con los botones "C1", "C2", "C3" o "C4".<br>
            3. Si ingresaste un nombre, reemplazaremos "fulanoa" en el mensaje por ese nombre.<br>
            4. Usa el botón "1. Salvar" para guardar un mensaje personalizado.<br>
            5. Usa "2. A Whatsapp Web" para ir a WhatsApp Web con el mensaje y el número prellenados.<br><br>
            ¡Listo para enviar tus mensajes de manera rápida y sencilla!
        </p>
    </details>
</div>    
                
             </td> 
        </tr> 

            </table>
        </div>
        
    </body>
</html>
