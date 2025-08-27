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


        $requiredFields = [
            'data_dia_nao_letivo',
            'descricao_dia_nao_letivo',
            'tipo_feriado_dia_nao_letivo',
        ];

        FormValidator::FormValidator($dados, $requiredFields);

        try {
            $DiaNaoLetivoCriado = DiasNaoLetivos::Create($dados);
            if ($DiaNaoLetivoCriado) {
                $conn = Database::connection();
                $lastId = $conn->lastInsertId();

                $novoDiaNaoLetivo = DiasNaoLetivos::readOne($lastId);

                ApiResponse::sendSuccess('Dia não letivo criado com sucesso', $novoDiaNaoLetivo, 200);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao criar dia não letivo', $e->getMessage(), 500);
        }
    }

    public function getAllDiasNaoLetivos()
    {
        try {
            $DiasNaoLetivos = DiasNaoLetivos::ReadAll();
            ApiResponse::sendSuccess('Lista retornadada com sucesso', $DiasNaoLetivos, 200);
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao retornar lista', $e->getMessage(), 500);
        }
    }

    public function getDiaNaoLetivoById($id_dia_nao_letivo)
    {
        try {
            $DiaNaoLetivo = DiasNaoLetivos::readOne($id_dia_nao_letivo);

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

        $requiredFields = [
            'data_dia_nao_letivo',
            'descricao_dia_nao_letivo',
            'tipo_feriado_dia_nao_letivo',
        ];

        FormValidator::FormValidator($dados, $requiredFields);

        try {
            $DiaNaoLetivo = DiasNaoLetivos::ReadOne($id_dia_nao_letivo);

            if (!$DiaNaoLetivo) {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Dia não letivo não encontrado'
                ], 404);
            }

            $updateSuccess = DiasNaoLetivos::update($id_dia_nao_letivo, $dados);

            if ($updateSuccess > 0) {
                $DiaNaoLetivo = DiasNaoLetivos::readOne($id_dia_nao_letivo);
                ApiResponse::sendSuccess('Dia não letivo alterado com sucesso', $DiaNaoLetivo);
            } else {
                ApiResponse::sendResponse([
                    'success' => true,
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
            $DiasNaoLetivos =  DiasNaoLetivos::readOne($id_dia_nao_letivo);

            if (!$DiasNaoLetivos) {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Categoria de curso não encontrada'
                ], 404);
            }

            $deleteSuccess =  DiasNaoLetivos::delete($id_dia_nao_letivo);


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
