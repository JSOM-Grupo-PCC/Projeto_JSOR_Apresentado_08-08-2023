<?php
session_start();
require_once('../metodos/sis_cadastro_login/val_sessao.php');
validar_sessao('login.php');
require_once "../metodos/sis_cadastro_login/conn.php";
$sessionUsername = $_SESSION["userLogin"];

// Step 3: Use prepared statements para buscar os dados do usuário
$query = "SELECT * FROM usuario WHERE username = :username";
$stmt = $conn->prepare($query);
$stmt->bindParam(":username", $sessionUsername, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_FILES["fileImg"]["name"])) {
    $username = $_POST["username"];

    // Step 6: Renomeie os arquivos de upload de forma mais segura
    $originalFileName = $_FILES["fileImg"]["name"];
    $randomValue = uniqid(mt_rand(), true); // Valor aleatório baseado no tempo atual
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION); // Obter a extensão do arquivo original

    // Criar um nome único usando sha1 (outras funções hash também podem ser usadas)
    $imageName = sha1($originalFileName . $randomValue) . '.' . $extension;

    $target = "img_perfil/" . $imageName;
    move_uploaded_file($_FILES["fileImg"]["tmp_name"], $target);

    $query = "UPDATE usuario SET img_perfil = :img_perfil WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":img_perfil", $imageName, PDO::PARAM_STR);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();

    header("Refresh: 0.1;");
    exit();
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        </section>
        <section id="area_editavel">
            <section id="img_perfil">
                <div id="foto_perfil">
                    <form class="form" id="form" action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                        <div class="upload">
                            <img src="img_perfil/<?php echo $user['img_perfil']; ?>" id="image">

                            <div class="rightRound" id="upload">
                                <input type="file" name="fileImg" id="fileImg" accept=".jpg, .jpeg, .png">
                                <i class="fa fa-camera"></i>
                            </div>

                            <div class="leftRound" id="cancel" style="display: none;">
                                <i class="fa fa-times"></i>
                            </div>
                            <div class="rightRound" id="confirm" style="display: none;">
                                <input type="submit">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <section id="dados_perfil">
                <div id="info_usuario">
                    <?php
                    require_once "../metodos/sis_busca_amizade/functions.php";
                    $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
                    get_perfil($conn, $id);
                    ?>
                </div>
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
                    <a href="<?= $_SERVER['PHP_SELF'] ?>">
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

    <script type="text/javascript">
      document.getElementById("fileImg").onchange = function(){
        document.getElementById("image").src = URL.createObjectURL(fileImg.files[0]); // Preview new image

        document.getElementById("cancel").style.display = "block";
        document.getElementById("confirm").style.display = "block";

        document.getElementById("upload").style.display = "none";
      }

      var userImage = document.getElementById('image').src;
      document.getElementById("cancel").onclick = function(){
        document.getElementById("image").src = userImage; // Back to previous image

        document.getElementById("cancel").style.display = "none";
        document.getElementById("confirm").style.display = "none";

        document.getElementById("upload").style.display = "block";
      }
    </script>


</body>

</html>