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

    public function putTipoCurso($id_categoria_curso)
    {
        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        if (is_array($dados_json)) {
            $dados = $dados_json;
        } else {
            $dados = $_POST;
        }

        if (!isset($dados['nome_categoria_curso']) || trim($dados['nome_categoria_curso']) === '') {
            ApiResponse::sendResponse([
                'success' => false,
                'message' => 'Dados incompletos. Por favor, preencha todos os campos necessários.',
            ], 400);
        }

        try {
            $CategoriaCurso = CategoriasCursos::ReadOneTipoCurso($id_categoria_curso);

            if (!$CategoriaCurso) {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Categoria de curso não encontrada'
                ], 404);
            }

            $updateSuccess = CategoriasCursos::UpdateTipoCurso($id_categoria_curso, $dados);

            if ($updateSuccess > 0) {
                $CategoriaCursoAtualizada = CategoriasCursos::ReadOneTipoCurso($id_categoria_curso);
                ApiResponse::sendSuccess('Categoria turma alterada com sucesso', $CategoriaCursoAtualizada);
            } else {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Erro ao atualizar Categoria curso'
                ], 400);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao atualizar Categoria curso', $e->getMessage(), 500);
        }
    }

    public function delCategoriaCurso($id_categoria_curso)
    {
        try {
            $CategoriaCurso = CategoriasCursos::ReadOneTipoCurso($id_categoria_curso);

            if (!$CategoriaCurso) {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Categoria de curso não encontrada'
                ], 404);
            }

            $deleteSuccess = CategoriasCursos::DeleteAmbiente($id_categoria_curso);

            if ($deleteSuccess) {
                ApiResponse::sendSuccess('Categoria curso deletada com sucesso', null, 200);
            } else {
                ApiResponse::sendError('Erro ao excluir a categoria de curso', null, 500);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao excluir a categoria de curso', $e->getMessage(), 500);
        }
    }
}
