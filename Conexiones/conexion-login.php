<?php
include 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Verificar si el correo electrónico existe
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($contraseña, $user['contraseña'])) {
            // Establecer la sesión
            $_SESSION['user_id'] = $user['id'];

            // Redirigir al usuario a perfil.php después del inicio de sesión exitoso
            header("Location: ../carrito.html");
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('El correo electrónico no está registrado.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
