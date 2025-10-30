<?php
// /functions/login.php
declare(strict_types=1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../common/connection.php';

// Descubre BASE dinámicamente del path actual (p. ej. /Aventones)
$parts = explode('/', trim($_SERVER['SCRIPT_NAME'] ?? '', '/')); // ['Aventones','functions','login.php']
$BASE  = isset($parts[0]) && $parts[0] !== 'functions' ? '/' . $parts[0] : '';

// Detecta si viene por fetch/AJAX
$accept = $_SERVER['HTTP_ACCEPT'] ?? '';
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) || str_contains($accept, 'application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if ($isAjax) {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'method']);
    exit;
  }
  header('Location: ' . ($BASE ?: '') . '/pages/login.php');
  exit();
}

$cedula   = trim($_POST['cedula']   ?? '');
$password = trim($_POST['password'] ?? '');

if ($cedula === '' || $password === '') {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'cred']);
    exit;
  }
  header('Location: ' . ($BASE ?: '') . '/pages/login.php?err=cred');
  exit();
}

// Buscar usuario por cédula
$stmt = $conn->prepare(
  "SELECT cedula, name, lastname, userType, password, state
     FROM usuarios
    WHERE cedula = ?
    LIMIT 1"
);

if (!$stmt) {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'cred']);
    exit;
  }
  header('Location: ' . ($BASE ?: '') . '/pages/login.php?err=cred');
  exit();
}

$stmt->bind_param('s', $cedula);
$stmt->execute();
$res = $stmt->get_result();

if (!$res || $res->num_rows === 0) {
  // No existe ese usuario
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'nouser']);
    exit;
  }
  header('Location: ' . ($BASE ?: '') . '/pages/login.php?err=nouser');
  exit();
}

$row = $res->fetch_assoc();

// Estado de cuenta
if (!empty($row['state']) && $row['state'] !== 'activa') {
  $err = ($row['state'] === 'pendiente') ? 'pendiente' : 'inactivo';
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => $err]);
    exit;
  }
  header('Location: ' . ($BASE ?: '') . '/pages/login.php?err=' . $err);
  exit();
}

// )
$hash = md5($password);
if ($hash !== (string)$row['password']) {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'cred']);
    exit;
  }
  header('Location: ' . ($BASE ?: '') . '/pages/login.php?err=cred');
  exit();
}

// Login OK
$_SESSION['cedula']   = $row['cedula'];
$_SESSION['name']     = $row['name'];
$_SESSION['lastname'] = $row['lastname'];
$_SESSION['userType'] = $row['userType'];

if ($isAjax) {
  header('Content-Type: application/json');
  echo json_encode(['ok' => true, 'redirect' => ($BASE ?: '') . '/pages/main.php']);
  exit;
}

header('Location: ' . ($BASE ?: '') . '/pages/main.php');
exit();
