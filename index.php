<?php
// Define a constante de URL base para evitar caminhos absolutos
define('URL_BASE', '/sga_senai');

// Inclui o controlador de ambientes
require_once './app/controller/ambientesController.php';

// Limpa a URI para obter o caminho da rota
$request_uri = str_replace(URL_BASE, '', $_SERVER['REQUEST_URI']);
$controller = new ambientesController();

// Verifica se o caminho começa com uma barra, se não, adiciona
if (substr($request_uri, 0, 1) !== '/') {
    $request_uri = '/' . $request_uri;
}

if ($request_uri == '/ambiente/criar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->postAmbiente(); // Rota para o POST da API
} elseif ($request_uri == '/ambiente' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controller->getAllAmbientes();
} elseif (preg_match('/^\/ambiente\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controller->getAmbienteById($matches[1]);
} elseif (preg_match('/^\/ambiente\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    $controller->putAmbiente($matches[1]);
} elseif (preg_match('/^\/ambiente\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $controller->delAmbiente($matches[1]);
} else {
    echo 'Página não encontrada';
}
