<?php

// Configurações de erro (mantidas)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui seu script de conexão
require_once 'conexao.php';
// Garante que a conexão use UTF-8
$con->set_charset("utf8");

// Decodifica a entrada JSON (mantido)
json_decode(file_get_contents('php://input'), true);

// --- AJUSTE PRINCIPAL ---
// A consulta SQL foi atualizada para a tabela 'venda' e suas colunas
$sql = "SELECT idVenda, dtVenda, produtoVenda, precoVenda, ntFiscal, idCliente FROM venda";

$result = $con->query($sql);

$response = [];

// VERIFIQUE AQUI:  provavelmente tinha o erro
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { 
        $response[] = $row; 
    }
} else {
    // --- AJUSTE PRINCIPAL ---
    // A resposta padrão (caso não haja vendas) foi atualizada
    // para corresponder à estrutura da tabela 'venda'
    $response[] = [
        "idVenda" => 0,
        "dtVenda" => "", // ou "0000-00-00"
        "produtoVenda" => "",
        "precoVenda" => 0,
        "ntFiscal" => "",
        "idCliente" => 0
    ];
}

// Define o cabeçalho como JSON com charset UTF-8 (mantido)
header('Content-Type: application/json; charset=utf-8');
// Codifica a resposta preservando caracteres especiais (mantido)
echo json_encode($response, JSON_UNESCAPED_UNICODE); 

$con->close();
?>