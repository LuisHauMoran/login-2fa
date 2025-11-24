<?php
session_start();
session_destroy();

/**
 * Logout user
 * Cerrar sesión
 */

header("Location: index.php");
exit;
