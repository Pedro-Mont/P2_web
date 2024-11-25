<?php
session_start();
require_once('conexao.php');

// Referente as catecorias

if (isset($_POST['create_categoria'])) {
    $nome = trim($_POST['txtNome']);
    $descricao = trim($_POST['txtDesc']);

    $sql = "INSERT INTO categoria (nome, descricao) VALUES('$nome', '$descricao')";

    mysqli_query($conn, $sql);

    header('Location: categorias.php');
    exit();
}

if (isset($_POST['delete_categoria'])) {
    $categoriaId = mysqli_real_escape_string($conn, $_POST['delete_categoria']);
    $sql = "DELETE FROM categoria WHERE id = '$categoriaId'";

    mysqli_query($conn, $sql);

    header('Location: categorias.php');
    exit;
}

if (isset($_POST['categoria_edit'])) {
    $categoriaId = mysqli_real_escape_string($conn, $_POST['categoria_id']);
    $nome = mysqli_real_escape_string($conn, $_POST['txtNome']);
    $descricao = mysqli_real_escape_string($conn, $_POST['txtDesc']);

    $sql = "UPDATE categoria SET nome = '{$nome}', descricao = '{$descricao}' WHERE id = '{$categoriaId}'";

    mysqli_query($conn, $sql);

    header("Location: categorias.php");
    exit;
}

// Referente aos meses

if (isset($_POST['create_mes'])) {
    $mes = trim($_POST['txtMes']);
    $ano = trim($_POST['txtAno']);

    $sql = "INSERT INTO mes(nome_mes, ano) VALUES('$mes', '$ano')";

    mysqli_query($conn, $sql);

    header('Location: cadastrar-mes.php');
    exit();
}

if (isset($_POST['delete_mes'])) {
    $mesId = mysqli_real_escape_string($conn, $_POST['delete_mes']);
    $sql = "DELETE FROM mes WHERE id = '$mesId'";

    mysqli_query($conn, $sql);

    header('Location: cadastrar-mes.php');
    exit;
}

// Referente as transações

if (isset($_POST['create_transacao'])) {
    $mesId = mysqli_real_escape_string($conn, $_POST['mes_id']);
    $dataTransacao = mysqli_real_escape_string($conn, $_POST['data_transacao']);
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $valor = floatval($_POST['valor']);
    $categoriaId = mysqli_real_escape_string($conn, $_POST['categoria_id']);

    if ($tipo == '1') {
        $valor = -abs($valor);
    }

    $sql = "INSERT INTO transacao (data_transacao, tipo, descricao, valor, categoria_id, mes_id) VALUES ('$dataTransacao', '$tipo', '$descricao', '$valor', '$categoriaId', '$mesId')";

    mysqli_query($conn, $sql);

    header('Location: edit-mes.php');
    exit;
}

if (isset($_POST['delete_trasacao'])) {
    $transacaoId = mysqli_real_escape_string($conn, $_POST['delete_trasacao']);
    $sql = "DELETE FROM transacao WHERE id = '$transacaoId'";

    mysqli_query($conn, $sql);

    header('Location: edit-mes.php');
    exit;
}
?>