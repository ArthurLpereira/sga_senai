<?php

class ApiResponse
{
    /**
     * Envia uma resposta de sucesso no formato JSON.
     *
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     */
    public static function sendSuccess($message, $data = null, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }

    /**
     * Envia uma resposta de erro no formato JSON.
     *
     * @param string $message
     * @param string $error
     * @param int $statusCode
     */
    public static function sendError($message, $error = null, $statusCode = 500)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        echo json_encode([
            'success' => false,
            'message' => $message,
            'error' => $error
        ]);
        exit;
    }

    /**
     * Envia uma resposta de sucesso ou erro mais flexível.
     *
     * @param array $responseArray O array completo de resposta (ex: ['success' => true, 'message' => 'OK'])
     * @param int $statusCode O código de status HTTP
     */
    public static function sendResponse($responseArray, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        echo json_encode($responseArray);
        exit;
    }
}
