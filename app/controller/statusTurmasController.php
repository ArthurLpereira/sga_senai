<?php
include_once "./app/model/StatusTurmas.php";
include_once "./app/controller/ApiResonse.php";

class statusTurmasController
{
    public function postStatusTurmas()
    {
        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        if (is_array($dados_json)) {
            $dados = $dados_json;
        } else {
            $dados = $_POST;
        }


        $requiredFields = [
            'nome_status_turma',
        ];

        FormValidator::FormValidator($dados, $requiredFields);

        try {
            $StatusTurmasCriado = StatusTurmas::create($dados);
            if ($StatusTurmasCriado) {
                $conn = Database::connection();
                $lastId = $conn->lastInsertId();

                $StatusTurmas = StatusTurmas::readOne($lastId);

                ApiResponse::sendSuccess('Status turmas criado com sucesso', $StatusTurmas, 200);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao criar Status turmas', $e->getMessage(), 500);
        }
    }

    public function getAllStatusTurmas()
    {
        try {
            // Chamada ao método padronizado do BaseModel
            $StatusTurmas = StatusTurmas::readAll();
            if ($StatusTurmas) {
                ApiResponse::sendSuccess('Status Turmas listados com sucesso.', $StatusTurmas);
            } else {
                ApiResponse::sendSuccess('Nenhum Status Turmas encontrado.', []);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao listar Status Turmas.', $e->getMessage());
        }
    }

    public function getStatusTurmaById($id_status_turma)
    {
        try {
            // Chamada ao método padronizado do BaseModel
            $StatusTurmas = StatusTurmas::readOne($id_status_turma);
            if ($StatusTurmas) {
                ApiResponse::sendSuccess('Status Turma encontrado.', $StatusTurmas);
            } else {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Status Turma e não encontrado.'],
                    404
                );
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao buscar ambiente.', $e->getMessage());
        }
    }

    public function putStatusTurma($id_status_turma)
    {
        $json_data = file_get_contents('php://input');
        $dados = json_decode($json_data, true);

        $requiredFields = [
            'nome_status_turma',
        ];

        FormValidator::FormValidator($dados, $requiredFields);

        try {
            // Primeiro, verificamos se o ambiente existe
            $ambiente = StatusTurmas::readOne($id_status_turma);

            if (!$ambiente) {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Status turma não encontrado.'],
                    404
                );
                return; // Encerra a execução
            }

            // Chamada ao método padronizado do BaseModel
            $affectedRows = StatusTurmas::update($id_status_turma, $dados);

            // O método execute() para UPDATE retorna o número de linhas afetadas.
            if ($affectedRows > 0) {
                $ambienteAtualizado = StatusTurmas::readOne($id_status_turma);
                ApiResponse::sendSuccess('Status turma atualizado com sucesso', $ambienteAtualizado, 200);
            } else {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Nenhuma alteração foi realizada. Os dados enviados podem ser idênticos aos existentes.'],
                    400
                );
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao atualizar Status turma', $e->getMessage(), 500);
        }
    }

    public function delStatusTurmas($id_status_turma)
    {
        try {
            // Primeiro, verificamos se o ambiente existe
            $StatusTurmas = StatusTurmas::readOne($id_status_turma);

            if (!$StatusTurmas) {
                ApiResponse::sendResponse(
                    ['success' => false, 'message' => 'Status turma não encontrado.'],
                    404
                );
                return; // Encerra a execução
            }

            // Chamada ao método padronizado do BaseModel
            $deleteSuccess = StatusTurmas::delete($id_status_turma);

            if ($deleteSuccess) {
                ApiResponse::sendSuccess('Status turma deletado com sucesso', null, 200);
            } else {
                ApiResponse::sendError('Erro ao excluir Status turma', null, 500);
            }
        } catch (PDOException $e) {
            ApiResponse::sendError('Erro ao excluir Status turma', $e->getMessage(), 500);
        }
    }
}
