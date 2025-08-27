<?php
// O caminho do require_once pode variar dependendo da sua estrutura de pastas
require_once "./app/model/Ambientes.php"; // O model já inclui o BaseModel
require_once "./app/controller/ApiResonse.php";
require_once "./app/controller/FormValidator.php";

class ambientesController
{
    public function postAmbiente()
    {
        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        $dados = is_array($dados_json) ? $dados_json : $_POST;

        $requiredFields = [
            'nome_ambiente',
            'num_ambiente',
            'capacidade_ambiente',
            'status_ambiente'
        ];

        FormValidator::FormValidator($dados, $requiredFields);

        try {
            $success = Ambientes::create($dados);

            if ($success) {
                // Para retornar o objeto recém-criado, pegamos o último ID inserido
                // e buscamos o registro completo.
                $conn = Database::connection(); // Acessa a conexão para pegar o ID
                $lastId = $conn->lastInsertId();
                $ambienteCriado = Ambientes::readOne($lastId);
                ApiResponse::sendSuccess('Ambiente criado com sucesso.', $ambienteCriado, 201);
            } else {
                ApiResponse::sendError('Erro ao criar ambiente.', null, 500);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao criar ambiente.', $e->getMessage(), 500);
        }
    }
    public function getAllAmbientes()
    {
        try {
            // Chamada ao método padronizado do BaseModel
            $ambientes = Ambientes::readAll();
            if ($ambientes) {
                ApiResponse::sendSuccess('Ambientes listados com sucesso.', $ambientes);
            } else {
                ApiResponse::sendSuccess('Nenhum ambiente encontrado.', []);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao listar ambientes.', $e->getMessage());
        }
    }


    public function getAmbienteById($id_ambiente)
    {
        try {
            // Chamada ao método padronizado do BaseModel
            $ambiente = Ambientes::readOne($id_ambiente);
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
            // Primeiro, verificamos se o ambiente existe
            $ambiente = Ambientes::readOne($id_ambiente);

            if (!$ambiente) {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Ambiente não encontrado.'],
                    404
                );
                return; // Encerra a execução
            }

            // Chamada ao método padronizado do BaseModel
            $affectedRows = Ambientes::update($id_ambiente, $dados);

            // O método execute() para UPDATE retorna o número de linhas afetadas.
            if ($affectedRows > 0) {
                $ambienteAtualizado = Ambientes::readOne($id_ambiente);
                ApiResponse::sendSuccess('Ambiente atualizado com sucesso', $ambienteAtualizado, 200);
            } else {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Nenhuma alteração foi realizada. Os dados enviados podem ser idênticos aos existentes.'],
                    400
                );
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao atualizar ambiente', $e->getMessage(), 500);
        }
    }

    /**
     * Método para deletar um ambiente.
     */
    public function delAmbiente($id_ambiente)
    {
        try {
            // Primeiro, verificamos se o ambiente existe
            $ambiente = Ambientes::readOne($id_ambiente);

            if (!$ambiente) {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Ambiente não encontrado.'],
                    404
                );
                return; // Encerra a execução
            }

            // Chamada ao método padronizado do BaseModel
            $deleteSuccess = Ambientes::delete($id_ambiente);

            if ($deleteSuccess) {
                ApiResponse::sendSuccess('Ambiente deletado com sucesso', null, 204);
            } else {
                ApiResponse::sendError('Erro ao excluir ambiente', null, 500);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao excluir ambiente', $e->getMessage(), 500);
        }
    }
}
