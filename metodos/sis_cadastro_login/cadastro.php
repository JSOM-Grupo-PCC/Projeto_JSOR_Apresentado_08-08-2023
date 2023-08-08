<?php
//Inicia uma nova sessão
session_start();

//Atribui os valores dos campos de formulário enviados
$prenome = ($_POST['prenome']);
$sobrenome = $_POST['sobrenome'];
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$senha = substr(hash('sha256', $_POST['senha']), 0, 32);
$username = $_POST['username'];

//Verifica se o e-mail inserido possui um formato válido. Caso contrário, exibe uma mensagem de erro em JavaScript e volta para a página anterior.
if (!$email) {
    echo '<script>alert("O formato do e-mail é inválido"); window.history.back();</script>';
    exit();
}

//Verifica se a senha inserida atende a determinados critérios de segurança, tais como possuir no mínimo 8 caracteres. Caso contrário, exibe uma mensagem de erro em JavaScript e volta para a página anterior.
if (strlen($senha) < 8) {
    echo '<script>alert("A senha deve ter pelo menos 8 caracteres."); window.history.back();</script>';
    exit();
}

// inclui o arquivo de conexão com o banco de dados
require_once 'conn.php';

//Realiza uma consulta ao banco de dados para verificar se já existe um usuário cadastrado com o mesmo username ou e-mail inseridos.
$query = $conn->prepare("SELECT * FROM usuario WHERE username=:username OR email=:email");
$query->execute(['username' => $username, 'email' => $email]);
$user = $query->fetch();

//Caso já exista um usuário cadastrado com o mesmo nome ou e-mail inseridos, exibe uma mensagem de erro em JavaScript e volta para a página anterior.
if ($user) {
    if ($user['username'] == $username) {
        echo '<script>alert("Este username já está registrado"); window.history.back();</script>';
    } else {
        echo '<script>alert("Este e-mail já está registrado"); window.history.back();</script>';
    }
    exit();
}

//Caso não exista um usuário cadastrado com o mesmo username ou e-mail inseridos, insere um novo registro na tabela "usuario" do banco de dados com os dados fornecidos.
$query = $conn->prepare("INSERT INTO usuario (username, senha, email, prenome, sobrenome) VALUES (:username, :senha, :email, :prenome, :sobrenome)");
$query->execute(['username' => $username, 'senha' => $senha, 'email' => $email, 'prenome' => $prenome, 'sobrenome' => $sobrenome]);


$_SESSION['id'] = $username;
$_SESSION['userLogin'] = $username;
$_SESSION['email'] = $email;

echo '<script>alert("Registro bem-sucedido"); window.location.href = "../../";</script>';
exit();

?>
