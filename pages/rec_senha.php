<?php
session_start(); // Inicia a sessão para utilizar variáveis de sessão
ob_start(); // Inicia o buffer de saída para manipulação de cabeçalhos

use PHPMailer\PHPMailer\PHPMailer; // Importa a classe PHPMailer
use PHPMailer\PHPMailer\SMTP; // Importa a classe SMTP do PHPMailer
use PHPMailer\PHPMailer\Exception; // Importa a classe de exceção do PHPMailer

require '../metodos/sis_cadastro_login/conn.php'; // Requer o arquivo de conexão com o banco de dados
require '../lib/vendor/autoload.php'; // Requer o autoload do PHPMailer

$mail = new PHPMailer(true); // Instancia um novo objeto PHPMailer

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperando a senha</title>
    <link rel="stylesheet" href="style/cadastroLogin.css">
    <link rel="stylesheet" href="style/mediaCadastroLogin.css">
</head>

<body>

    <main id="mainPrincipal">
        <section id="cadastro">
            <div class="centro">

                <article id="logo">
                    <img src="../img/logo.png" alt="Logo">
                </article>

                <article id="topo">

                    <aside id="textoTopo">
                        <p>Esqueceu a sua senha?</p>
                    </aside>

                </article>

                <article id="formulario">

                    <?php
                    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); // Filtra os dados do formulário recebidos via POST

                    if (!empty($dados['SendRecupSenha'])) { // Verifica se o botão de recuperação de senha foi acionado
                        $query_usuario = "SELECT username, prenome, email FROM usuario WHERE email = :email LIMIT 1";
                        $result_usuario = $conn->prepare($query_usuario);
                        $result_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);
                        $result_usuario->execute();

                        if (($result_usuario) && ($result_usuario->rowCount() != 0)) { // Verifica se o email existe no banco de dados
                            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC); // Obtém os dados do usuário

                            // Gera uma chave para recuperação de senha baseada no username
                            $chave_recuperar_senha = substr(hash('sha256', $row_usuario['username']), 0, 32);

                            // Atualiza o campo rec_senha do usuário com a chave de recuperação de senha
                            $query_up_usuario = "UPDATE usuario SET rec_senha = :rec_senha WHERE username = :username LIMIT 1";
                            $result_up_usuario = $conn->prepare($query_up_usuario);
                            $result_up_usuario->bindParam(':rec_senha', $chave_recuperar_senha, PDO::PARAM_STR);
                            $result_up_usuario->bindParam(':username', $row_usuario['username'], PDO::PARAM_STR);

                            if ($result_up_usuario->execute()) { // Verifica se a atualização do campo rec_senha foi realizada com sucesso
                                $link = "http://localhost/Projeto_Back-end/pages/atu_senha.php?chave=$chave_recuperar_senha";

                                try {// Configurações para enviar o email 
                                    $mail->CharSet = 'UTF-8';
                                    $mail->isSMTP();
                                    $mail->Host       = 'sandbox.smtp.mailtrap.io';
                                    $mail->SMTPAuth   = true;
                                    $mail->Username   = '4f4776b1d86e5c';
                                    $mail->Password   = '64724ad6ca72f5';
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port       = 2525;

                                    $mail->setFrom('projetopanelinhaif@gmail.com', 'Atendimento da JSOR');
                                    $mail->addAddress($row_usuario['email'], $row_usuario['prenome']);

                                    $mail->isHTML(true);
                                    $mail->Subject = 'Recuperar senha';
                                    $mail->Body    = "Prezado(a) " . $row_usuario['prenome'] . "<br><br>Você solicitou alteração de senha.<br><br>Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: <br><br><a href='" . $link . "'>" . $link . "</a><br><br>Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";
                                    $mail->AltBody = 'Prezado(a) ' . $row_usuario['prenome'] . "\n\nVocê solicitou alteração de senha.\n\nPara continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: \n\n" . $link . "\n\nSe você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.\n\n";

                                    $mail->send(); // Envia o email com as instruções de recuperação de senha

                                    $_SESSION['msg'] = "<p style='color: green'>Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!</p>";
                                    header("Location: login.php"); // Redireciona para a página de login
                                } catch (Exception $e) {
                                    echo "Erro: E-mail não enviado sucesso. Mailer Error: {$mail->ErrorInfo}";
                                }
                            } else {
                                echo "<p style='color: #ff0000'>Erro: Tente novamente!</p>";
                            }
                        } else {
                            echo "<p style='color: #ff0000'>Erro: E-mail não encontrado!</p>";
                        }
                    }

                    if (isset($_SESSION['msg_rec'])) {
                        echo $_SESSION['msg_rec']; // Exibe a mensagem de recuperação de senha (se existir)
                        unset($_SESSION['msg_rec']); // Remove a mensagem da sessão
                    }
                    ?>

                    <form action="" method="POST">
                        <?php
                        $email = "";
                        if (isset($dados['email'])) {
                            $email = $dados['email'];
                        }
                        ?>
                        <div class="group groupEmail">
                            <input required id="iemail" name="email" type="text" class="input vazio" value="<?php echo $email; ?>">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="iemail">Email</label>
                        </div>

                </article>

                <div>
                    <article id="cadastar">
                        <input type="submit" value="Recuperar" name="SendRecupSenha">
                        </form>
                    </article>
                    <article id="textoBaixo">
                        Lembro?
                    </article>
                    <article id="login" class="cadasLogin">
                        <a href="login.php"><button>Voutar</button></a>
                    </article>
                </div>
            </div>

        </section>

        <section id="imagemLateral">
            <img src="../img/menindaCalendario_clipdrop-enhance.png" alt="Imagem Lateral">
        </section>
    </main>
</body>

</html>

</body>

</html>