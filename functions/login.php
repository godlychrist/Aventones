<?php
// /functions/login.php
declare(strict_types=1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../common/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /pages/login.php');
  exit();
}

$cedula   = $_POST['cedula']   ?? '';
$password = $_POST['password'] ?? '';

if ($cedula === '' || $password === '') {
  header('Location: /pages/login.php?err=cred');
  exit();
}

// Busca usuario (estado activa)
$stmt = $conn->prepare(
  "SELECT cedula, name, lastname, userType, password, state
     FROM usuarios
    WHERE cedula = ?
    LIMIT 1"
);
$stmt->bind_param('s', $cedula);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
  // Si no está activa
  if ($row['state'] !== 'activa') {
    header('Location: /pages/login.php?err=inactivo');
    exit();
  }

  // Comparación con MD5 (idealmente usa password_hash en el futuro)
  if (hash('md5', $password) === $row['password']) {
    $_SESSION['cedula']   = $row['cedula'];
    $_SESSION['name']     = $row['name'];
    $_SESSION['lastname'] = $row['lastname'];
    $_SESSION['userType'] = $row['userType'];

    header('Location: /pages/main.php');
    exit();
  }
}

// Credenciales inválidas
header('Location: /pages/login.php?err=cred');
exit();
