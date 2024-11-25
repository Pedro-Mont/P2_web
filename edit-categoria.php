<?php
session_start();
require_once('conexao.php');

$categoria = [];

if (!isset($_GET['id'])) {
    header('Location: categorias.php');
} else {
    $categoriaId = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM categoria WHERE id = '{$categoriaId}'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $categoria = mysqli_fetch_array($query);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição da Categoria</title>
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
                            Editar Categoria <i class="bi bi-pen-fill"></i>
                            <a href="categorias.php" class="btn btn-outline-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                        if ($categoria) :
                    ?>
                        <form action="acoes.php" method="POST">
                            <input type="hidden" name="categoria_id" value="<?=$categoria['id']?>">
                            <div class="mb-3">
                                <label for="txtNome">Nome:</label>
                                <input type="text" name="txtNome" id="txtNome" value="<?=$categoria['nome']?>" class="form-control text-white bg-dark" required>
                            </div>
                            <div class="mb-3">
                                <label for="txtDesc">Descrição:</label>
                                <input type="text" name="txtDesc" id="txtDesc" value="<?=$categoria['descricao']?>" class="form-control text-white bg-dark" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="categoria_edit" class="btn btn-outline-success float-end">Salvar</button>
                            </div>
                        </form>
                        <?php
                        else:
                        ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Categoria não encontrada
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
