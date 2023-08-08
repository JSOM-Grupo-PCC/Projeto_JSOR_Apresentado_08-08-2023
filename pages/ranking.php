<?php
session_start();
require_once('../metodos/sis_cadastro_login/val_sessao.php');
validar_sessao('login.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking</title>
    <link rel="shortcut icon" href="../img/logo_jsor.png" type="image/x-icon">
    <link rel="stylesheet" href="style/comum.css">
    <link rel="stylesheet" href="style/ranking.css">
    <link rel="stylesheet" href="style/media-ranking.css">
</head>
<body>
    <main>
        <section id="logo">
            <img src="../img/logo.png" alt="logo" id="logo_jsor">
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
        </section>
        <section id="podio">
            <div class="left">
                <div class="imagem_ganhador">
                    <img src="../img/prata.png" alt="" class="medalhas" id="prata">
                </div>
                <div class="texto">
                    <strong><p>Nome</p></strong>
                    <p>125 PONTOS</p>
                </div>
            </div>
            <div class="right">
                <div class="imagem_ganhador" id="terceiro_lugar">
                    <img src="../img/bronze.png" alt="" class="medalhas" id="bronze">
                </div>
                <div class="texto">
                    <strong><p>Nome</p></strong>
                    <p>125 PONTOS</p>
                </div>
            </div>
            <div class="imagem_ganhador" id="primeiro_lugar">
                <img src="../img/ouro.png" alt="" class="medalhas" id="ouro">
                <img src="../img/coroa.png" alt="" id="coroa">
            </div>
            <div class="texto" id="vencedor">
                <strong><p>Nome</p></strong>
                <p>125 PONTOS</p>
            </div>
        </section>
        <section id="checkbox">
            <div class="opcaoranking">
                <input type="checkbox" id="powerbuttom">
                <label for="powerbuttom" class="toglle"></label>
            </div>
        </section>
        <section id="lista">
            <div class="colocacao">
                <div id="info">
                    <p>4</p>
                    <div id="foto"></div>
                    <p>Nome</p>
                </div>
                <div id="pontos">
                    <p>XXXX PONTOS</p>
                </div>
            </div>
            <div class="colocacao">
                <div id="info">
                    <p>4</p>
                    <div id="foto"></div>
                    <p>Nome</p>
                </div>
                <div id="pontos">
                    <p>XXXX PONTOS</p>
                </div>
            </div>
            <div class="colocacao">
                <div id="info">
                    <p>4</p>
                    <div id="foto"></div>
                    <p>Nome</p>
                </div>
                <div id="pontos">
                    <p>XXXX PONTOS</p>
                </div>
            </div>
            <div class="colocacao">
                <div id="info">
                    <p>4</p>
                    <div id="foto"></div>
                    <p>Nome</p>
                </div>
                <div id="pontos">
                    <p>XXXX PONTOS</p>
                </div>
            </div>
            <div class="colocacao">
                <div id="info">
                    <p>4</p>
                    <div id="foto"></div>
                    <p>Nome</p>
                </div>
                <div id="pontos">
                    <p>XXXX PONTOS</p>
                </div>
            </div>
            <div class="colocacao">
                <div id="info">
                    <p>4</p>
                    <div id="foto"></div>
                    <p>Nome</p>
                </div>
                <div id="pontos">
                    <p>XXXX PONTOS</p>
                </div>
            </div>
            
        </section>
        <section class="navigation">
            <ul>
                <li class="list">
                    <a href="./perfil.php">
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
                <li class="list active">
                    <a href="<?=$_SERVER['PHP_SELF']?>">
                        <span class="icon">
                            <ion-icon name="podium-sharp"></ion-icon>
                        </span>
                        <span class="text">Rankings</span>
                    </a>
                </li>
                <li class="list">
                    <a href="./adicionarAmigos.php">
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
    <script src="../javascript/dark_nuvem_lista.js"></script>
</body>
</html>