<?php 
session_start();
require_once('../metodos/sis_cadastro_login/val_sessao.php');
validar_sessao('login.php');
require_once "../metodos/sis_busca_amizade/functions.php"; 
solicitacoes($conn);
header("Location:adicionarAmigos.php");
?>
