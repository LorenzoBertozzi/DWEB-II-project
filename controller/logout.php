<?php
session_start(); // Inicia a sessão
session_destroy(); // Destrói todas as variáveis de sessão
header("Location: ../view/pages/login.php"); // Redireciona para a página de login
exit();
?>