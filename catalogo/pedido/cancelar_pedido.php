<?
include '../../database/conexion.php';
$database = new Database();
$conexion = $database->connect();
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['id'])) {
        $idPedido = $_GET['id'];

        // Utiliza una consulta preparada para evitar inyección SQL
        $sql = "UPDATE pedidos SET estado = 1 WHERE idPedido = ?";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $idPedido);

        if ($stmt->execute()) {
            echo "<script>alert('Cancelación exitosa'); window.location.href = 'verpedidos.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error al cancelar el pedido'); window.location.href = 'verpedidos.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('ID de pedido no proporcionado'); window.location.href = 'verpedidos.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Solicitud no válida'); window.location.href = 'verpedidos.php';</script>";
    exit();
}
?>
