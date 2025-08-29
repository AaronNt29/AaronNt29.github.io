<?php
require __DIR__ . '/vendor/autoload.php';

// ✅ Ruta corregida (mail.php está en /config, no en /app/config)
$cfgPath = __DIR__ . '/config/mail.php';
clearstatcache();
if (!is_file($cfgPath)) {
    die("No encuentro la config en: $cfgPath");
}
$cfg = require $cfgPath;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // $mail->SMTPDebug = 2; $mail->Debugoutput = 'html'; // (opcional: depuración)
    $mail->isSMTP();
    $mail->Host       = $cfg['host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $cfg['username'];
    $mail->Password   = $cfg['password'];
    $mail->SMTPSecure = $cfg['secure']; // 'tls' o 'ssl'
    $mail->Port       = $cfg['port'];   // 587 o 465
    $mail->CharSet    = 'UTF-8';

    // Remitente y destinatario
    $mail->setFrom($cfg['from'], $cfg['from_name']);
    $mail->addAddress($cfg['username']); // se envía a sí mismo para la prueba

    // Contenido
    $mail->isHTML(true);
    $mail->Subject = 'Prueba SMTP PHPMailer';
    $mail->Body    = '<b>¡Funciona!</b> Este es un correo de prueba.';
    $mail->AltBody = '¡Funciona! Este es un correo de prueba.';

    $mail->send();
    echo "✅ Correo enviado correctamente", PHP_EOL;
} catch (Exception $e) {
    echo "❌ Error al enviar: " . $mail->ErrorInfo, PHP_EOL;
}
