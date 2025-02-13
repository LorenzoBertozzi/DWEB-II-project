<?php
require_once 'C:\xampp\htdocs\site\controller\db_connect.php'; // Certifique-se de que o caminho do arquivo está correto

if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o formulário de adicionar curso foi enviado
if (isset($_POST['btn-adicionar-curso'])) {
    $erros = array();
    $tituloCurso = mysqli_escape_string($connect, $_POST["tituloCurso"]);
    $descricaoCurso = mysqli_escape_string($connect, $_POST["descricaoCurso"]);
    $imagemCurso = mysqli_escape_string($connect, $_POST["imagemCurso"]);

    if (empty($tituloCurso) || empty($descricaoCurso) || empty($imagemCurso)) {
        $erros[] = "<li>Os campos tituloCurso, descricaoCurso, imagemCurso precisam ser preenchidos.</li>";
    } else {
        $sql = "SELECT nome FROM cursos WHERE nome = '$tituloCurso'";
        $resultado = mysqli_query($connect, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            $erros[] = "<script>alert('Esse curso já existe!')</script>";
        } else {
            $sqlInsert = "INSERT INTO cursos (`id`, `nome`, `descricao`, `imagem`) VALUES ('', '$tituloCurso', '$descricaoCurso','$imagemCurso')";
            $insert = mysqli_query($connect, $sqlInsert);

            if ($insert) {
                echo '<script>alert("Curso cadastrado com sucesso!");</script>';
            } else {
                $erros[] = "<li>Não foi possível cadastrar o Curso. Tente novamente.</li>";
            }
        }
    }
}

if (isset($_POST['btn-adicionar-pre-curso'])) {
    $cursoId = mysqli_escape_string($connect, $_POST['cursoIdPre']);
    $linkPreCurso = mysqli_escape_string($connect, $_POST['linkPreCurso']);

    if (empty($linkPreCurso)) {
        $erros[] = "<li>O campo de link do formulário pré-curso precisa ser preenchido.</li>";
    } else {
        $sqlUpdate = "UPDATE cursos SET link_pre_curso = '$linkPreCurso' WHERE id = '$cursoId'";
        $update = mysqli_query($connect, $sqlUpdate);

        if ($update) {
            echo '<script>alert("Link do formulário pré-curso adicionado com sucesso!");</script>';
        } else {
            $erros[] = "<li>Não foi possível adicionar o link do formulário pré-curso. Tente novamente.</li>";
        }
    }
}

if (isset($_POST['btn-adicionar-pos-curso'])) {
    $cursoId = mysqli_escape_string($connect, $_POST['cursoIdPos']);
    $linkPosCurso = mysqli_escape_string($connect, $_POST['linkPosCurso']);

    if (empty($linkPosCurso)) {
        $erros[] = "<li>O campo de link do formulário pós-curso precisa ser preenchido.</li>";
    } else {
        $sqlUpdate = "UPDATE cursos SET link_pos_curso = '$linkPosCurso' WHERE id = '$cursoId'";
        $update = mysqli_query($connect, $sqlUpdate);

        if ($update) {
            echo '<script>alert("Link do formulário pós-curso adicionado com sucesso!");</script>';
        } else {
            $erros[] = "<li>Não foi possível adicionar o link do formulário pós-curso. Tente novamente.</li>";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/inicio_user.css">
    <script src="https://kit.fontawesome.com/67c66657c7.js"></script>
</head>

<body>
    <!-- Cabeçalho -->
    <header>
        <nav>
            <div class="logo">
                <a href="index.html" style="color: #FB3192">
                    <img src="../assets/logo.svg">
                    Delas para Elas
                </a>
            </div>
            <div class="user-info">
                <span class="me-3">Bem-vindo, <strong>Administrador</strong></span>
                <a href="..\..\controller\logout.php" class="btn sair-btn">Sair</a>
            </div>
        </nav>
    </header>

    <!-- Modal para Adicionar Curso -->
    <div class="modal fade" id="modalAdicionarCurso" tabindex="-1" aria-labelledby="modalAdicionarCursoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarCursoLabel">Adicionar Novo Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulário para adicionar curso -->
                    <form id="formAdicionarCurso" action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="tituloCurso" class="form-label">Título do Curso</label>
                            <input type="text" class="form-control" id="tituloCurso" name="tituloCurso" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoCurso" class="form-label">Descrição do Curso</label>
                            <textarea class="form-control" id="descricaoCurso" name="descricaoCurso" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagemCurso" class="form-label">Imagem do Curso</label>
                            <input type="text" class="form-control" id="imagemCurso" name="imagemCurso" accept="image/*">
                        </div>
                        <button type="submit" name="btn-adicionar-curso" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ver Inscritos -->
    <div class="modal fade" id="modalVerInscritos" tabindex="-1" aria-labelledby="modalVerInscritosLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerInscritosLabel">Inscritos no Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="listaInscritos"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Adicionar Formulário Pré-Curso -->
    <div class="modal fade" id="modalFormularioPreCurso" tabindex="-1" aria-labelledby="modalFormularioPreCursoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormularioPreCursoLabel">Adicionar Formulário Pré-Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAdicionarPreCurso" action="" method="POST">
                        <div class="mb-3">
                            <label for="linkPreCurso" class="form-label">Link do Formulário Pré-Curso</label>
                            <input type="text" class="form-control" id="linkPreCurso" name="linkPreCurso" required>
                        </div>
                        <input type="hidden" id="cursoIdPre" name="cursoIdPre">
                        <button type="submit" name="btn-adicionar-pre-curso" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Adicionar Formulário Pós-Curso -->
    <div class="modal fade" id="modalFormularioPosCurso" tabindex="-1" aria-labelledby="modalFormularioPosCursoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormularioPosCursoLabel">Adicionar Formulário Pós-Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAdicionarPosCurso" action="" method="POST">
                        <div class="mb-3">
                            <label for="linkPosCurso" class="form-label">Link do Formulário Pós-Curso</label>
                            <input type="text" class="form-control" id="linkPosCurso" name="linkPosCurso" required>
                        </div>
                        <input type="hidden" id="cursoIdPos" name="cursoIdPos">
                        <button type="submit" name="btn-adicionar-pos-curso" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Dashboard de Cursos -->
    <section class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-adm2">Cursos Cadastrados</h2>
            <!-- Botão "+ Curso" -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarCurso">
                <i class="bi bi-plus-lg"></i> Curso
            </button>
        </div>
        <div class="row" id="listaCursos">
            <!-- Os cursos serão carregados aqui via PHP -->
            <?php
            $sql = "SELECT id, nome, descricao, imagem FROM cursos";
            $result = $connect->query($sql);

            if ($result->num_rows > 0) {
                while ($curso = $result->fetch_assoc()) {
                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card" style="height: 750px;">
                            <!-- Contêiner da imagem com CSS -->
                            <div style="height: 600px; overflow: hidden;">
                                <img src="../assets/' . $curso['imagem'] . '" class="card-img-top" alt="Imagem do Curso" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">' . $curso['nome'] . '</h5>
                                <p class="card-text">' . $curso['descricao'] . '</p>
                                <!-- Botões com largura total e um em cada linha -->
                                <button class="btn btn-info w-100 d-block mb-2" data-bs-toggle="modal" data-bs-target="#modalVerInscritos" onclick="verInscritos(' . $curso['id'] . ')">Ver Inscritos</button>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-secondary w-50 d-block mb-2" data-bs-toggle="modal" data-bs-target="#modalFormularioPreCurso" onclick="setCursoIdPreCurso(' . $curso['id'] . ')">Formulário Pré-Curso</button>
                                    <button class="btn btn-secondary w-50 d-block mb-2" data-bs-toggle="modal" data-bs-target="#modalFormularioPosCurso" onclick="setCursoIdPosCurso(' . $curso['id'] . ')">Formulário Pós-Curso</button>                                
                                </div>
                                <button class="btn btn-success w-100 d-block mb-2" onclick="emitirCertificado(' . $curso['id'] . ')">Emitir Certificado</button>
                                <button class="btn btn-danger w-100 d-block mb-2" onclick="excluirCurso(' . $curso['id'] . ')">Excluir Curso</button>
                            </div>
                        </div>
                    </div>
                    ';
                }
            } else {
                echo '<p>Nenhum curso cadastrado.</p>';
            }
            ?>
        </div>
    </section>
    <script>
        function excluirCurso(id) {
            if (confirm("Tem certeza de que deseja excluir este curso?")) {
                window.location.href = "../../controller/excluir_curso.php?id=" + id;
            }
        }
        
        function emitirCertificado(id) {
            if (confirm("Tem certeza de que deseja emitir certificados para todos os inscritos? ")) {
                window.location.href = "../../controller/emitir_certificado.php?id=" + id;
            }
        }

        function verInscritos(curso_id) {
            fetch('../../controller/ver_inscritos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'curso_id=' + curso_id
            })
            .then(response => response.json())
            .then(data => {
                let lista = document.getElementById('listaInscritos');
                lista.innerHTML = ''; // Limpa lista anterior

                if (data.length > 0) {
                    data.forEach(nome => {
                        let li = document.createElement('li');
                        li.textContent = nome;
                        lista.appendChild(li);
                    });
                } else {
                    lista.innerHTML = '<li>Nenhum inscrito neste curso.</li>';
                }

                // Abrir modal
                let modal = new bootstrap.Modal(document.getElementById('modalVerInscritos'));
                modal.show();
            })
            .catch(error => console.error('Erro:', error));
        }

        function setCursoIdPreCurso(cursoId) {
            document.getElementById('cursoIdPre').value = cursoId;
        }

        function setCursoIdPosCurso(cursoId) {
            document.getElementById('cursoIdPos').value = cursoId;
        }


    </script>
</body>
</html>