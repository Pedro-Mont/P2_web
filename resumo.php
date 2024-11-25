<?php
session_start();
require_once('conexao.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$mesId = mysqli_real_escape_string($conn, $_GET['id']);
$sqlMes = "
    SELECT 
        mes.id AS mes_id,
        mes.nome_mes,
        mes.ano,
        IFNULL(SUM(transacao.valor), 0) AS soma_valor
    FROM 
        mes
    LEFT JOIN 
        transacao 
    ON 
        mes.id = transacao.mes_id
    WHERE 
        mes.id = '$mesId'
    GROUP BY 
        mes.id, mes.nome_mes, mes.ano
";
$queryMes = mysqli_query($conn, $sqlMes);

if (mysqli_num_rows($queryMes) === 0) {
    header('Location: index.php');
    exit;
}

$resumo = mysqli_fetch_assoc($queryMes);

$sqlTransacoes = "
    SELECT 
        transacao.id AS transacao_id,
        DATE_FORMAT(transacao.data_transacao, '%d/%m/%Y') AS data_transacao,
        CASE 
            WHEN transacao.tipo = 0 THEN 'Entrada' 
            WHEN transacao.tipo = 1 THEN 'Saída' 
            ELSE 'Outro' 
        END AS tipo_transacao,
        transacao.valor,
        categoria.nome AS categoria_nome
    FROM 
        transacao
    LEFT JOIN 
        categoria 
    ON 
        transacao.categoria_id = categoria.id
    WHERE 
        transacao.mes_id = '$mesId'
    ORDER BY 
        transacao.data_transacao DESC
";
$queryTransacoes = mysqli_query($conn, $sqlTransacoes);
$transacoes = mysqli_fetch_all($queryTransacoes, MYSQLI_ASSOC);

$sqlTotais = "
    SELECT 
        SUM(CASE WHEN tipo = 0 THEN valor ELSE 0 END) AS total_entrada,
        SUM(CASE WHEN tipo = 1 THEN valor ELSE 0 END) AS total_saida
    FROM 
        transacao
    WHERE 
        mes_id = '$mesId'
";
$queryTotais = mysqli_query($conn, $sqlTotais);
$totais = mysqli_fetch_assoc($queryTotais);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo Mensal</title>
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
                            Resumo Mensal: <?php echo $resumo['nome_mes'] . ' ' . $resumo['ano']; ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <h4>
                            Transações
                            <a href="index.php" class="btn btn-outline-warning float-end me-2">Voltar</a>
                        </h4>
                        <table class="table table-dark mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Categoria</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($transacoes)): ?>
                            <?php foreach ($transacoes as $transacao): ?>
                                <tr>
                                    <td><?php echo $transacao['transacao_id']; ?></td>
                                    <td><?php echo $transacao['data_transacao']; ?></td>
                                    <td><?php echo $transacao['tipo_transacao']; ?></td>
                                    <td>R$ <?php echo number_format($transacao['valor'], 2, ','); ?></td>
                                    <td><?php echo $transacao['categoria_nome'] ?? 'Sem categoria'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhuma transação encontrada para este mês.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                        </table>
                        <h4 class="mt-5">Resumo Financeiro</h4>
                        <table class="table table-dark mt-3">
                            <thead>
                                <tr>
                                    <th>Total de Entradas</th>
                                    <th>Total de Saídas</th>
                                    <th>Saldo Final</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>R$ <?php echo number_format($totais['total_entrada'], 2, ',', '.'); ?></td>
                                    <td>R$ <?php echo number_format($totais['total_saida'], 2, ',', '.'); ?></td>
                                    <td>R$ <?php echo number_format($totais['total_entrada'] + $totais['total_saida'], 2, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>