<?php
require_once "./app/model/Ambientes.php";

class ambientesController
{
    public function postAmbiente()
    {
        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        if ($dados_json !== null) {
            $dados = $dados_json;
        } else {
            $dados = $_POST;
        }

        if (
            !isset($dados['nome_ambiente']) ||
            !isset($dados['num_ambiente']) ||
            !isset($dados['capacidade_ambiente']) ||
            !isset($dados['status_ambiente'])
        ) {
            http_response_code(400); // Bad Request
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Dados incompletos. Por favor, preencha todos os campos necessários.'
            ]);
            exit;
        }

        try {
            $ambienteCriado = Ambientes::CreateAmbiente($dados);

            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode([
                'success' => true,
                'message' => 'Ambiente criado com sucesso',
                'data' => $ambienteCriado
            ]);
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Erro ao criar ambiente',
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function getAllAmbientes()
    {
        try {
            $ambientes = Ambientes::ReadAllAmbientes();

            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode([
                'success' => true,
                'message' => 'Lista retornada com sucesso',
                'data' => $ambientes
            ]);
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json');

            echo json_encode([
                'succes' => false,
                'message' => 'erro ao retornar lista',
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function getAmbienteById($id_ambiente)
    {
        try {
            $ambiente = Ambientes::ReadOneAmbiente($id_ambiente);

            if ($ambiente) {
                http_response_code(200);
                header('Content-Type: application/json');

                echo json_encode([
                    'success' => true,
                    'message' => 'Ambiente encontrado com sucesso',
                    'data' => $ambiente
                ]);
            } else {
                http_response_code(404);
                header('Content-Type: application/json');

                echo json_encode([
                    'success' => false,
                    'message' => 'Ambiente não encontrado'
                ]);
            }
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Erro ao buscar ambiente',
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function putAmbiente($id_ambiente)
    {
        $json_data = file_get_contents('php://input');
        $dados = json_decode($json_data, true);

        if ($dados == null || !isset($dados['nome_ambiente']) || !isset($dados['num_ambiente']) || !isset($dados['capacidade_ambiente']) || !isset($dados['status_ambiente'])) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Dados incompletos, envie todos os campos'
            ]);
            exit;
        }

        try {
            $ambiente = Ambientes::ReadOneAmbiente($id_ambiente);

            if (!$ambiente) {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Ambiente não encontrado'
                ]);
                exit;
            }

            $updateAmbiente = Ambientes::UpdateAmbiente($id_ambiente, $dados);

            if ($updateAmbiente) {
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Ambiente atualizado com sucesso',
                ]);
            } else {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao atualizar o ambiente'
                ]);
            }
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao atualizar o ambiente',
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function delAmbiente($id_ambiente)
    {
        try {
            $ambiente = Ambientes::ReadOneAmbiente($id_ambiente);

            if (!$ambiente) {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Ambiente não encontrado'
                ]);
                exit;
            }

            $deleteSuccess = Ambientes::DeleteAmbiente($id_ambiente);
            if ($deleteSuccess) {
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Ambiente Deletado com sucesso'
                ]);
            } else {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao excluir ambiente'
                ]);
            }
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao excluir ambiente',
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }
}
