<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");

$mensagem = "";

//FUNCTIONS

function PegarIdPessoa($conexao, $CPF){

    $sql = "SELECT id FROM pessoa WHERE cpf = '$CPF'";
    $consulta = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

    while ($dado = mysqli_fetch_assoc($consulta)){
        $id_pessoa[] = $dado;
    }
    $id_pessoa_certo = $id_pessoa[0]['id'];
    return $id_pessoa_certo;
}

function InserirPaciente($conexao, $Dados, $CPF){

    $id_pessoa = PegarIdPessoa($conexao, $CPF);  

    $sql = "INSERT INTO paciente(id_pessoa) VALUES ('$id_pessoa')";
    $insert= mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

    if($insert){
        return 1;
    }else{
        return 0;
    }
}

function ConsultarIdPaciente($conexao, $Dados, $CPF){
    $id_paciente = [];

    $sql = "SELECT p.id_pessoa FROM paciente AS p INNER JOIN pessoa AS pe ON (p.id_pessoa = pe.id) WHERE pe.cpf = '$CPF'";
    $consulta = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

    while ($dado = mysqli_fetch_assoc($consulta)){
        $id_paciente[] = $dado;
    }
    //var_dump($id_paciente);

    $id_paciente_certo = $id_paciente[0]['id_pessoa'];
    return $id_paciente_certo;

}

function InserirServico($conexao, $Dados, $CPF){

    $Data = $Dados['data'];
    $Hor_ini = $Dados['hor_ini'];
    $Hor_fim = $Dados['hor_fim'];
    $id_paciente = ConsultarIdPaciente($conexao, $Dados, $CPF);
    

    $sql = "INSERT INTO servico(nome, id_paciente, data, hor_ini, hor_fim) VALUES ('Exame', '$id_paciente','$Data','$Hor_ini','$Hor_fim')";
    $insert = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

    if($insert){
        return 1;
    }else{
        return 0;
    }
}

function ConsultarIdServico($conexao, $Dados){

    $Data = $Dados['data'];
    $Hor_ini = $Dados['hor_ini'];

    $sql = "SELECT id FROM servico WHERE data = '$Data' AND hor_ini = '$Hor_ini'";
    $consulta = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

    while ($dado = mysqli_fetch_assoc($consulta)){
        $id_servico[] = $dado;
    }
    $id_servico_certo = $id_servico[0]['id'];

    return $id_servico_certo;
}

function ConsultarIdExameTipo($conexao, $Dados){

    $Exame = $Dados['exame'];

    $sql = "SELECT id FROM exames_tipo WHERE nome = '$Exame'";
    $consulta_tres = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

    /*while ($dado = mysqli_fetch_assoc($consulta_tres)){
        $id_exame_tipo[] = $dado;
    }*/

    $id_exame_tipo[] =  mysqli_fetch_assoc($consulta_tres);
    //var_dump($consulta_tres);

    $id_exame_tipo_certo = $id_exame_tipo[0]['id'];

    return $id_exame_tipo_certo;
}

function InserirExame($conexao, $Dados){

    $id_servico = ConsultarIdServico($conexao, $Dados);
    $id_exametipo = ConsultarIdExameTipo($conexao, $Dados);

    $sql = "INSERT INTO exame(id_servico, id_tipo) VALUES ('$id_servico','$id_exametipo')";
    $insert = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

    if($insert){
        return 1;
    }else{
        return 0;
    }
}

function InserirPessoa($Dados, $conexao, $CPF){

    $Nome = $Dados['nome'];
    $Dt_nasc = $Dados['dt_nasc'];
    $Email = $Dados['email'];
    $Telefone = $Dados['telefone'];
    
    $sql = "INSERT INTO pessoa(nome, cpf, dt_nasc, email, telefone) values ('$Nome','$CPF','$Dt_nasc','$Email', '$Telefone')";
    $insert = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));

    if($insert){
        return 1;
    }else{
        return 0;
    }

}

function VerificarCpf($conexao, $Dados){

    $CPF = $Dados['cpf'];

    $sql = "SELECT COUNT(nome) as quantidade FROM pessoa WHERE cpf = '$CPF'";
    $qtd_cpf = mysqli_query($conexao, $sql) or die (mysqli_error($conexao));
    
    while ($dado = mysqli_fetch_assoc($qtd_cpf)){
        $dados[] = $dado;
    }

    return $dados[0]["quantidade"];
}

//VOID

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $Dados = json_decode(file_get_contents('php://input'), true);
    
    if($Dados != null){
        include 'Conexao.php';
        $CPF = $Dados['cpf'];

        $quantidade_cpf = VerificarCpf($conexao, $Dados);

        if($quantidade_cpf == 0){
            $retorno = InserirPessoa($Dados, $conexao, $CPF);
            $retorno_paciente = InserirPaciente($conexao, $Dados, $CPF);
        }

        $retorno_servico = InserirServico($conexao, $Dados, $CPF);
        $retorno_exame = InserirExame($conexao, $Dados);

        if($retorno_servico == 1 && $retorno_exame == 1){
            $mensagem = 1; //1: deu ceerrttoooo iihhhuuuu
            echo json_encode($mensagem);
        } 
    }

}else{
    $mensagem = "Deu erro aqui!";
    echo json_encode($mensagem);
}

?>
