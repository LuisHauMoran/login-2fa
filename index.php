<?php
session_start();
require_once 'includes/db.php';

/**
 * Secure Login System with Automatic MD5 Migration
 * Sistema de Login Seguro con Migración Automática desde MD5
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Get user by email / Obtener usuario por email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {

        /**
         * 1) If the password is already using password_hash()
         * 1) Si la contraseña ya usa password_hash()
         */
        if (password_verify($password, $user['password'])) {

            // Login successful / Login correcto
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];

            header("Location: admin/index.php");
            exit;
        }

        /**
         * 2) If password is MD5 (legacy) → migrate automatically
         * 2) Si la contraseña es MD5 (vieja) → migrar automáticamente
         */
        if ($user['password'] === md5($password)) {

            // Generate new secure hash / Generar nuevo hash seguro
            $newHash = password_hash($password, PASSWORD_DEFAULT);

            // Update password in DB / Actualizar contraseña en BD
            $update = $pdo->prepare("UPDATE users SET password=? WHERE id=?");
            $update->execute([$newHash, $user['id']]);

            // Login user after migration / Iniciar sesión tras migrar
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];

            header("Location: admin/index.php");
            exit;
        }
    }

    // If nothing matches → wrong login / Si nada coincide → error
    $error = "Correo o contraseña incorrectos.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Inicio de Sesión</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<div class="container">
<div class="card center">

<h1>Iniciar Sesión</h1>

<?php if (!empty($error)): ?>
<p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
<input type="email" name="email" class="input" placeholder="Correo" required>
<input type="password" name="password" class="input" placeholder="Contraseña" required>
<button class="btn">Ingresar</button>
</form>

</div>
</div>
</body>
</html>
