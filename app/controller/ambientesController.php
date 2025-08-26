<?php
// O caminho do require_once pode variar dependendo da sua estrutura de pastas
require_once "./app/model/Ambientes.php";
require_once "./app/controller/ApiResonse.php";
require_once "./app/controller/FormValidator.php";

class ambientesController
{
    // Método para criar um ambiente
    public function postAmbiente()
    {
        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        if (is_array($dados_json)) {
            $dados = $dados_json;
        } else {
            $dados = $_POST;
        }


        $requiredFields = [
            'nome_ambiente',
            'num_ambiente',
            'capacidade_ambiente',
            'status_ambiente'
        ];

        FormValidator::FormValidator($dados, $requiredFields);

        try {
            $ambienteCriado = Ambientes::createAmbiente($dados);
            ApiResponse::sendSuccess('Ambiente criado com sucesso.', $ambienteCriado, 201);
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao criar ambiente.', $e->getMessage(), 500);
        }
    }

    // Método para ler todos os ambientes
    public function getAllAmbientes()
    {
        try {
            $ambientes = Ambientes::readAllAmbientes();
            if ($ambientes) {
                ApiResponse::sendSuccess('Ambientes listados com sucesso.', $ambientes);
            } else {
                ApiResponse::sendSuccess('Nenhum ambiente encontrado.', []);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao listar ambientes.', $e->getMessage());
        }
    }

    // Método para ler um ambiente por ID
    public function getAmbienteById($id_ambiente)
    {
        try {
            $ambiente = Ambientes::readOneAmbiente($id_ambiente);
            if ($ambiente) {
                ApiResponse::sendSuccess('Ambiente encontrado.', $ambiente);
            } else {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Ambiente não encontrado.'],
                    404
                );
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao buscar ambiente.', $e->getMessage());
        }
    }

    // Método para atualizar um ambiente
    public function putAmbiente($id_ambiente)
    {
        $json_data = file_get_contents('php://input');
        $dados = json_decode($json_data, true);

        $requiredFields = [
            'nome_ambiente',
            'num_ambiente',
            'capacidade_ambiente',
            'status_ambiente'
        ];

        FormValidator::FormValidator($dados, $requiredFields);

        try {
            $ambiente = Ambientes::readOneAmbiente($id_ambiente);

            if (!$ambiente) {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Ambiente não encontrado.'],
                    404
                );
            }

            $updateSuccess = Ambientes::updateAmbiente($id_ambiente, $dados);

            if ($updateSuccess > 0) {
                $ambienteAtualizado = Ambientes::readOneAmbiente($id_ambiente);
                ApiResponse::sendSuccess('Ambiente atualizado com sucesso', $ambienteAtualizado, 200);
            } else {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Nenhuma alteração foi realizada. Os dados enviados são idênticos aos existentes.'],
                    400
                );
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao atualizar ambiente', $e->getMessage(), 500);
        }
    }

    // Método para deletar um ambiente
    public function delAmbiente($id_ambiente)
    {
        try {
            $ambiente = Ambientes::readOneAmbiente($id_ambiente);

            if (!$ambiente) {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Ambiente não encontrado.'],
                    404
                );
            }

            $deleteSuccess = Ambientes::deleteAmbiente($id_ambiente);

            if ($deleteSuccess) {
                ApiResponse::sendSuccess('Ambiente deletado com sucesso', null, 200);
            } else {
                ApiResponse::sendError('Erro ao excluir ambiente', null, 500);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao excluir ambiente', $e->getMessage(), 500);
        }
    }
}
