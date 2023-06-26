<?php
session_start(); // Inicia a sessão
session_destroy(); // Destrói todos os dados registrados na sessão
header('location: ../../pages/login.php'); // Redireciona para a página de login
?>
