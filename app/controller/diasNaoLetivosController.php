<?php
include_once "./app/model/DiasNaoLetivos.php";
include_once "./app/controller/ApiResonse.php";

class DiasNaoLetivosController
{
    public function postDiasNaoLetivo()
    {
        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        if (is_array($dados_json)) {
            $dados = $dados_json;
        } else {
            $dados = $_POST;
        }

        if (
            !isset($dados['data_dia_nao_letivo']) || trim($dados['data_dia_nao_letivo']) === '' ||
            !isset($dados['descricao_dia_nao_letivo']) || trim($dados['descricao_dia_nao_letivo']) === '' ||
            !isset($dados['tipo_feriado_dia_nao_letivo']) || trim($dados['tipo_feriado_dia_nao_letivo']) === ''
        ) {
            ApiResponse::sendResponse([
                'success' => false,
                'message' => 'Dados incompletos. Por favor, preencha todos os campos necessários.',
            ], 400);
        }

        try {
            $DiaNaoLetivoCriado = DiasNaoLetivos::CreateDiaNaoLetivo($dados);
            if ($DiaNaoLetivoCriado) {
                ApiResponse::sendSuccess('Dia não letivo criado com sucesso', $DiaNaoLetivoCriado, 200);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao criar dia não letivo', $e->getMessage(), 500);
        }
    }

    public function getAllDiasNaoLetivos()
    {
        try {
            $DiasNaoLetivos = DiasNaoLetivos::ReadAllDiasNaoLetivos();
            ApiResponse::sendSuccess('Lista retornadada com sucesso', $DiasNaoLetivos, 200);
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao retornar lista', $e->getMessage(), 500);
        }
    }

    public function getDiaNaoLetivoById($id_dia_nao_letivo)
    {
        try {
            $DiaNaoLetivo = DiasNaoLetivos::ReadOneDiaNaoLetivo($id_dia_nao_letivo);

            if ($DiaNaoLetivo) {
                ApiResponse::sendSuccess('Dia não letivo encontrada com sucesso', $DiaNaoLetivo, 200);
            } else {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Dia não letivo não encontrado',
                ], 404);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao buscar dia não letivo', $e->getMessage(), 500);
        }
    }

    public function putDiaNaoLetivo($id_dia_nao_letivo)
    {
        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        if (is_array($dados_json)) {
            $dados = $dados_json;
        } else {
            $dados = $_POST;
        }

        if (
            !isset($dados['data_dia_nao_letivo']) || trim($dados['data_dia_nao_letivo']) === '' ||
            !isset($dados['descricao_dia_nao_letivo']) || trim($dados['descricao_dia_nao_letivo']) === '' ||
            !isset($dados['tipo_feriado_dia_nao_letivo']) || trim($dados['tipo_feriado_dia_nao_letivo']) === ''
        ) {
            ApiResponse::sendResponse([
                'success' => false,
                'message' => 'Dados incompletos. Por favor, preencha todos os campos necessários.',
            ], 400);
        }

        try {
            $DiaNaoLetivo = DiasNaoLetivos::ReadOneDiaNaoLetivo($id_dia_nao_letivo);

            if (!$DiaNaoLetivo) {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Dia não letivo não encontrado'
                ], 404);
            }

            $updateSuccess = DiasNaoLetivos::UpdateDiaNaoLetivo($id_dia_nao_letivo, $dados);

            if ($updateSuccess > 0) {
                $CDiaNaoLetivo = CategoriasCursos::ReadOneTipoCurso($id_dia_nao_letivo);
                ApiResponse::sendSuccess('Dia não letivo alterado com sucesso', $DiaNaoLetivo);
            } else {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Erro ao atualizar Dia não letivo'
                ], 400);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao atualizar Dia não letivo', $e->getMessage(), 500);
        }
    }

    public function delDiaNaoLetivo($id_dia_nao_letivo)
    {
        try {
            $DiasNaoLetivos =  DiasNaoLetivos::ReadOneDiaNaoLetivo($id_dia_nao_letivo);

            if (!$DiasNaoLetivos) {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Categoria de curso não encontrada'
                ], 404);
            }

            $deleteSuccess =  DiasNaoLetivos::DeleteDiasNaoLetivos($id_dia_nao_letivo);


            if ($deleteSuccess) {
                ApiResponse::sendSuccess('Dia não letivo deletado com sucesso', null, 200);
            } else {
                ApiResponse::sendError('Erro ao excluir o dia não letivo', null, 500);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao excluir o dia não letivo', $e->getMessage(), 500);
        }
    }
}
