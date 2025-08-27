<?php
// O caminho do require_once pode variar dependendo da sua estrutura de pastas
require_once "./app/model/TiposColaboradores.php";
require_once "./app/controller/ApiResonse.php";

class tipoColaboradoresController
{
    // Método para criar um tipo de colaborador (CREATE)
    public function postTipoColaborador()
    {
        // Lê os dados do corpo da requisição
        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        // Prioriza os dados do JSON. Se não houver, usa $_POST
        if (is_array($dados_json)) {
            $dados = $dados_json;
        } else {
            $dados = $_POST;
        }


        $requiredFields = [
            'nome_tipo_colaborador',
        ];

        FormValidator::FormValidator($dados, $requiredFields);

        try {
            $TipoColaboradorCriado = TiposColaboradores::Create($dados);

            $conn = Database::connection();
            $lastId = $conn->lastInsertId();

            $TipoColaborador = TiposColaboradores::readOne($lastId);
            ApiResponse::sendSuccess('Tipo de colaborador criado com sucesso', $TipoColaborador, 201);
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao criar tipo de colaborador', $e->getMessage(), 500);
        }
    }

    // Método para ler todos os tipos de colaborador (READ ALL)
    public function getAllTiposColaboradores()
    {
        try {
            $TipoColaboradores = TiposColaboradores::readAll();
            if ($TipoColaboradores) {
                ApiResponse::sendSuccess('Lista retornada com sucesso', $TipoColaboradores, 200);
            } else {
                ApiResponse::sendSuccess('Nenhum tipo de colaborador encontrado', [], 200);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao retornar lista', $e->getMessage(), 500);
        }
    }

    // Método para ler um tipo de colaborador por ID (READ ONE)
    public function getTipoColaboradorById($id_tipo_colaborador)
    {
        try {
            $TipoColaborador = TiposColaboradores::ReadOne($id_tipo_colaborador);
            if ($TipoColaborador) {
                ApiResponse::sendSuccess('Tipo de colaborador encontrado com sucesso', $TipoColaborador, 200);
            } else {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Tipo de colaborador não encontrado.'],
                    404
                );
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao buscar tipo de colaborador', $e->getMessage(), 500);
        }
    }

    // Método para atualizar um tipo de colaborador (UPDATE)
    public function putTipoColaboradore($id_tipo_colaborador)
    {
        $json_data = file_get_contents('php://input');
        $dados = json_decode($json_data, true);

        $requiredFields = [
            'nome_tipo_colaborador',
        ];

        FormValidator::FormValidator($dados, $requiredFields);


        try {
            $TipoColaborador = TiposColaboradores::ReadOne($id_tipo_colaborador);

            if (!$TipoColaborador) {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Tipo de colaborador não encontrado.'],
                    404
                );
            }

            $updateSuccess = TiposColaboradores::Update($id_tipo_colaborador, $dados);

            if ($updateSuccess > 0) {
                $TipoColaboradorAtualizado = TiposColaboradores::readOne($id_tipo_colaborador);
                ApiResponse::sendSuccess('Tipo de colaborador atualizado com sucesso', $TipoColaboradorAtualizado, 200);
            } else {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Nenhuma alteração foi realizada. Os dados enviados são idênticos aos existentes.'],
                    400
                );
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao atualizar tipo de colaborador', $e->getMessage(), 500);
        }
    }

    // Método para deletar um tipo de colaborador (DELETE)
    public function delTipoColaborador($id_tipo_colaborador)
    {
        try {
            $TipoColaborador = TiposColaboradores::ReadOne($id_tipo_colaborador);

            if (!$TipoColaborador) {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Tipo de colaborador não encontrado.'],
                    404
                );
            }

            $deleteSuccess = TiposColaboradores::Delete($id_tipo_colaborador);

            if ($deleteSuccess) {
                ApiResponse::sendSuccess('Tipo de colaborador deletado com sucesso', null, 200);
            } else {
                ApiResponse::sendError('Erro ao excluir o tipo de colaborador', null, 500);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao excluir o tipo de colaborador', $e->getMessage(), 500);
        }
    }
}
