<?php
$comentarios = array_fill(1, 4, '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    for ($i = 1; $i <= 4; $i++) {
        $comentarios[$i] = $_POST["comentario{$i}"];
    }

    // Guardar los comentarios en el archivo
    $data = serialize($comentarios);
    file_put_contents('comentarios.sav', $data);
} elseif (file_exists('comentarios.sav')) {
    // Cargar los comentarios almacenados si existen
    $comentarios = unserialize(file_get_contents('comentarios.sav'));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            width: 80%;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .number {
            font-weight: bold;
        }

        label {
            font-size: 14px;
        }

        .form-control {
            font-size: 14px;
        }
         /* Estilos para el botón Salvar */
         .btn-salvar {
            background-color: #e74c3c;
            border: none;
        }

        .btn-salvar:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Configuración de Comentarios</h2>
        <form action="configuracion.php" method="post">
            <?php for ($i = 1; $i <= 4; $i++) : ?>
                <div class="form-group">
                    <label class="number">Comentario <?php echo $i; ?>:</label>
                    <textarea class="form-control" name="comentario<?php echo $i; ?>" cols="40" rows="3"><?php echo $comentarios[$i]; ?></textarea>
                </div>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary btn-salvar">Salvar</button> 
            <a class='btn btn-primary' href='index.php'>Volver</a>
        </form>
    </div>
</body>
</html>
