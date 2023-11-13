<?php
include 'conexion.php';

function obtenerInventario() {
    $conn = abrirConexion();
    $sql = "SELECT * FROM inventario";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function anadirElemento($nombre, $cantidad, $precio) {
    $conn = abrirConexion();
    $stmt = $conn->prepare("INSERT INTO inventario (nombre, cantidad, precio) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $nombre, $cantidad, $precio);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function eliminarElemento($id) {
    $conn = abrirConexion();
    $stmt = $conn->prepare("DELETE FROM inventario WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion']) && $_POST['accion'] == 'Agregar') {
        anadirElemento($_POST['nombre'], $_POST['cantidad'], $_POST['precio']);
    } elseif (isset($_POST['accion']) && $_POST['accion'] == 'Eliminar') {
        eliminarElemento($_POST['id_eliminar']);
    }
}

$inventario = obtenerInventario();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Inventario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Gestión de Inventario</h2>
    <form method="post" action="inventario.php">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="text" class="form-control" id="precio" name="precio" required>
        </div>
        <button type="submit" class="btn btn-primary" name="accion" value="Agregar">Agregar</button>
    </form>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($inventario->num_rows > 0) {
                while($row = $inventario->fetch_assoc()) {
                    echo "<tr><td>".$row["id"]."</td><td>".$row["nombre"]."</td><td>".$row["cantidad"]."</td><td>".$row["precio"]."</td><td><a href='editar_inventario.php?id=".$row["id"]."' class='btn btn-small btn-warning'>Editar</a> <form method='post' action='inventario.php' style='display: inline;'><input type='hidden' name='id_eliminar' value='".$row["id"]."'><button type='submit' name='accion' value='Eliminar' class='btn btn-small btn-danger'>Eliminar</button></form></td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
