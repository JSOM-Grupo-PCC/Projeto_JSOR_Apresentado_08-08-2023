<?php 
require_once('conn.php');

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Obtém e valida o email fornecido pelo usuário
$senha = $_POST['senha']; // Obtém a senha fornecida pelo usuário

$sql = 'SELECT * FROM usuario WHERE email=:email'; // Query SQL para buscar um usuário com o email informado
$result = $conn->prepare($sql); // Prepara a query SQL para execução
$result->execute(['email' => $email]); // Executa a query SQL, passando o email como parâmetro
$user = $result->fetch(); // Armazena o resultado da query SQL em um array associativo

if (!empty($user)) {
    $senhaCriptografada = substr(hash('sha256', $senha), 0, 32); // Criptografa a senha fornecida pelo usuário 

    if ($senhaCriptografada === $user['senha']) { // Compara a senha criptografada com a senha armazenada no banco de dados
        session_start();
        $_SESSION['username'] = $user['username']; // Armazena o usernome do usuário na sessão
        header('location: ../../pages/index.php'); // Redireciona o usuário para a página inicial
    } else {
        echo '<script>alert("Senha incorreta. Por favor, tente novamente."); window.history.back();</script>';
        exit();
    }
} else {
    echo '<script>alert("Email não encontrado. Por favor, tente novamente."); window.history.back();</script>';
    exit();
}

