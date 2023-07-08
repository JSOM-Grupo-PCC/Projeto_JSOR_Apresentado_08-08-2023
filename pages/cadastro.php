<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style/cadastroLogin.css" media="all">
    <link rel="stylesheet" href="style/mediaCadastroLogin.css">
    <link rel="shortcut icon" href="../img/logo_jsor.png" type="image/x-icon">

</head>

<body>
    <main id="mainPrincipal">
        <section id="cadastro">

            <article id="topo">

                <aside id="logo">
                    <img src="../img/logo.png" alt="Logo">
                </aside>

                <aside id="textoTopo">
                    <p>Cadastre-se</p>
                </aside>

            </article>

            <article id="formulario">

                <form action="../metodos/sis_cadastro_login/cadastro.php" method="post" autocomplete="on">
                    <div class="group groupNome">
                        <input required name="prenome" id="iprenome" type="text" class="input" autocomplete="on">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="iprenome">Nome</label>
                    </div>

                    <div class="group groupSobrenome">
                        <input required name="sobrenome" type="text" class="input" id="isobrenome" autocomplete="on">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="isobrenome">Sobrenome</label>
                    </div>

                    <div class="group groupEmail">
                        <input required id="iemail" name="email" type="email" class="input vazio" autocomplete="on">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="iemail" >Email</label>
                    </div>

                    <div class="group groupSenha">
                        <input required name="senha" type="password" class="input" id="isenha" autocomplete="on">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="isenha">Senha</label>
                    </div>

                    <div class="group groupUsername">
                        <input required name="username" id="iusername" type="text" class="input" autocomplete="on">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="iusername">Nome de usuário</label>
                    </div>

            </article>

            <article id="cadastar">
                <input type="submit" value="Cadastrar">
                </form>
            </article>

            <article id="textoBaixo">
                Já possui uma conta?
            </article>

            <article id="login">
                <a href="login.php"><button>Login</button></a>
            </article>

        </section>

        <section id="imagemLateral">
            <img src="../img/menindaCalendario_clipdrop-enhance.png" alt="Imagem Lateral">
        </section>
    </main>
</body>
</html>