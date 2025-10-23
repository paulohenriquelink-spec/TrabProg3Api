<?php

// Configurações de exibição de erros (bom para desenvolvimento)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');

// Inclui o arquivo de conexão compartilhado
require_once 'conexao.php';
$con->set_charset("utf8");

// Obtém os dados JSON enviados no corpo da requisição
$jsonParam = json_decode(file_get_contents('php://input'), true);

// Verifica se o JSON é válido
if (!$jsonParam) {
    echo json_encode(['success' => false, 'message' => 'Dados JSON inválidos ou ausentes.']);
    exit;
}

// Extrai e valida os dados da venda
// (idVenda é AUTO_INCREMENT, então não é incluído aqui)
$produtoVenda = trim($jsonParam['produtoVenda'] ?? '');
$ntFiscal     = trim($jsonParam['ntFiscal'] ?? '');
$precoVenda   = intval($jsonParam['precoVenda'] ?? 0);
$idCliente    = intval($jsonParam['idCliente'] ?? 0);

// Converte a data para o formato Y-m-d do MySQL
$dtVenda      = !empty($jsonParam['dtVenda']) ? date('Y-m-d', strtotime($jsonParam['dtVenda'])) : null;


// Prepara a consulta SQL para inserção
$stmt = $con->prepare("
    INSERT INTO venda (dtVenda, produtoVenda, precoVenda, ntFiscal, idCliente)
    VALUES (?, ?, ?, ?, ?)
");

// Verifica se a preparação da consulta falhou
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Erro ao preparar a consulta: ' . $con->error]);
    exit;
}

/* Define os tipos de parâmetros:
   s = string (dtVenda)
   s = string (produtoVenda)
   i = integer (precoVenda)
   s = string (ntFiscal)
   i = integer (idCliente)
*/
$stmt->bind_param("ssisi", $dtVenda, $produtoVenda, $precoVenda, $ntFiscal, $idCliente);

// Executa a consulta e retorna o resultado
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Venda registrada com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro no registro da venda: ' . $stmt->error]);
}

// Fecha o statement e a conexão
$stmt->close();
$con->close();

?>