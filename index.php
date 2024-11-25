<?php
session_start();
require_once("conexao.php");
    
$sqlSum = "
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
    GROUP BY 
        mes.id, mes.nome_mes, mes.ano
";
$soma_mes = mysqli_query($conn, $sqlSum);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem</title>
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
                            Serviço Financeiro <i class="bi bi-cash-stack"></i>
                            <a href="cadastrar-mes.php" class="btn btn-outline-warning float-end">Meses</a>
                            <a href="categorias.php" class="btn btn-outline-warning float-end me-2">Categorias</a>
                        </h4>
                    </div>
                </div>
            </div>

            <?php foreach ($soma_mes as $soma_meses): ?>
                <div class="col-sm-4">
                    <div class="card text-bg-dark mt-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $soma_meses['nome_mes'] . ' ' . $soma_meses['ano']; ?>
                                <a href="edit-mes.php?mes_id=<?=$soma_meses['mes_id']?>" class="btn btn-outline-warning float-end"><i class="bi bi-pencil-fill"></i> </a>
                            </h5>
                            <p class="card-text">
                                Resumo mensal: R$ <?php echo number_format($soma_meses['soma_valor'], 2, ',',); ?>
                            </p>
                            <p class="card-text 
                                <?php 
                                    if ($soma_meses['soma_valor'] > 0) {
                                        echo 'text-success';
                                    } elseif ($soma_meses['soma_valor'] < 0) {
                                        echo 'text-danger'; 
                                    } else {
                                        echo 'text-warning'; 
                                    }
                                ?>">
                                <?php 
                                    if ($soma_meses['soma_valor'] > 0) {
                                        echo 'Saldo positivo';
                                    } elseif ($soma_meses['soma_valor'] < 0) {
                                        echo 'Saldo negativo';
                                    } else {
                                        echo 'Saldo neutro';
                                    }
                                ?>
                            </p>
                            <a href="resumo.php?id=<?=$soma_meses['mes_id']?>" class="btn btn-outline-success">Resumo do mês</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>