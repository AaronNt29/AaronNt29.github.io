<?php
$password = password_hash("123", PASSWORD_BCRYPT);
echo "Hash generado: " . $password;
?>
