<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $direccion = $_POST['direccion'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Hashear la contraseña

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, usuario, correo, contraseña, Apellido_Paterno, Direccion, Apellido_Materno) VALUES (?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssss", $nombre, $usuario, $email, $contraseña, $paterno, $direccion, $materno);

        if ($stmt->execute()) {
            // Redirigir a login.php después de un registro exitoso
            header("Location: ../login.html");
            exit();
        } else {
            echo "Error en la ejecución de la consulta de inserción: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Error al preparar la inserción
        echo "Error en la preparación de la consulta de inserción: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirigir a register.php si no se accede al script mediante POST
    header("Location: ../register.php");
    exit();
}
?>
