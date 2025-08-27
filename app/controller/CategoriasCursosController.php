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

        $requiredFields = [
            'nome_categoria_curso',
        ];

        FormValidator::FormValidator($dados, $requiredFields);


        try {
            $TipoCursoCriado = CategoriasCursos::Create($dados);
            if ($TipoCursoCriado) {

                $conn = Database::connection();
                $lastId = $conn->lastInsertId();

                $CategoriaCurso = CategoriasCursos::readOne($lastId);
                ApiResponse::sendSuccess('Tipo de curso criado com sucesso', $CategoriaCurso, 200);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao criar tipo de curso', $e->getMessage(), 500);
        }
    }

    public function getAllTiposCursos()
    {
        try {
            $TiposCursos = CategoriasCursos::ReadAll();
            ApiResponse::sendSuccess('Lista retornadada com sucesso', $TiposCursos, 200);
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao retornar lista', $e->getMessage(), 500);
        }
    }

    public function getTipoCursoById($id_categoria_curso)
    {
        try {
            $CategoriaCurso = CategoriasCursos::readOne($id_categoria_curso);

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

        $requiredFields = [
            'nome_categoria_curso',
        ];

        FormValidator::FormValidator($dados, $requiredFields);

        try {
            $CategoriaCurso = CategoriasCursos::readOne($id_categoria_curso);

            if (!$CategoriaCurso) {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Categoria de curso não encontrada'
                ], 404);
            }

            $updateSuccess = CategoriasCursos::update($id_categoria_curso, $dados);

            if ($updateSuccess > 0) {
                $CategoriaCursoAtualizada = CategoriasCursos::ReadOne($id_categoria_curso);
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
            $CategoriaCurso = CategoriasCursos::ReadOne($id_categoria_curso);

            if (!$CategoriaCurso) {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Categoria de curso não encontrada'
                ], 404);
            }

            $deleteSuccess = CategoriasCursos::delete($id_categoria_curso);

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
