<?php 
/********************************************************
    Objetivo: Configuração para conectar no BD MySql
    Data: 16/09/2020
    Autor: Matheus Henrique
*********************************************************/

function conexaoMysql ()
{    
    /*Variaveis para conexão com o BD*/
    $server = (string) "localhost";
    $user = (string) "root";
    $password = (string) "matheus12345678910";
    $dataBase = (string) "fastparkingdb";

    /*Cria a conexão com o BD MySQL*/
    if ($conexao = mysqli_connect($server, $user, $password, $dataBase))
        return $conexao;
    else
        return false;
}

?>