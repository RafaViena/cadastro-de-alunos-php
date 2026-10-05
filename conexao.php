<?php
mysqli_report(MYSQLI_REPORT_OFF);

$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "escola";
$porta    = 3306;

$conexao = mysqli_connect($servidor, $usuario, $senha, "", $porta);

if (!$conexao) {
    die("Erro ao conectar no MySQL: " . mysqli_connect_error() . "<br>Confira se o MySQL está ligado no Laragon.");
}

mysqli_set_charset($conexao, "utf8mb4");

mysqli_query($conexao, "CREATE DATABASE IF NOT EXISTS $banco");
mysqli_select_db($conexao, $banco);

mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS alunos (
    id_aluno INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    curso VARCHAR(100) NOT NULL
)");

function ir($pagina, $tipo, $texto) {
    $separador = strpos($pagina, "?") === false ? "?" : "&";
    header("Location: " . $pagina . $separador . $tipo . "=" . urlencode($texto));
    exit;
}
