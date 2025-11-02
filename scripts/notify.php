<?php
// notify.php (El único archivo que se ejecuta en la consola)

// 1. Incluimos el archivo que contiene toda la lógica de DB y el bucle.
require __DIR__ . '/info_user_logic.php'; 

// 2. Recibimos el único parámetro necesario: los minutos.
$minutes_threshold = $argv[1] ?? null;

if (empty($minutes_threshold) || !is_numeric($minutes_threshold) || $minutes_threshold <= 0) {
    echo "ERROR: Debes proporcionar el umbral de tiempo (en minutos) como parámetro.\n";
    echo "Uso: php notify.php [MINUTOS]\n"; 
    exit(1);
}

$minutes_threshold = (int)$minutes_threshold;

// 3. Llamamos a la función principal que hace todo el trabajo.
processAlerts($minutes_threshold);
?>