<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['curso_id'], $_POST['usuario_id'])) {
    $curso_id = intval($_POST['curso_id']);
    $usuario_id = intval($_POST['usuario_id']);
    $resposta_padrao = "Formulário pré-curso respondido"; 

    $sql = "UPDATE cursos_realizados SET pre_curso = '$resposta_padrao' WHERE curso_id = $curso_id AND usuario_id = $usuario_id";

    if (mysqli_query($connect, $sql)) {
        echo json_encode(["success" => "Formulário pré-curso salvo com sucesso!"]);
    } else {
        echo json_encode(["error" => "Erro ao salvar formulário: " . mysqli_error($connect)]);
    }

    mysqli_close($connect);
} else {
    echo json_encode(["error" => "Requisição inválida"]);
}
