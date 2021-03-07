<?php

//Essa Página, consulta as consultas já marcados

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");
header("Access-Control-Allow-Methods: *");

$dados = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $Dados = json_decode(file_get_contents('php://input'), true);

    if($Dados != null){

        include 'Conexao.php'; 
        $data = $Dados["data"];

        $sql = "SELECT p.nome AS nome, p.telefone AS telefone, p.email AS email, s.data AS data, s.hor_ini AS hor_ini, es.nome AS especialidade  FROM pessoa AS p INNER JOIN paciente AS pa ON (p.id = pa.id_pessoa) INNER JOIN servico AS s ON (pa.id_pessoa = s.id_paciente) INNER JOIN especialidade AS es ON (es.id = s.id_especialidade) WHERE s.nome = 'consulta' AND s.data = '$data'";
       
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
