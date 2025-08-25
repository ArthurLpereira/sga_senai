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
}
