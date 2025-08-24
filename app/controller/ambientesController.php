<?php
require_once "./app/model/Ambientes.php";

class ambientesController
{
    public function postAmbiente()
    {
        // 1. Decodifica os dados JSON da requisição, se houver.
        // `file_get_contents('php://input')` lê o conteúdo do corpo da requisição.
        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        // 2. Verifica se os dados JSON foram decodificados com sucesso.
        if ($dados_json !== null) {
            $dados = $dados_json;
        } else {
            // Se não houver dados JSON, usa o array $_POST (para formulários HTML).
            $dados = $_POST;
        }

        // 3. Validação básica: verifica se todos os campos necessários estão presentes.
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
}
