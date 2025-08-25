<?php
require_once "./app/model/TiposColaboradores.php";

class tipoColaboradoresController
{
    public function postTipoColaborador()
    {
        $json_data = file_get_contents('php://input');
        $dados_json = json_decode($json_data, true);

        if ($dados_json !== null) {
            $dados = $dados_json;
        } else {
            $dados = $_POST;
        }

        if ($dados == null || !isset($dados['nome_tipo_colaborador'])) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Dados incompletos. Por favor, preencha todos os campos necessários'
            ]);
            exit;
        }

        try {
            $TipoColaboradorCriado = TiposColaboradores::CreateTipoColaborador($dados);
            http_response_code(200);
            header('Content-Type: application/json');

            echo json_encode([
                'success' => true,
                'message' => 'Tipo de colaborador criado com sucesso',
                'data' => $TipoColaboradorCriado
            ]);
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Erro ao criar tipo de colaborador',
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function getAllTiposColaboradores()
    {
        try {
            $TipoColaboradores = TiposColaboradores::ReadAllTipoColaborador();
            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode([
                'success' => true,
                'message' => 'Lista retornada com sucesso',
                'data' => $TipoColaboradores
            ]);
            exit;
        } catch (PDOException $e) {
            header('Content-Type: application/json');
            http_response_code(500);

            echo json_encode([
                'success' => false,
                'message' => 'Erro ao retornar lista',
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function getTipoColaboradorById($id_tipo_colaborador)
    {
        try {
            $TipoColaborador = TiposColaboradores::ReadOneTipoColaborador($id_tipo_colaborador);
            if ($TipoColaborador) {
                http_response_code(200);
                header('Content-Type: application/json');

                echo json_encode([
                    'success' => true,
                    'message' => 'Tipo de colaborador encontrado com sucesso',
                    'data' => $TipoColaborador
                ]);
            } else {
                http_response_code(404);
                header('Content-Type: application/json');

                echo json_encode([
                    'success' => true,
                    'message' => 'Tipo de colaborador não encontrado'
                ]);
                exit;
            }
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Erro ao buscar tipo de colaborador',
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function putTipoColaboradore($id_tipo_colaborador)
    {
        $json_data = file_get_contents('php://input');
        $dados = json_decode($json_data, true);

        if ($dados == null || !isset($dados['nome_tipo_colaborador'])) {
            http_response_code(400);
            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Dados incompletos, envie todos os campos'
            ]);
            exit;
        }

        try {
            $TipoColaborador = TiposColaboradores::ReadOneTipoColaborador($id_tipo_colaborador);

            if (!$TipoColaborador) {
                http_response_code(404);
                header('Content-Type: application/json');

                echo json_encode([
                    'success' => false,
                    'message' => 'Tipo de colaborador não encontrado'
                ]);
                exit;
            }

            $updateTipoColaborador = TiposColaboradores::UpdateTipoColaborador($id_tipo_colaborador, $dados);

            if ($updateTipoColaborador) {
                http_response_code(200);
                header('Content-Type: application/json');

                echo json_encode([
                    'success' => true,
                    'message' => 'Tipo de colaborador atualizado com sucesso',
                ]);
            }
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Erro ao atualizar tipo de colaborador',
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function delTipoColaborador($id_tipo_colaborador)
    {
        try {
            $TipoColaborador = TiposColaboradores::ReadOneTipoColaborador($id_tipo_colaborador);

            if (!$TipoColaborador) {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Tipo de colaborador não encontrado'
                ]);
                exit;
            }

            $deleteSuccess = TiposColaboradores::DeleteTipoColaborador($id_tipo_colaborador);
            if ($deleteSuccess) {
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Tipo de colaborador Deletado com sucesso'
                ]);
            } else {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao excluir o tipo de colaborador'
                ]);
            }
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao excluir o tipo de colaborador',
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }
}
