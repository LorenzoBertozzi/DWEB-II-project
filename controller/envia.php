<?php

header('Content-Type: text/html; charset=utf-8');

  //Variáveis
  $nome = addslashes($_POST['nome']);
  $email = addslashes($_POST['email']);
  $mensagem = addslashes($_POST['mensagem']);
  $data_envio = date('d/m/Y');

  $arquivo = "
    <html>
      <p><b>Nome: </b>$nome</p>
      <p><b>E-mail: </b>$email</p>
      <p><b>Mensagem: </b>$mensagem</p>
      <p>Este e-mail foi enviado em <b>$data_envio</b></p>
    </html>
  ";
  
 
  $destino = "contato@delaspraelas.linceonline.com.br";
  $assunto = "Contato pelo Site";

  $headers = "MIME-Version: 1.1\n";
  $headers .= "Content-type: text/html; charset=utf-8\n";
  $headers .= "From: <$destino>\n";
  $headers .= "Return-Path: $destino\n";
  $headers .= "Reply-To: $email\n";
  
  mail($destino, $assunto, $arquivo, $headers);
  echo "<meta http-equiv='refresh' content='10;URL=../site/index.html'>";
?>