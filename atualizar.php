<?php
require "conexao.php";

$id    = (int) ($_POST["id"] ?? 0);
$nome  = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$curso = trim($_POST["curso"] ?? "");

if ($id <= 0) {
    ir("index.php", "erro", "ID do aluno inválido.");
}

if ($nome == "" || $email == "" || $curso == "") {
    ir("editar.php?id=$id", "erro", "Preencha todos os campos.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    ir("editar.php?id=$id", "erro", "Digite um e-mail válido.");
}

$stmt = mysqli_prepare($conexao, "UPDATE alunos SET nome = ?, email = ?, curso = ? WHERE id_aluno = ?");
mysqli_stmt_bind_param($stmt, "sssi", $nome, $email, $curso, $id);

if (mysqli_stmt_execute($stmt)) {
    ir("index.php", "msg", "Aluno atualizado com sucesso!");
}

if (mysqli_errno($conexao) == 1062) {
    ir("editar.php?id=$id", "erro", "Este e-mail já está cadastrado.");
}

ir("editar.php?id=$id", "erro", "Não foi possível atualizar o aluno.");
