<?php 
session_start();
require_once('../metodos/sis_cadastro_login/val_sessao.php');
validar_sessao('login.php');
require_once "../metodos/sis_busca_amizade/functions.php"; 

$id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
deleta_solicitacao($conn, $id);
$username_para = isset($_SESSION['usaername_para']) ? $_SESSION['usaername_para'] : '';
unset($_SESSION['usaername_para']);
header("Location: perfil.php?pagina=perfil&id={$username_para}");
?>
