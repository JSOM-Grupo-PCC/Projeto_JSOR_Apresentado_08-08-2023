<?php

session_start();
require_once('../metodos/sis_cadastro_login/val_sessao.php');
validar_sessao('login.php');
require_once "../metodos/sis_busca_amizade/functions.php";


if (isset($_POST['search'])) {
    $search_term = $_POST['search'];

    // Verificando se o termo de pesquisa não está vazio
    if (!empty($search_term)) {
        // Obtendo os resultados da pesquisa
        $results = searchUsers($search_term, $conn);

        // Verificando se a consulta retornou resultados
        if (count($results) > 0) {
            // Exibe os usuários cadastrados
            echo "Usuários Cadastrados: <br>";
            echo "<div class style='box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); padding: 10px; margin-bottom: 10px;'>";
            get_users($conn, $search_term);
            echo "</div>";
        } else {
            echo "Nenhum resultado encontrado";
        }
    } else {
        echo "Digite um nome de usuário para pesquisar";
    }

    echo "<br>";

    // Encerrar o script aqui, pois a resposta será tratada pelo JavaScript
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigos</title>
    <link rel="shortcut icon" href="../img/logo_jsor.png" type="image/x-icon">
    <script type="module" src="../javascript/dark_nuvem_lista.js"></script>
    <link rel="stylesheet" href="./style/adicionarAmigos.css">
</head>

<body>
    <main class="mainPrincipal">
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

        <section id="conteudo">
            <article class="imgConteudo margin">
                <img src="" alt="">
            </article>

            <aritcle class="pesAmigos">
                <div class="input-group margin">
                    <form method="post">
                        <div class="">
                            <input required="" autocomplete="off" class="input" id="inputPesquisa" type="search" name="search" onkeypress="handleKeyPress(event)" oninput="searchUsers(this.value)">
                        </div>
                    </form>

                    <div id="search_results"></div><!--Box onde aparece todos os resutados da pesquisa-->

                    <!--<label class="user-label" id="labelInput">Procurar Amigo</label>

                    <button class="butPesquisa">
                        <ion-icon id="ionButton" name="search-outline"></ion-icon>
                    </button>-->
                </div>
            </aritcle>

            <article class="margin" id="amigos">
                <aside id="tituloListaAmigos">
                    <p>Seus Amigos</p>
                    <ion-icon name="person-add-sharp"></ion-icon>
                </aside>

                <hr>

                <aside>

                    <p style='text-decoration: none !important; color: #83d8ff;'>Solicitações de amizade
                        <?php
                        echo return_total_solicitation($conn); //aparece o numero de solicitações
                        solicitacoes($conn); //onde aparece as solicitações de amizade    
                        ?>
                    </p>


                </aside>


                <!-- <aside id="listaAmigos">
                    <div class="perfil">
                        <img src="#" alt="">
                        <p class="pNomes">Nome</p>
                    </div>
                    <div class="perfil">
                        <img src="#" alt="">
                        <p class="pNomes">Nome</p>
                    </div>
                </aside> -->

            </article>



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
                <li class="list">
                    <a href="./ranking.php">
                        <span class="icon">
                            <ion-icon name="podium-sharp"></ion-icon>
                        </span>
                        <span class="text">Rankings</span>
                    </a>
                </li>
                <li class="list active">
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

    <script>
        /*Pesquisa sem Refresh utilizando ajax*/
        function searchUsers(searchTerm) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("search_results").innerHTML = xhr.responseText;
                }
            };
            xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("search=" + searchTerm);
        }

        function handleKeyPress(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                searchUsers(event.target.value);
            }
        }
    </script>


</body>

</html>