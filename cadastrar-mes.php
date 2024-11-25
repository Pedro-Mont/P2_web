<?php
session_start();
require_once("conexao.php");

$sql = "SELECT * FROM mes";
$mes = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar meses </title>
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
                        Meses <i class="bi bi-calendar-check-fill"></i>
                        <a href="index.php" class="btn btn-outline-danger float-end">Voltar</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mês</th>
                                <th>Ano</th>
                                <th>Excluir mês</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($mes as $meses): ?>
                            <tr>
                                <td><?php echo $meses['id']; ?></td>
                                <td><?php echo $meses['nome_mes']; ?></td>
                                <td><?php echo $meses['ano']; ?></td>
                                <td>
                                    <form action="acoes.php" method="POST" class="d-inline">
                                        <button name="delete_mes" type="submit" value="<?=$meses['id']?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
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
                        Adicionar Mês <i class="bi bi-calendar-plus"></i>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="acoes.php" method="POST">
                        <div class="mb-3">
                            <label for="txtMes">Mês:</label>
                            <select name="txtMes" id="txtMes" class="form-control bg-dark text-light">
                                <option value="Janeiro">Janeiro</option>
                                <option value="Fevereiro">Fevereiro</option>
                                <option value="Março">Março</option>
                                <option value="Abril">Abril</option>
                                <option value="Maio">Maio</option>
                                <option value="Junho">Junho</option>
                                <option value="Julho">Julho</option>
                                <option value="Agosto">Agosto</option>
                                <option value="Setembro">Setembro</option>
                                <option value="Outubro">Outubro</option>
                                <option value="Novembro">Novembro</option>
                                <option value="Dezembro">Dezembro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="txtAno">Ano:</label>
                            <input type="number" name="txtAno" id="txtAno" class="form-control bg-dark text-light" min="1900" max="2100" placeholder="Digite o ano" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="create_mes" class="btn btn-outline-success float-end">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>