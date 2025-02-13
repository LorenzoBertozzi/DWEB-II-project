<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['tituloCurso'];
    $descricao = $_POST['descricaoCurso'];
    $imagem = $_FILES['imagemCurso'];

    // Processar upload da imagem
    $imagemNome = uniqid() . '_' . basename($imagem['name']);
    $imagemCaminho = '../assets/' . $imagemNome;
    move_uploaded_file($imagem['tmp_name'], $imagemCaminho);

    // Inserir no banco de dados
    $sql = "INSERT INTO cursos (nome, descricao, imagem) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("sss", $nome, $descricao, $imagemNome);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Curso adicionado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao adicionar curso.']);
    }

    $stmt->close();
    $connect->close();
}
?>