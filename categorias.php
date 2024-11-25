<?php
session_start();
require_once("conexao.php");

$sql = "SELECT * FROM categoria";
$categoria = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark">
    
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card text-bg-dark text-warning border-top-0">
                <div class="card-header">
                    <h4>
                        Categorias <i class="bi bi-tag-fill"></i>
                        <a href="index.php" class="btn btn-outline-danger float-end">Voltar</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Categoria</th>
                                <th>Descrição da categoria</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($categoria as $categorias): ?>
                            <tr>
                                <td><?php echo $categorias['id']; ?></td>
                                <td><?php echo $categorias['nome']; ?></td>
                                <td><?php echo $categorias['descricao']; ?></td>
                                <td>
                                <a href="edit-categoria.php?id=<?= $categorias['id'] ?>" class="btn btn-outline-warning btn-sm"><i class="bi bi-pen-fill"></i></a>
                                    <form action="acoes.php" method="POST" class="d-inline">
                                        <button name="delete_categoria" type="submit" value="<?=$categorias['id']?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

            <div class="card text-bg-dark border-top-0 mt-5">
                <div class="card-header text-warning">
                    <h4>
                        Criar categoria <i class="bi bi-tags-fill"></i>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="acoes.php" method="POST">
                        <div class="mb-3">
                            <label for="txtNome">Nome da Categoria:</label>
                            <input type="text" name="txtNome" id="txtNome" class="form-control bg-dark text-light" required>
                        </div>
                        <div class="mb-3">
                            <label for="txtDesc">Descrição da Categoria:</label>
                            <input type="text" name="txtDesc" id="txtDesc" class="form-control bg-dark text-light" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="create_categoria" class="btn btn-outline-success float-end">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>