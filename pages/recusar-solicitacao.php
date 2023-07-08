<?php
session_start();
require_once('../metodos/sis_cadastro_login/val_sessao.php');
validar_sessao('login.php');
require_once "../metodos/sis_busca_amizade/functions.php";

$id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
recusar_solicitacao($conn, $id);
$username_de = isset($_SESSION['usaername_de']) ? $_SESSION['usaername_de'] : '';

// Delay de 1 segundo antes do redirecionamento
header("Refresh: 1; URL=perfil.php?pagina=perfil&id={$username_de}");
unset($_SESSION['usaername_de']);
exit();
?>
