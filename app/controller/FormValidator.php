<?php

require_once "./app/controller/ApiResonse.php";

class FormValidator
{

    public static function FormValidator(array $data, array $requiredFields)
    {
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                ApiResponse::sendResponse([
                    'success' => false,
                    'message' => 'Dados incompletos, por favor preencha todos os campos'
                ], 400);
            }
        }
    }
}
