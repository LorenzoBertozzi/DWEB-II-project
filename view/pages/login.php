<?php
require_once 'C:\xampp\htdocs\site\controller\db_connect.php';

if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o usuário já está logado
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    // Redireciona com base no perfil do usuário
    switch ($_SESSION['perfil']) {
        case 'aluno':
            header('Location: inicio_usuario.php');
            exit();
        case 'Administrador':
            header('Location: inicio_administrador.php');
            exit();
        default:
            // Caso o perfil não seja reconhecido, destrói a sessão e redireciona para o login
            session_unset();
            session_destroy();
            header('Location: login.php');
            exit();
    }
}

if (isset($_POST['btn-entrar'])) {
    $erros = array();

    // Sanitização e escape das entradas
    $cpf = mysqli_real_escape_string($connect, trim($_POST['login']));
    $senha = mysqli_real_escape_string($connect, trim($_POST['senha']));

    // Verifica se os campos estão preenchidos
    if (empty($cpf) || empty($senha)) {
        $erros[] = "<script>alert('O campo login/senha precisa ser preenchido');</script>";
    } else {
        // Verifica se o cpf existe no banco de dados
        $sql = "SELECT * FROM usuarios WHERE cpf = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "s", $cpf);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {
            // Existe um registro com o cpf informado
            $dados = mysqli_fetch_assoc($resultado);

            // Verifica se a senha está correta
            if (md5($senha) === $dados['senha']) {
                // Login bem-sucedido
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                $_SESSION['perfil'] = $dados['perfil'];

                switch ($dados['perfil']) {
                    case 'aluno':
                        header('Location: inicio_usuario.php');
                        break;
                    case 'Administrador':
                        header('Location: ../pages/inicio_administrador.php');
                        break;
                    default:
                        // Caso o perfil não seja reconhecido
                        $erros[] = "<script>alert('Perfil de usuário não reconhecido.');</script>";
                        break;
                }
                exit();
            } else {
                // Senha incorreta
                $erros[] = "<script>alert('Senha incorreta.');</script>";
            }
        } else {
            // Login não encontrado
            $erros[] = "<script>alert('Usuário inexistente.');</script>";
        }
    }

    mysqli_close($connect);
}
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
  <link rel="stylesheet" href="../styles/login-cadastro.css">
  <script src="https://kit.fontawesome.com/67c66657c7.js"></script>
  <script src="search.js"></script>
</head>

<body>
<div class="login">
      <div class="logo">
        <a href="../pages/index.html">
          <img src="../assets/logo.svg" alt="Logo">
          <h1>Delas Para Elas</h1>
        </a>  
      </div>

      <h2>Acesse sua conta.</h2>
      <p>Ainda não tem uma? <a href="cadastro.php">Criar uma conta</a></p>

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="text" id="in" name="login" placeholder="CPF">
            <input type="password" id="in" name="senha" placeholder="Senha">
        <button type="submit" name="btn-entrar">Continuar</button>
    </form>
    </div>

  <section>      
</body>

</html>