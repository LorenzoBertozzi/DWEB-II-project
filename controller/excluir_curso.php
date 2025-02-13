<?php
require_once 'db_connect.php'; // Caminho correto do arquivo de conexão

if (!isset($_SESSION)) {
    session_start();
}

// Verifica se foi passado um ID válido via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idCurso = intval($_GET['id']); // Sanitiza a entrada

    // Verifica se o curso existe
    $sqlCheck = "SELECT * FROM cursos WHERE id = $idCurso";
    $resultado = mysqli_query($connect, $sqlCheck);

    if (mysqli_num_rows($resultado) > 0) {
        // Exclui o curso do banco de dados
        $sqlDelete = "DELETE FROM cursos WHERE id = $idCurso";
        if (mysqli_query($connect, $sqlDelete)) {
            echo '<script>alert("Curso excluído com sucesso!"); window.location.href="../view/pages/inicio_administrador.php";</script>';
        } else {
            echo '<script>alert("Erro ao excluir o curso. Tente novamente."); window.location.href="../view/pages/inicio_administrador.php";</script>';
        }
    } else {
        echo '<script>alert("Curso não encontrado."); window.location.href="../view/pages/inicio_administrador.php";</script>';
    }
} else {
    echo '<script>alert("ID inválido."); window.location.href="../view/pages/inicio_administrador.php";</script>';
}
?>
