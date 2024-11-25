<?php
session_start();
require_once('conexao.php');

if (!isset($_GET['mes_id'])) {
    header('Location: index.php'); 
    exit;
} else {
    $mesId = mysqli_real_escape_string($conn, $_GET['mes_id']);

    $sqlTransacoes = "SELECT t.*, c.nome AS categoria_nome 
                    FROM transacao t
                    JOIN categoria c ON t.categoria_id = c.id
                    WHERE t.mes_id = '{$mesId}'";
    $queryTransacoes = mysqli_query($conn, $sqlTransacoes);
    $transacoes = mysqli_fetch_all($queryTransacoes, MYSQLI_ASSOC); 

    $sqlCategorias = "SELECT * FROM categoria";
    $queryCategorias = mysqli_query($conn, $sqlCategorias);
    $categorias = mysqli_fetch_all($queryCategorias, MYSQLI_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transações</title>
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
                            Transações do Mês <i class="bi bi-calendar-event"></i>
                            <a href="index.php" class="btn btn-outline-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <h5>Transações</h5>
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Data</th>
                                    <th>Tipo</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Categoria</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($transacoes)): ?>
                                    <?php foreach ($transacoes as $transacao): ?>
                                        <tr>
                                            <td><?php echo $transacao['id']; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($transacao['data_transacao']));?></td>
                                            <td>
                                                <?php
                                                    if ($transacao['tipo'] == 0) {
                                                        echo "Entrada";
                                                    } else {
                                                        echo "Saída";
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $transacao['descricao']; ?></td>
                                            <td>R$ <?php echo number_format($transacao['valor'], 2, ',') ?></td>
                                            <td><?php echo $transacao['categoria_nome']; ?></td>
                                            <td>
                                                <form action="acoes.php" method="POST" class="d-inline">
                                                    <button name="delete_trasacao" type="submit" value="<?=$transacao['id']?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Nenhuma transação encontrada</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <h5 class="mt-4">Adicionar Transação</h5>
                        <form action="acoes.php" method="POST">
                            <input type="hidden" name="mes_id" value="<?= $mesId ?>">
                            <div class="mb-3">
                                <label for="data_transacao">Data da Transação:</label>
                                <input type="date" name="data_transacao" id="data_transacao" class="form-control text-white bg-dark" min="1900" max="2100" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_transacao">Tipo:</label>
                                <select name="tipo" id="tipo_transacao" class="form-control text-white bg-dark" required>
                                    <option value="0">Entrada</option>
                                    <option value="1">Saída</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="descricao_transacao">Descrição:</label>
                                <input type="text" name="descricao" id="descricao_transacao" class="form-control text-white bg-dark" required>
                            </div>
                            <div class="mb-3">
                                <label for="valor_transacao">Valor:</label>
                                <input type="number" name="valor" id="valor_transacao" class="form-control text-white bg-dark" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoriaTransacao">Categoria:</label>
                                <select name="categoria_id" id="categoriaTransacao" class="form-control text-white bg-dark" required>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="create_transacao" class="btn btn-outline-success float-end">Salvar</button>
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