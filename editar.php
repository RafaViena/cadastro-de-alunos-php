<?php
require "conexao.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = mysqli_prepare($conexao, "SELECT * FROM alunos WHERE id_aluno = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$aluno = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$aluno) {
    ir("index.php", "erro", "Aluno não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">

    <h1 class="mb-4">Editar aluno</h1>

    <?php if (isset($_GET["erro"])) { ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET["erro"]); ?></div>
    <?php } ?>

    <div class="card">
        <div class="card-body">
            <form action="atualizar.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $aluno["id_aluno"]; ?>">

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" maxlength="100" required
                           value="<?php echo htmlspecialchars($aluno["nome"]); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" maxlength="150" required
                           value="<?php echo htmlspecialchars($aluno["email"]); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Curso</label>
                    <input type="text" name="curso" class="form-control" maxlength="100" required
                           value="<?php echo htmlspecialchars($aluno["curso"]); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Salvar alterações</button>
                <a href="index.php" class="btn btn-secondary">Voltar</a>
            </form>
        </div>
    </div>

</div>
</body>
</html>
