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
            $response[] = $row;
        }
    } else {
        // Nenhum cliente encontrado
        $response = [];
    }
} else {
     $response = [];
}

// Retorna a resposta em formato JSON
echo json_encode($response);

// Fecha a conexão
$con->close();
?>