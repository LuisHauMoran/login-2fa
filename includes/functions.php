<?php
/**
 * Utility Functions for TOTP + QR
 * Funciones utilitarias para TOTP + QR
 */

require_once __DIR__ . '/../vendor/phpqrcode/qrlib.php';

/**
 * Generate a random Base32 secret key
 * Generar un secreto aleatorio en Base32
 */
function generarSecreto($longitud = 16) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    return substr(str_shuffle(str_repeat($chars, $longitud)), 0, $longitud);
}

/**
 * Generate Google Authenticator URL
 * Generar URL para Google Authenticator
 */
function generarURLGA($usuario, $secreto, $app = '2FA Demo - PHP') {
    return "otpauth://totp/{$app}:{$usuario}?secret={$secreto}&issuer={$app}";
}

/**
 * Generate QR in Base64 for <img> tag
 * Generar QR en Base64 para etiqueta <img>
 */
function generarQRBase64($url) {
    ob_start();
    QRcode::png($url, null, QR_ECLEVEL_L, 5);
    return "data:image/png;base64," . base64_encode(ob_get_clean());
}

/**
 * Validate a TOTP code (±30s tolerance)
 * Validar código TOTP (tolerancia ±30s)
 */
function validarTOTP($secret, $codigo) {
    $time = floor(time() / 30);
    for ($i = -1; $i <= 1; $i++) {
        if (generarTOTP($secret, $time + $i) === $codigo) {
            return true;
        }
    }
    return false;
}

/**
 * Generate TOTP code
 * Generar código TOTP
 */
function generarTOTP($secret, $timeSlice) {
    $key  = base32_decode($secret);
    $time = pack('N*', 0) . pack('N*', $timeSlice);
    $hash = hash_hmac('sha1', $time, $key, true);

    $offset = ord($hash[19]) & 0xF;
    $truncated = unpack('N', substr($hash, $offset, 4))[1] & 0x7FFFFFFF;

    return str_pad($truncated % 1000000, 6, '0', STR_PAD_LEFT);
}

/**
 * Decode Base32 string
 * Decodificar cadena Base32
 */
function base32_decode($input) {
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $buffer = '';

    foreach (str_split($input) as $char) {
        $pos = strpos($alphabet, $char);
        if ($pos !== false) $buffer .= sprintf('%05b', $pos);
    }

    $output = '';
    foreach (str_split($buffer, 8) as $byte) {
        if (strlen($byte) === 8) $output .= chr(bindec($byte));
    }

    return $output;
}
?>
