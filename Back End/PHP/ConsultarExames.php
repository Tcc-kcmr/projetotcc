<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");

$dados = [];

if($_SERVER['REQUEST_METHOD'] == "GET"){

    include 'Conexao.php'; 

    $sql = "SELECT nome from exames_tipo";

    $resultado = mysqli_query($conexao, $sql);

    while ($dado = mysqli_fetch_assoc($resultado)){

        $dados[] = $dado;

    }
    echo json_encode($dados);
}else{
    $retorno["Mensagem"] = "Utilize o método GET";
    echo json_encode($retorno);
}

?>
