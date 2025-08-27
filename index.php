<?php
// Define a constante de URL base para evitar caminhos absolutos
define('URL_BASE', '/sga_senai');

// Inclui o controlador de ambientes
require_once './app/controller/ambientesController.php';
require_once './app/controller/tipoColaboradoresController.php';
require_once './app/controller/CategoriasCursosController.php';
require_once './app/controller/diasNaoLetivosController.php';
require_once './app/controller/statusTurmasController.php';
// Limpa a URI para obter o caminho da rota
$request_uri = str_replace(URL_BASE, '', $_SERVER['REQUEST_URI']);

$controllerAmbiente = new ambientesController();
$controllerTipoColaborador = new tipoColaboradoresController();
$controllerCategoriaCursos = new categoriasCursosController();
$controllerDiaNaoLetivo = new DiasNaoLetivosController();
$controllerStatusTurmas = new statusTurmasController();

header('Content-Type: application/json');


if (substr($request_uri, 0, 1) !== '/') {
    $request_uri = '/' . $request_uri;
}

if ($request_uri == '/ambiente/criar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controllerAmbiente->postAmbiente(); // Rota para o POST da API
} elseif ($request_uri == '/ambiente' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controllerAmbiente->getAllAmbientes();
} elseif (preg_match('/^\/ambiente\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controllerAmbiente->getAmbienteById($matches[1]);
} elseif (preg_match('/^\/ambiente\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    $controllerAmbiente->putAmbiente($matches[1]);
} elseif (preg_match('/^\/ambiente\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $controllerAmbiente->delAmbiente($matches[1]);
} elseif ($request_uri == '/tipocolaborador/criar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controllerTipoColaborador->postTipoColaborador();
} elseif ($request_uri == '/tipocolaborador' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controllerTipoColaborador->getAllTiposColaboradores();
} elseif (preg_match('/^\/tipocolaborador\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controllerTipoColaborador->getTipoColaboradorById($matches[1]);
} elseif (preg_match('/^\/tipocolaborador\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    $controllerTipoColaborador->putTipoColaboradore($matches[1]);
} elseif (preg_match('/^\/tipocolaborador\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $controllerTipoColaborador->delTipoColaborador($matches[1]);
} elseif ($request_uri == '/categoriacurso/criar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controllerCategoriaCursos->postTipoCurso();
} elseif ($request_uri == '/categoriacurso' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controllerCategoriaCursos->getAllTiposCursos();
} elseif (preg_match('/^\/categoriacurso\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controllerCategoriaCursos->getTipoCursoById($matches[1]);
} elseif (preg_match('/^\/categoriacurso\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    $controllerCategoriaCursos->putTipoCurso($matches[1]);
} elseif (preg_match('/^\/categoriacurso\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $controllerCategoriaCursos->delCategoriaCurso($matches[1]);
} elseif ($request_uri == '/dianaoletivo/criar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controllerDiaNaoLetivo->postDiasNaoLetivo();
} elseif ($request_uri == '/dianaoletivo' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controllerDiaNaoLetivo->getAllDiasNaoLetivos();
} elseif (preg_match('/^\/dianaoletivo\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controllerDiaNaoLetivo->getDiaNaoLetivoById($matches[1]);
} elseif (preg_match('/^\/dianaoletivo\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    $controllerDiaNaoLetivo->putDiaNaoLetivo($matches[1]);
} elseif (preg_match('/^\/dianaoletivo\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $controllerDiaNaoLetivo->delDiaNaoLetivo($matches[1]);
} elseif ($request_uri == '/statusturmas/criar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controllerStatusTurmas->postStatusTurmas();
} elseif ($request_uri == '/statusturmas' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controllerStatusTurmas->getAllStatusTurmas();
} elseif (preg_match('/^\/statusturmas\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controllerStatusTurmas->getStatusTurmaById($matches[1]);
} elseif (preg_match('/^\/statusturmas\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    $controllerStatusTurmas->putStatusTurma($matches[1]);
} elseif (preg_match('/^\/statusturmas\/(\d+)$/', $request_uri, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $controllerStatusTurmas->delStatusTurmas($matches[1]);
} else {
    echo 'Página não encontrada';
}
