<?php

// Define as credenciais para acessar o banco de dados
$usernameBD = 'root';
$passwordBD = '';

try {
    // Cria uma nova conexão com o banco de dados utilizando o PDO
    $conn = new PDO('mysql:host=localhost;dbname=base_json', $usernameBD, $passwordBD);
    // Define o modo de tratamento de erros como exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Caso ocorra algum erro ao conectar no banco, mostra uma mensagem de erro
    echo 'ERROR: ' . $e->getMessage();
}

?>