<?php
require "conexao.php";

$pesquisa = trim($_GET["pesquisa"] ?? "");
$termo = "%" . $pesquisa . "%";

$stmt = mysqli_prepare($conexao, "SELECT * FROM alunos WHERE nome LIKE ? ORDER BY nome");
mysqli_stmt_bind_param($stmt, "s", $termo);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">

    <h1 class="mb-4">Cadastro de Alunos</h1>

    <?php if (isset($_GET["msg"])) { ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET["msg"]); ?></div>
    <?php } ?>

    <?php if (isset($_GET["erro"])) { ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET["erro"]); ?></div>
    <?php } ?>

    <div class="card">
        <div class="card-header">Novo aluno</div>
        <div class="card-body">
            <form action="salvar.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" maxlength="100" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" maxlength="150" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Curso</label>
                    <input type="text" name="curso" class="form-control" maxlength="100" required>
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">Pesquisar aluno</div>
        <div class="card-body">
            <form method="GET" class="input-group">
                <input type="text" name="pesquisa" class="form-control" placeholder="Pesquisar aluno..."
                       value="<?php echo htmlspecialchars($pesquisa); ?>">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
                <a href="index.php" class="btn btn-secondary">Limpar</a>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">Alunos cadastrados</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Curso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($aluno = mysqli_fetch_assoc($resultado)) { ?>
                            <tr>
                                <td><?php echo $aluno["id_aluno"]; ?></td>
                                <td><?php echo htmlspecialchars($aluno["nome"]); ?></td>
                                <td><?php echo htmlspecialchars($aluno["email"]); ?></td>
                                <td><?php echo htmlspecialchars($aluno["curso"]); ?></td>
                                <td>
                                    <a href="editar.php?id=<?php echo $aluno["id_aluno"]; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir.php?id=<?php echo $aluno["id_aluno"]; ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Deseja realmente excluir este aluno?')">Excluir</a>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php if (mysqli_num_rows($resultado) == 0) { ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhum aluno encontrado.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</body>
</html>
