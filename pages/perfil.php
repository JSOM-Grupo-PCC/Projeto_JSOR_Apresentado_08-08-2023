<?php
    session_start();
    require_once('../metodos/sis_cadastro_login/val_sessao.php');
    validar_sessao('login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="shortcut icon" href="../img/logo_jsor.png" type="image/x-icon">
    <link rel="stylesheet" href="./style/perfil.css">
    <script type="module" src="../javascript/dark_nuvem_lista.js"></script>
</head>
<body>
    <main>
        <section id="logo">
            <img src="../img/logo.png" alt="logo">
            <div class="toggleWrapper">
                <input type="checkbox" checked class="dn" id="dn">
                <label for="dn" class="toggle">
                    <span class="toggle__handler">
                        <span class="crater crater--1"></span>
                        <span class="crater crater--2"></span>
                        <span class="crater crater--3"></span>
                    </span>
                    <div id="content" class="hidden">
                        <span class="nuvem"></span>
                    </div>
                    <span class="star star--1"></span>
                    <span class="star star--2" id="star2"></span>
                    <span class="star star--3"></span>
                    <span class="star star--4"></span>
                    <span class="star star--5"></span>
                    <span class="star star--6"></span>
                </label>
            </div>
            <!-- <input type="checkbox" name="" id="switch"> -->
        </section>
        <section id="area_editavel">
            <section id="img_perfil">
                <div id="foto_perfil">

                </div>
            </section>
            <section id="dados_perfil">
                <div id="info_usuario">
                <?php
                    require_once "../metodos/sis_busca_amizade/functions.php";
                    $id = isset($_GET['id']) ? @$_GET['id'] : $_SESSION['id'];
                    get_perfil($conn, $id);
                ?>
                </div>
                <!--<div id="botao_editar_perfil">
                    <button type="submit" id="editar_perfil">Editar Perfil</button>
                </div>-->
            </section>
        </section>
        <section id="area_desempenho">
            <div class="info_desempenho">
                <div id="titulo">Pontos Adquiridos</div>
                <div id="conteudo">Você ainda não possui Pontos</div>
            </div>
            <div class="info_desempenho">
                <div id="titulo">Gráfico Desempenho</div>
                <div id="conteudo">Você ainda não possui Pontos</div>
            </div>
        </section>
        <section class="navigation">
            <ul>
            <li class="list active">
                    <a href="<?=$_SERVER['PHP_SELF']?>">
                        <span class="icon">
                            <ion-icon name="person-circle-sharp"></ion-icon>
                        </span>
                        <span class="text">Perfil</span>
                    </a>
                </li>

                <li class="list">
                    <a href="../index.php">
                        <span class="icon">
                            <ion-icon name="calendar-sharp"></ion-icon>
                        </span>
                        <span class="text">Quadros</span>
                    </a>
                </li>
                <li class="list">
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="podium-sharp"></ion-icon>
                        </span>
                        <span class="text">Rankings</span>
                    </a>
                </li>
                <li class="list">
                    <a href="adicionarAmigos.php">
                        <span class="icon">
                            <ion-icon name="person-add-sharp"></ion-icon>
                        </span>
                        <span class="text">Amigos</span>
                    </a>
                </li>
                <li class="list">
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="notifications-sharp"></ion-icon>
                        </span>
                        <span class="text">Notificações</span>
                    </a>
                </li>
                <li class="list">
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="time"></ion-icon>
                        </span>
                        <span class="text">Recentes</span>
                    </a>
                </li>

                <div class="indicator"></div> 
            </ul>

        </section>

    </main>
    <script src='https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js'></script>
    <script src='https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js'></script>
</body>
</html>

