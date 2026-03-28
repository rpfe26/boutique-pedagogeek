<?php
/**
 * Routeur pour le serveur intégré de PHP (php -S)
 * Permet de servir les fichiers statiques s'ils existent,
 * sinon passe la main à WordPress (index.php) pour gérer les permaliens.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

$log = sprintf("[%s] %s - %s\n", date('Y-m-d H:i:s'), $_SERVER['REQUEST_URI'], file_exists(__DIR__ . $uri) ? 'FOUND' : 'MISSING');
file_put_contents(__DIR__ . '/router-debug.log', $log, FILE_APPEND);

// Si le fichier ou dossier existe, on laisse PHP le servir tel quel
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Sinon, on charge l'index de WordPress
require_once __DIR__ . '/index.php';
