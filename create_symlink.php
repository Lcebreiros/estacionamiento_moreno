<?php
/**
 * Script para crear el symlink de storage sin usar exec()
 * Subir este archivo a la raíz del proyecto y ejecutarlo desde el navegador
 * Luego BORRARLO por seguridad
 */

$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';

// Verificar si ya existe
if (file_exists($link)) {
    if (is_link($link)) {
        echo "✓ El symlink ya existe en: {$link}<br>";
        echo "Apunta a: " . readlink($link) . "<br>";
    } else {
        echo "✗ ERROR: {$link} existe pero NO es un symlink. Por favor eliminalo manualmente primero.<br>";
    }
    exit;
}

// Crear el symlink
if (symlink($target, $link)) {
    echo "✓ ¡Symlink creado exitosamente!<br>";
    echo "Desde: {$link}<br>";
    echo "Hacia: {$target}<br><br>";
    echo "<strong>IMPORTANTE: Ahora BORRAR este archivo (create_symlink.php) por seguridad.</strong>";
} else {
    echo "✗ ERROR: No se pudo crear el symlink.<br>";
    echo "Probablemente el servidor no permite symlinks.<br>";
    echo "Usá la Opción 4 (copiar archivos).<br>";
}
