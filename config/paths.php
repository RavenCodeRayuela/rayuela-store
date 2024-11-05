<?php
// Obtener el protocolo (http o https) con un operador ternario
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Obtener el nombre del servidor (localhost o el dominio)
$serverName = $_SERVER['SERVER_NAME'];

// Obtener el puerto si no es el predeterminado (80 para HTTP o 443 para HTTPS)
$port = ($_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443') ? ':' . $_SERVER['SERVER_PORT'] : '';

// Obtener el directorio base (ruta relativa al servidor web)
$baseDir = dirname(__DIR__);

// Convertir el separador de directorios a barras normales para URLs
$baseDir = str_replace('\\', '/', substr($baseDir, strpos($baseDir, 'htdocs') + 6));

// Construir la URL completa
$baseURL = $protocol . $serverName . $port . $baseDir;

// Defino las raíces
define('URL_PATH', $baseURL);
define('ROOT_PATH', dirname(__DIR__));
?>