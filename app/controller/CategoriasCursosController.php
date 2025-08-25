<?php

require_once "./app/model/CategoriasCursos.php";
require_once "./app/controller/ApiResonse.php";

class categoriasCursosController
{
    public function postTipoCurso()
    {

        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        if (is_array($dados_json)) {
            $dados = $dados_json;
        } else {
            $dados = $_POST;
        }

        // CORREÇÃO: Validação mais robusta para verificar se o campo está preenchido
        if (!isset($dados['nome_categoria_curso']) || trim($dados['nome_categoria_curso']) === '') {
            ApiResponse::sendResponse([
                'success' => false,
                'message' => 'Dados incompletos. Por favor, preencha todos os campos necessários.',
            ], 400);
        }


        try {
            $TipoCursoCriado = CategoriasCursos::CreateTipoCurso($dados);
            if ($TipoCursoCriado) {
                ApiResponse::sendSuccess('Tipo de curso criado com sucesso', $TipoCursoCriado, 200);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao criar tipo de curso', $e->getMessage(), 500);
        }
    }

    public function getAllTiposCursos()
    {
        try {
            $TiposCursos = CategoriasCursos::ReadAllTiposCursos();
            ApiResponse::sendSuccess('Lista retornadada com sucesso', $TiposCursos, 200);
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao retornar lista', $e->getMessage(), 500);
        }
    }

    public function getTipoCursoById($id_categoria_curso)
    {
        try {
            $CategoriaCurso = CategoriasCursos::ReadOneTipoCurso($id_categoria_curso);

            if ($CategoriaCurso) {
                ApiResponse::sendSuccess('Categoria de curso encontrada com sucesso', $CategoriaCurso, 200);
            } else {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Categoria de curso não encontrada',
                ], 404);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao buscar categoria de curso', $e->getMessage(), 500);
        }
    }
}
