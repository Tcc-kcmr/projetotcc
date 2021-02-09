<?php

//ATENÇÃO!!!
/*Esse script retorna os horários com consultas já marcadas. Em JavaScript, deve-se comparar os vetores $Dados com um vetor com os 
16 horários disponíveis para exames, a fim de, imprimir no fim, os horários disponíveis para a marcação de novos exames*/
//Ou seja, deve-se comparar todos os horários com os horários já reservados, a fim de se ter os horários disponíveis

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");

$dados = [];

if($_SERVER['REQUEST_METHOD'] == "GET"){

    $Dados = json_decode(file_get_contents('php://input'), true);

    if($Dados != null){

        include 'Conexao.php';
        $Data = $Dados['data']; 

        $sql = "SELECT count(hor_ini) AS quantidade FROM servico AS s INNER JOIN exame AS e ON (s.id = e.id_servico) WHERE (hor_ini>='08:00:00' AND hor_fim<='18:00:00') AND s.data = '$Data'";

        $quantidade = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

        if($quantidade['quantidade']<16){
            $sql="SELECT hor_ini AS ocupado FROM servico AS s INNER JOIN exame AS e ON (s.id = e.id_servico) INNER JOIN exames_tipo AS et ON (et.id = e.id_tipo) WHERE (hor_ini>='09:00:00' AND hor_fim<='18:00:00') AND s.data = '$Data';";
            $resultado = mysqli_query($conexao, $sql);

            while ($dado = mysqli_fetch_assoc($resultado)){
                $dados[] = $dado;
            }

            echo json_encode($dados);

        }else{
            $retorno["Mensagem"] = "Data indisponível";
            echo json_encode($retorno);
        }
    }else{
        $retorno["Mensagem"] = "ERRO! Não foram enviados os dados da data";
        echo json_encode($retorno);
    }
}else{
    $retorno["Mensagem"] = "Utilize o método GET";
    echo json_encode($retorno);
}

?>
