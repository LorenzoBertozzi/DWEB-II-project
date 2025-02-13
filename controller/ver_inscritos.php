<?php
require_once 'db_connect.php'; // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['curso_id'])) {
    $curso_id = intval($_POST['curso_id']);

    $sql = "SELECT u.nome FROM cursos_realizados i 
            JOIN usuarios u ON i.usuarios_id = u.id 
            WHERE i.cursos_id = $curso_id";

    $result = mysqli_query($connect, $sql);

    $inscritos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $inscritos[] = $row['nome'];
    }

    echo json_encode($inscritos);
} else {
    echo json_encode(["error" => "Requisição inválida"]);
}

mysqli_close($connect);
