<?php
include 'conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: inventario.php');
    exit;
}

$conn = abrirConexion();
$sql = "SELECT * FROM inventario WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
if ($resultado->num_rows == 0) {
    exit('Elemento no encontrado');
}
$item = $resultado->fetch_assoc();
$conn->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    $conn = abrirConexion();
    $stmt = $conn->prepare("UPDATE inventario SET nombre = ?, cantidad = ?, precio = ? WHERE id = ?");
    $stmt->bind_param("sidi", $nombre, $cantidad, $precio, $id);
    $stmt->execute();
    $conn->close();
    header('Location: inventario.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Elemento del Inventario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Editar Elemento del Inventario</h2>
    <form method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $item['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $item['cantidad']; ?>" required>
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $item['precio']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
</body>
</html>
