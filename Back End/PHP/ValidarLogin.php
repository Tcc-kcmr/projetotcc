
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");

$dados = [];

if($_SERVER['REQUEST_METHOD'] == "GET"){

    $Json = json_decode(file_get_contents('php://input'), true);

    if($Json != null){

        $Login = $Json['login'];
        $Senha = $Json['senha'];

        include 'Conexao.php'; 

        $sql = "SELECT COUNT(usuario) as usuario FROM login where usuario = '$Login' and senha = '$Senha'";

        $resultado = mysqli_query($conexao, $sql);

        while ($dado = mysqli_fetch_assoc($resultado)){

            $dados[] = $dado;

        }

        if($dados[0]["usuario"]==1){
            
            $mensagem=1; //1=> login válido! Validar no Js

        }else{
            $mensagem=0; //0=> login inválido!
        }

        echo json_encode($mensagem);

    }else{
        $retorno["Mensagem"] = "ERRO na transferência de arquivos!!!";
        echo json_encode($retorno);
    }

}else{
    $retorno["Mensagem"] = "Utilize o método GET";
    echo json_encode($retorno);
}

?>
