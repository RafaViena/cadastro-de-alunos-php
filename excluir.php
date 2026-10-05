<?php
require "conexao.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = mysqli_prepare($conexao, "DELETE FROM alunos WHERE id_aluno = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    ir("index.php", "msg", "Aluno excluído com sucesso!");
}

ir("index.php", "erro", "Não foi possível excluir o aluno.");
