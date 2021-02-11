
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");

if($_SERVER['REQUEST_METHOD'] == "GET"){

    include 'Conexao.php'; 

    $sql = "SELECT p.nome, p.email, f.texto FROM pessoa AS p INNER JOIN feedback as f ON (p.id = f.id_pessoa)";

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
