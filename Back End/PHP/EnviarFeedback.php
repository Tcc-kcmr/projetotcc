<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");

$mensagem = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $Dados = json_decode(file_get_contents('php://input'), true);
    
    if($Dados != null){

        $CPF = $Dados['cpf'];
        $Texto = $Dados['texto'];

        include 'Conexao.php';

        $sql = "SELECT id FROM pessoa WHERE cpf = '$CPF'";
        $id = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

        while ($dado = mysqli_fetch_assoc($id)){
            $dados[] = $dado;
        }

        $id_pessoa = $dados[0]['id'];

        $sql = "INSERT INTO feedback(id_pessoa, texto) VALUES ($id_pessoa, 'bla bla vla bla php')";
        $resultado = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));
        
        if($resultado){
            $mensagem = "Feedback enviado com sucesso!";
        }
    }
}else{
    $mensagem = "Deu erro aqui!";
}

$retorno["mensagem"] = $mensagem;
echo json_encode($retorno);

?>
