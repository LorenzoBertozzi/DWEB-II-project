<?php
require_once 'C:\xampp\htdocs\site\controller\db_connect.php'; 

if(!isset($_SESSION)) 
{ 
    session_start(); 
}
//Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redireciona para o login
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

//Busca o nome do usuário no banco
$sql_usuario = "SELECT nome FROM usuarios WHERE id = ?";
$stmt_usuario = $connect->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $id_usuario);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$usuario = $result_usuario->fetch_assoc();

$nome_usuario = $usuario['nome'];

// Consulta para cursos disponíveis
$sql_cursos_disponiveis = "
    SELECT id, nome, descricao,imagem 
    FROM cursos 
    WHERE id NOT IN (
        SELECT cursos_id 
        FROM cursos_realizados 
        WHERE usuarios_id = ?
    )";
$stmt_cursos_disponiveis = $connect->prepare($sql_cursos_disponiveis);
$stmt_cursos_disponiveis->bind_param("i", $id_usuario);
$stmt_cursos_disponiveis->execute();
$result_cursos_disponiveis = $stmt_cursos_disponiveis->get_result();

// Consulta para cursos realizados
$sql_cursos_realizados = "
    SELECT c.id, c.nome, cr.data_conclusao,cr.status 
    FROM cursos_realizados cr
    JOIN cursos c ON cr.cursos_id = c.id
    WHERE cr.usuarios_id= ?";
$stmt_cursos_realizados = $connect->prepare($sql_cursos_realizados);
$stmt_cursos_realizados->bind_param("i", $id_usuario);
$stmt_cursos_realizados->execute();
$result_cursos_realizados = $stmt_cursos_realizados->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://kit.fontawesome.com/67c66657c7.js"></script>
    <script src="../js/search.js"></script>
</head>

<body>
        <header class="header">
            <nav>
              <div class="logo">
                <a href="index.html" style="color: #FB3192;"><img src="../assets/logo.svg">
                Delas para Elas</a>
              </div>

              <div class="user-info">
              <span class="me-3">Bem-vinda, <strong><?php echo htmlspecialchars($nome_usuario); ?></strong></span>
              <a href="..\..\controller\logout.php" class="btn sair-btn">Sair</a>
              </div>
            </nav>
        </header>
    
         <!-- Seção de Cursos Disponíveis -->
         <section class="container my-5 bg-cursos">
            <h2 class="titulo-cursos">Cursos Disponíveis</h2>
            <div class="row">
                <?php while ($curso = $result_cursos_disponiveis->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                           <!-- Imagem do curso -->
                            <img src="../assets/<?php echo $curso['imagem'];?>" class="card-img-top img-card" alt="Curso <?php echo $curso['nome']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $curso['nome']; ?></h5>
                                <p class="card-text"><?php echo $curso['descricao']; ?></p>
                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalInscricao">Selecionar</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    
        >
      <!-- Seção de Dashboard -->
<section class="container my-5 bg-cursos">
    <h2 class="text-center text-dash">Meus Cursos</h2>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Status</th>
                <th>Data de Conclusão</th>
                <th>Certificado</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($curso_realizado = $result_cursos_realizados->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $curso_realizado['nome']; ?></td>
                    <td><?php echo $curso_realizado['status']; ?></td>
                    <td><?php echo ($curso_realizado['status'] === 'Concluído') ? date('d/m/Y', strtotime($curso_realizado['data_conclusao'])) : 'Em andamento'; ?></td>
                    
                    <td><?php echo ($curso_realizado['status'] === 'Concluído') ? '<a href="certificados/' . $curso_realizado['id'] . '.pdf" target="_blank">Ver Certificado</a>' : 'Aguardando conclusão'; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>
  
    <footer class="rodape" id="contato">
        <div class="rodape-div">

          <div class="rodape-div-1">
            <div class="rodape-div-1-coluna">

              <span><b>Institucional</b></span>
              <p><a href="sobre.html">Sobre nós</a></p>
              <p><a href="#anteriores.html">Anos Anteriores</a></p>
            </div>
          </div>

          <div class="rodape-div-2">
            <div class="rodape-div-2-coluna">

              <span><b>Apoio</b></span>
              <p>CEFET-MG</p>
              <p>DEDC</p>
              <p>Lince</p>
              <p>Programa Mundo Maker</p>
              <p>PET.COMP</p>
              <p>PET.ENCAUT</p>
            </div>
          </div>

          <div class="rodape-div-3">
            <div class="rodape-div-3-coluna">

              <span><b>Links</b></span>
              <p><a href="#instagram">Instagram</a></p>
              <p><a href="#twitter">Twitter</a></p>
            </div>
          </div>

          <div class="rodape-div-4">
            <div class="rodape-div-4-coluna">

              <span><b>Ajuda</b></span>
              <p><a href="#email">E-mail</a></p>
            </div>
          </div>

        </div>
        <p class="rodape-direitos">Copyright © 2024 - Delas para Elas</p>
      </footer>
</body>
<div class="modal fade" id="modalInscricao" tabindex="-1" aria-labelledby="modalInscricaoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalInscricaoLabel">Inscrição Enviada</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        A inscrição foi enviada e está pendente de aprovação, aguarde a confirmação por e-mail.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
</html>