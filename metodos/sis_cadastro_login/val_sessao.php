<?php
// define a função verification que recebe um parâmetro $path
function validar_sessao($path)
{
    // verifica se a variável $_SESSION['id'] não existe ou está vazia
    if(!$_SESSION['username']){
        // redireciona para a página definida na variável $path
        header('Location:'. $path);
        // encerra a execução do script
        exit;
    }
}
?>
