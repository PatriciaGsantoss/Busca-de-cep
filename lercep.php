<?php
header('Content-Type: application/json');

if(isset($_GET['cep'])) {
    $cep = $_GET['cep'];

    // Verifica se o CEP possui o formato correto
    if (preg_match("/^\d{5}-\d{3}$/", $cep)) {
        $url = "https://viacep.com.br/ws/{$cep}/json/";

        // Inicia a requisição HTTP
        $curl = curl_init($url);

         // Configuração da requisição
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

         // Execução da requisição
        $response = curl_exec($curl);
        // Verifica se a requisição foi bem sucedida
    }
    if ($response === false) {
        $responseData = ['error' => 'Erro ao buscar dados do CEP: ' . curl_error($curl)];
    } else {
        // Decodifica a resposta para um formato legível
        $responseData = json_decode($response, true);
        if (isset($responseData['erro'])) {
            $responseData = ['error' => 'CEP não encontrado'];
        }
    }

        // Fecha a requisição
        curl_close($curl);

        // Envia os dados como resposta
        echo json_encode($responseData);
    } else {
        echo json_encode(['error' => 'CEP não fornecido']);
    }



?>
