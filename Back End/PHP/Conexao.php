<?php

    $host="localhost";
    $user="root";
    $pass="";
    $banco="tcc";

    $conexao=mysqli_connect($host, $user, $pass) or die(mysqli_error($sql));

    mysqli_select_db($conexao, $banco) or die(mysqli_error($sql));
?>
