<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto si es necesario
$password = ""; // Cambia esto si es necesario
$dbname = "prueba_hacking";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$user = $_POST['username'];
$pass = $_POST['password'];

// Consulta vulnerable a inyección SQL
$sql = "SELECT * FROM usuarios WHERE username = '$user' AND password = '$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Usuario autenticado
    echo "¡Bienvenido, $user!";
    // Mostrar la tabla de usuarios
    mostrarTablaUsuarios($conn);
} else {
    echo "Usuario o contraseña incorrectos.";
}

// Función para mostrar la tabla de usuarios
function mostrarTablaUsuarios($conn) {
    $sql = "SELECT * FROM usuarios";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Tabla de Usuarios</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Usuario</th><th>Contraseña</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["username"]. "</td><td>" . $row["password"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay usuarios registrados.";
    }
}

$conn->close();
?>
