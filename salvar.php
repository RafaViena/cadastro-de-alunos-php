<?php
require "conexao.php";

$nome  = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$curso = trim($_POST["curso"] ?? "");

if ($nome == "" || $email == "" || $curso == "") {
    ir("index.php", "erro", "Preencha todos os campos.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    ir("index.php", "erro", "Digite um e-mail válido.");
}

$stmt = mysqli_prepare($conexao, "INSERT INTO alunos (nome, email, curso) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $curso);

if (mysqli_stmt_execute($stmt)) {
    ir("index.php", "msg", "Aluno cadastrado com sucesso!");
}

if (mysqli_errno($conexao) == 1062) {
    ir("index.php", "erro", "Este e-mail já está cadastrado.");
}

ir("index.php", "erro", "Não foi possível cadastrar o aluno.");
