<?php
require_once 'C:\xampp\htdocs\site\controller\db_connect.php'; // Certifique-se de que o caminho do arquivo está correto

if(!isset($_SESSION)) 
{ 
    session_start(); 
}

function validarCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se todos os dígitos são iguais
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Calcula os dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

if (isset($_POST['btn-cadastrar'])):
    $erros = array();
    $cpf = mysqli_escape_string($connect, $_POST["cpf"]);
    $nome = mysqli_escape_string($connect, $_POST["nome"]);
    $email = mysqli_escape_string($connect, $_POST["email"]);
    $data = mysqli_escape_string($connect, $_POST["data"]);
    $contato = mysqli_escape_string($connect, $_POST["contato"]);
    $senha = MD5(mysqli_escape_string($connect, $_POST["senha"]));

    if (empty($nome) || empty($cpf) || empty($email)|| empty($data) || empty($contato)|| empty($senha)):
        $erros[] = "<script>alert('Os campos nome/cpf/email/data/contato/senha precisam ser preenchidos.')</script>";
    else:
        // Verifica se o e-mail contém '@'
        if (strpos($email, '@') === false) {
            $erros[] = "<script>alert('O e-mail informado não é válido.')</script>";
        }

        // Verifica se o CPF é válido
        if (!validarCPF($cpf)) {
            $erros[] = "<script>alert('O CPF informado não é válido.')</script>";
        }

        if (empty($erros)):
            $sql = "SELECT cpf FROM usuarios WHERE cpf = '$cpf'";
            $resultado = mysqli_query($connect, $sql);

            if (mysqli_num_rows($resultado) > 0):
                $erros[] = "<script>alert('Esse login já existe!')</script>";
            else:
                $sqlInsert = "INSERT INTO usuarios (nome, cpf, email, data, contato, senha, perfil) VALUES ('$nome','$cpf', '$email', '$data','$contato','$senha', 'aluno')";
                $insert = mysqli_query($connect, $sqlInsert);

                if ($insert):
                    echo '<script>alert("Usuário cadastrado com sucesso!"); window.location.href = "index.html";</script>';
                else:
                    $erros[] = "<li>Não foi possível cadastrar o usuário. Tente novamente.</li>";
                endif;
            endif;
        endif;
    endif;
endif;
?>
<!DOCTYPE html>
<html lang="br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Inicial - Delas para Elas</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
  <script src="https://kit.fontawesome.com/67c66657c7.js"></script>
  <script src="../ls/search.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../styles/login-cadastro.css">
 
</head>

<body>
    <?php
      if (! empty ( $erros )):
        foreach ( $erros as $erro ):
          echo $erro ;
        endforeach ;
      endif ;
    ?>

    <div class="login">
      <div class="logo">
        <a href="../pages/index.html">
          <img src="../assets/logo.svg" alt="Logo">
          <h1>Delas Para Elas</h1>
        </a>  
      </div>
      
      <h2>Crie sua conta.</h2>
      
      <form method="POST" action="">
        <input type="text" id="in" name="cpf" class="input" placeholder="CPF">
        <input type="text" id="in" name="nome" class="input" placeholder="Nome completo">
        <input type="text" id="in" name="email" class="input" placeholder="E-mail">
        <input type="date" id="in" name="data" class="input" placeholder="Data de nascimento">
        <input type="text" id="in" name="contato" class="input" placeholder="Telefone"> 
        <input type="password" id="in" name="senha" class="input" placeholder="Senha" required>
        <input type="password" id="in" name="confirmar_senha" class="input" placeholder="Confirmar senha" required>

        <button type ="submit" value ="Cadastrar" id="cadastrar" name ="btn-cadastrar">Cadastrar</button>
      </form>
    </div>
  </body>  
  

  <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("form").addEventListener("submit", function (event) {
            let senha = document.querySelector("input[name='senha']").value;
            let confirmarSenha = document.querySelector("input[name='confirmar_senha']").value;

            if (senha !== confirmarSenha) {
                alert("As senhas não coincidem. Por favor, tente novamente.");
                event.preventDefault(); // Impede o envio do formulário
            }
        });
    });
  </script>
</body>

</html>