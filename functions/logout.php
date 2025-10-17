<?php

session_start();
session_destroy();
setcookie(session_name(''), '', time() - 3600); // Eliminar la cookie de sesión
header('Location: /index.php');

?>