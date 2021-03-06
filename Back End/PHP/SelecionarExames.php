<?php

//Essa Página, consulta os exames já marcados

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");

$dados = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $Dados = json_decode(file_get_contents('php://input'), true);

    if($Dados != null){

        include 'Conexao.php'; 
        $data = $Dados["data"];

        $sql = "SELECT p.nome AS nome, p.telefone AS telefone, p.email AS email, s.data AS data, s.hor_ini AS hor_ini, et.nome AS exame FROM pessoa AS p INNER JOIN paciente AS pa ON (p.id = pa.id_pessoa) INNER JOIN servico AS s ON (pa.id_pessoa = s.id_paciente) INNER JOIN exame as e ON (s.id = e.id_servico) INNER JOIN exames_tipo AS et ON (et.id = e.id_tipo) WHERE s.data = '$data'";

        $resultado = mysqli_query($conexao, $sql);

        while ($dado = mysqli_fetch_assoc($resultado)){

            $dados[] = $dado;

        }

        echo json_encode($dados);
    }else{
        $retorno["Mensagem"] = "Erro ao enviar os dados";
        echo json_encode($retorno);
    }
}else{
    $retorno["Mensagem"] = "Utilize o método POST";
    echo json_encode($retorno);
}

?>
