<?php
// Inclui o arquivo de conexão
include 'conexao.php';

// Define o cabeçalho da resposta como JSON
header('Content-Type: application/json');

$response = array();
$data = array();

// Query para selecionar todos os clientes
$sql = "SELECT idCliente, nmCliente, tlCliente FROM cliente  ORDER BY nmCliente";
$result = $con->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Coleta os dados de cada linha
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $response['status'] = 'success';
        $response['data'] = $data;
    } else {
        // Nenhum cliente encontrado
        $response['status'] = 'success';
        $response['message'] = 'Nenhum cliente encontrado.';
        $response['data'] = [];
    }
} else {
    // Erro na execução da consulta
    $response['status'] = 'error';
    $response['message'] = 'Erro na consulta: ' . $con->error;
}

// Retorna a resposta em formato JSON
echo json_encode($response);

// Fecha a conexão
$con->close();
?>