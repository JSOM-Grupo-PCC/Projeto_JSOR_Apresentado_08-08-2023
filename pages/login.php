<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                        <p>Bem-vindo(a) de volta</p>
                    </aside>

                </article>

                <article id="formulario">

                    <form action="../metodos/sis_cadastro_login/login.php" method="post">
                        <!--Mensagens de feedback, vem de recuperar senha-->
                        <?php 
                        session_start();
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <div class="group groupEmail">
                            <input required id="iemail" name="email" type="text" class="input vazio">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="iemail">Email</label>
                        </div>

                        <div class="group">
                            <input required name="senha" type="password" class="input" id="isenha">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="isenha">Senha</label>
                        </div>

                        <article id="textoBaixo">
                            <a href="rec_senha.php">Esqueceu a senha?</a>
                        </article>

                </article>

                <div>
                    <article id="cadastar">
                        <input type="submit" value="Login">
                        </form>
                    </article>
                    <article id="textoBaixo">
                        Ainda não possui uma conta?
                    </article>
                    <article id="login" class="cadasLogin">
                        <a href="cadastro.php"><button>Cadastre-se</button></a>
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