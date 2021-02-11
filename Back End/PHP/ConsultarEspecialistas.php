
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");

if($_SERVER['REQUEST_METHOD'] == "GET"){

    include 'Conexao.php'; 

    $sql = "SELECT p.nome AS nome, ct.nome AS cargo, e.nome AS especialidade FROM pessoa AS p INNER JOIN funcionario as f ON (p.id = f.id_pessoa)
    INNER JOIN cargo AS c ON (f.id_cargo = c.id) INNER JOIN cargo_tipo AS ct ON (c.id_tipo = ct.id) INNER JOIN especialidade AS e ON (cT.id_especialidade = e.id) WHERE ct.nome = 'medico'";

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
