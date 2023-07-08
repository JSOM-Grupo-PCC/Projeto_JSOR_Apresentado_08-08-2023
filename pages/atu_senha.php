<?php
session_start(); // Inicia a sessão para utilizar variáveis de sessão
ob_start(); // Inicia o buffer de saída para manipulação de cabeçalhos
require '../metodos/sis_cadastro_login/conn.php'; // Requer o arquivo de conexão com o banco de dados
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar senha</title>
    <link rel="stylesheet" href="style/cadastroLogin.css">
    <link rel="shortcut icon" href="../img/logo_jsor.png" type="image/x-icon">
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
                        <p>Deseja atualizar sua senha?</p>
                    </aside>

                </article>

                <article id="formulario">

                    <?php
                    $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT); // Obtém o parâmetro 'chave' da URL através do método GET

                    if (!empty($chave)) { // Verifica se a chave não está vazia
                        $query_usuario = "SELECT username FROM usuario WHERE rec_senha = :rec_senha LIMIT 1"; // Consulta para selecionar o nome de usuário do banco de dados onde rec_senha é igual à chave
                        $result_usuario = $conn->prepare($query_usuario); // Prepara a consulta
                        $result_usuario->bindParam(':rec_senha', $chave, PDO::PARAM_STR); // Substitui o parâmetro na consulta
                        $result_usuario->execute(); // Executa a consulta

                        if (($result_usuario) and ($result_usuario->rowCount() != 0)) { // Verifica se a consulta retornou algum resultado
                            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC); // Obtém os dados do usuário como um array associativo
                            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); // Obtém os dados do formulário como um array

                            if (!empty($dados['SendNovaSenha'])) { // Verifica se o botão 'SendNovaSenha' foi acionado
                                $senha_usuario = substr(hash('sha256', $dados['senha_usuario']), 0, 32); // Gera um hash da nova senha usando SHA256 e limita o tamanho para 32 caracteres
                                $recuperar_senha = 'NULL'; // Define 'NULL' para o campo rec_senha

                                $query_up_usuario = "UPDATE usuario SET senha = :senha_usuario, rec_senha = :recuperar_senha WHERE username = :username LIMIT 1"; // Consulta para atualizar a senha do usuário
                                $result_up_usuario = $conn->prepare($query_up_usuario); // Prepara a consulta
                                $result_up_usuario->bindParam(':senha_usuario', $senha_usuario, PDO::PARAM_STR); // Substitui os parâmetros na consulta
                                $result_up_usuario->bindParam(':recuperar_senha', $recuperar_senha);
                                $result_up_usuario->bindParam(':username', $row_usuario['username'], PDO::PARAM_STR);
                                
                                if ($result_up_usuario->execute()) { // Executa a consulta de atualização
                                    $_SESSION['msg'] = "<p style='color: green'>Senha atualizada com sucesso!</p>"; 
                                    header("Location: login.php");
                                } else {
                                    echo "<script>alert('Erro: Tente novamente!'); window.history.back();</script>";
                                }
                            }
                        } else {
                            $_SESSION['msg_rec'] = "<p style='color: #ff0000'>Erro: Link inválido, solicite novo link para atualizar a senha!</p>"; 
                            header("Location: rec_senha.php");
                        }
                    } else {
                        $_SESSION['msg_rec'] = "<p style='color: #ff0000'>Erro: Link inválido, solicite novo link para atualizar a senha!</p>";
                        header("Location: rec_senha.php");
                    }
                    ?>

                    <form action="" method="post">
                        <?php
                        $usuario = "";
                        if (isset($dados['senha_usuario'])) {
                            $usuario = $dados['senha_usuario'];
                        }
                        ?>
                        <div class="group">
                            <input required name="senha_usuario" type="password" class="input" id="isenha" value="<?php echo $usuario; ?>">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="isenha">Nova senha</label>
                        </div>
                </article>

                <div>
                    <article id="cadastar">
                        <input type="submit" value="Atualizar" name="SendNovaSenha">
                        </form>
                    </article>
                    <article id="textoBaixo">
                        Lembro?
                    </article>
                    <article id="login" class="cadasLogin">
                        <a href="login.php"><button>Voltar</button></a>
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