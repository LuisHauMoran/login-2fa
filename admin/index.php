<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Redirect if no session / Redirigir si no hay sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

// Get logged user / Obtener usuario logueado
$stmt = $pdo->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$mensaje = "";

/* -----------------------------------------------------
   Activate 2FA / Activar 2FA
----------------------------------------------------- */

if (!$user['twofa_enabled']) {

    if (!isset($_SESSION['temp_secret'])) {
        $_SESSION['temp_secret'] = generarSecreto();
    }

    $secretoTemp = $_SESSION['temp_secret'];
    $qrBase64 = generarQRBase64(generarURLGA($user['email'], $secretoTemp));

    if (isset($_POST['activar_2fa'])) {
        $codigo = $_POST['codigo_2fa'];

        if (validarTOTP($secretoTemp, $codigo)) {
            $stmt = $pdo->prepare("UPDATE users SET twofa_secret=?, twofa_enabled=1 WHERE id=?");
            $stmt->execute([$secretoTemp, $user['id']]);

            unset($_SESSION['temp_secret']);
            $user['twofa_enabled'] = 1;

            $mensaje = "2FA activado correctamente ✅";
        } else {
            $mensaje = "Código incorrecto ❌";
        }
    }
}

/* -----------------------------------------------------
   Deactivate 2FA / Desactivar 2FA
----------------------------------------------------- */

if ($user['twofa_enabled'] && isset($_POST['desactivar_2fa'])) {
    $codigo = $_POST['codigo_desactivar'];

    if (validarTOTP($user['twofa_secret'], $codigo)) {
        $pdo->prepare("UPDATE users SET twofa_secret=NULL, twofa_enabled=0 WHERE id=?")
            ->execute([$user['id']]);

        $user['twofa_enabled'] = 0;
        $mensaje = "2FA desactivado correctamente ✅";
    } else {
        $mensaje = "Código incorrecto ❌";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link rel="stylesheet" href="../assets/css/style.css">

<style>
.modal {display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);}
.modal-content {background:#fff;margin:10% auto;padding:24px;border-radius:16px;max-width:400px;position:relative;}
.close {position:absolute;top:10px;right:15px;font-size:24px;cursor:pointer;}
.qr-box {text-align:center;margin:20px 0;}
</style>
</head>

<body>
<div class="container">
<div class="card center">
<h1>Bienvenido, <?= htmlspecialchars($_SESSION['username']); ?></h1>

<?php if ($mensaje): ?>
<p class="mensaje"><?= $mensaje ?></p>
<?php endif; ?>

<?php if (!$user['twofa_enabled']): ?>
    <p>2FA no está activado. Haz clic para configurarlo:</p>
    <button id="btn2FA" class="btn">Configurar 2FA</button>
<?php else: ?>
    <p>2FA está activado ✔</p>
    <p>Para desactivar introduce el código de 6 dígitos</p>
    <form method="POST">
        <input type="text" name="codigo_desactivar" class="input" placeholder="Código 6 dígitos" required>
        <button type="submit" name="desactivar_2fa" class="btn">Desactivar</button>
    </form>
<?php endif; ?>

<a href="logout.php" class="link">Cerrar sesión</a>
</div>
</div>

<?php if (!$user['twofa_enabled']): ?>
<div id="modal2FA" class="modal">
  <div class="modal-content">
    <span class="close" onclick="modal2FA.style.display='none'">&times;</span>

    <h1>Configurar 2FA</h1>
    <p>Escanea este código QR:</p>

    <div class="qr-box">
        <img src="<?= $qrBase64 ?>" alt="QR">
    </div>

    <p>O usa este código:</p>
    <code><?= $secretoTemp ?></code>

    <form method="POST">
        <input type="text" name="codigo_2fa" class="input" placeholder="Código 6 dígitos" required>
        <button type="submit" name="activar_2fa" class="btn">Activar</button>
    </form>
  </div>
</div>
<?php endif; ?>

<script>
const modal2FA = document.getElementById('modal2FA');
const btn2FA = document.getElementById('btn2FA');

if (btn2FA) btn2FA.onclick = () => modal2FA.style.display = 'block';
window.onclick = e => { if (e.target === modal2FA) modal2FA.style.display = 'none'; };
</script>

</body>
</html>
