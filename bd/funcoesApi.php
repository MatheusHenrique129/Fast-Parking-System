<?php

function listarClientes($id){

 //Import do arquivo de Variaveis e Constantes
 require_once('../modulo/config.php');

 //Import do arquivo de função para conectar no BD  
 require_once('conexaoMysql.php');

 if(!$conex = conexaoMysql())
 {
     echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
 }

 $sql = "select tblCliente.*, tblVeiculo.placa, tblVeiculo.cor
        from tblCliente, tblVeiculo
        where tblCliente.idVeiculo = tblVeiculo.idVeiculo";

        if ($id > 0) {
            $sql = $sql . " and tblCliente.idCliente = " . $id;
        }
    
        $select = mysqli_query($conex, $sql);
        
        while($rsClientes = mysqli_fetch_assoc($select)) {
            //varios itens para o json
            $dados[] = array (
                //          => - o que alimenta o dado de um array
                'idCliente'         => $rsClientes['idCliente'],
                'nomeCliente'       => $rsClientes['nomeCliente'],
                'placa'             => $rsClientes['placa'],
                'cor'               => $rsClientes['cor'],
                'horarioEntrada'    => $rsClientes['horarioEntrada'],
                'horarioSaida'      => $rsClientes['horarioSaida'],
                'valorAPagar'       => "R$".$rsClientes['valorAPagar']
             
            );            
        }
    
    if(isset($dados))
        return $dados;
    else 
        return false;

}


function inserirCliente($dadosCliente){
  
    //Import do arquivo de Variaveis e Constantes
    require_once('../modulo/config.php');

    //Import do arquivo de função para conectar no BD  
    require_once('conexaoMysql.php');

    if(!$conex = conexaoMysql())
    {
        echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
    }

    $nomeCliente = $dadosCliente['nomeCliente'];
    $placa = $dadosCliente['placa'];
    $cor = $dadosCliente['cor'];
    

    $sql1 = "insert into tblVeiculo(placa, cor)
             values('".$placa."', '".$cor."')
            ";

    if(mysqli_query($conex, $sql1)){

            $sqlIdVeiculo = "select * from tblVeiculo order by idVeiculo desc limit 1";

            $selectIdVeiculo = mysqli_query($conex, $sqlIdVeiculo);
            
            $rsVeiculo = mysqli_fetch_assoc($selectIdVeiculo);

            
            $sql2 = "insert into tblCliente(nomeCliente, horarioEntrada, idVeiculo, horarioSaida, valorAPagar)
                    values('".$nomeCliente."', curtime(), '".$rsVeiculo['idVeiculo']."', null, 'null')
                    ";

        if(mysqli_query($conex, $sql2))
            return $dadosCliente;
        else
            return false;

    }         
}

function excluirCliente($id){

        //Import do arquivo de Variaveis e Constantes
        require_once('../modulo/config.php');

        //Import do arquivo de função para conectar no BD  
        require_once('conexaoMysql.php');
    
        if(!$conex = conexaoMysql())
        {
            echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
        }

    $sqlIdVeiculo = "select * from tblVeiculo order by idVeiculo desc limit 1";

    $selectIdVeiculo = mysqli_query($conex, $sqlIdVeiculo);
        
    $rsVeiculo = mysqli_fetch_assoc($selectIdVeiculo);

        if($id > 0){
        
            $sql = "delete from tblCliente where idCliente = ".$id;

            $sql2 = "delete from tblVeiculo where idVeiculo = ".$rsVeiculo['idVeiculo'];
            
           if (mysqli_query($conex, $sql))
            if(mysqli_query($conex, $sql2))
               return true;
           else 
               return false;
           
        } 
}

function atualizarCliente($id){
    
    //Import do arquivo de Variaveis e Constantes
  require_once('../modulo/config.php');

  //Import do arquivo de função para conectar no BD  
  require_once('conexaoMysql.php');

  if(!$conex = conexaoMysql())
  {
      echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
  }


    $atualizarHorarioSaida = "update tblCliente set

                          horarioSaida = curtime()

                          where idCliente = " . $id;

    mysqli_query($conex, $atualizarHorarioSaida);

    $valorAPagar = calcularValorFinal($id);


    $atualizarValorFinal = "update tblCliente set
                    
                        valorAPagar = ".$valorAPagar."

                        where idCliente = " . $id;

                   
    mysqli_query($conex, $atualizarValorFinal);


    $sql = "select tblCliente.*, tblVeiculo.placa, tblVeiculo.cor  
         from tblCliente, tblVeiculo
         where tblCliente.idCliente = ".$id."
         and tblCliente.idVeiculo = tblVeiculo.idVeiculo";


    $select = mysqli_query($conex, $sql);

        while($rsClientes = mysqli_fetch_assoc($select))
        {
             //varios itens para o json
             $dados[] = array (
                 //          => - o que alimenta o dado de um array
                 'idCliente'         => $rsClientes['idCliente'],
                 'nomeCliente'       => $rsClientes['nomeCliente'],
                 'placa'             => $rsClientes['placa'],
                 'cor'               => $rsClientes['cor'],
                 'horarioEntrada'    => $rsClientes['horarioEntrada'],
                 'horarioSaida'      => $rsClientes['horarioSaida'],
                 'valorAPagar'       => "R$".$rsClientes['valorAPagar']
              
             ); 

        }
    

    if(isset($dados))
         return $dados;
    else 
         return false;
  
}

function convertJson($data) {
    header("Content-Type:application/json"); // forçando o cabeçalho do arquivo a ser aplicação do tipo json
    $listJson = json_encode($data); // codificando em json   
    return $listJson;
}

function calcularValorFinal($id){

    //Import do arquivo de Variaveis e Constantes
    require_once('../modulo/config.php');

    //Import do arquivo de função para conectar no BD  
    require_once('conexaoMysql.php');

    if(!$conex = conexaoMysql())
    {
        echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
    }

    $diferencaHorarios = "select timediff(tblCliente.horarioSaida, tblCliente.horarioEntrada) as diferencaHorarios from tblCliente
    where tblCliente.idCliente = ".$id;
    
    //mysqli_query para validar o script
    $queryDiferencaHorarios = mysqli_query($conex, $diferencaHorarios);
    
    //transforma o script em um array associativo
    $rsDiferencaHorarios = mysqli_fetch_assoc($queryDiferencaHorarios);
    
    $timeDiffHour = explode(":", $rsDiferencaHorarios['diferencaHorarios']);

    //uso da função subtrairTempo para subtrair dois valores que correspondem a horas, retorna um int
    $demaisHoras = subtrairHora($rsDiferencaHorarios['diferencaHorarios'], "1:00:00");
    $primeiraHora = subtrairHora($rsDiferencaHorarios['diferencaHorarios'], $demaisHoras);

    $sqlRegistro = "select * from tblRegistro";
    
    $queryRegistro = mysqli_query($conex, $sqlRegistro);

    $rsRegistro = mysqli_fetch_assoc($queryRegistro);
    
            //operação para calcular o valor final pago, considerando o valor da primeira hora e o valor para cada hora restante
            $valorPrimeiraHora = (int)$rsRegistro['valorPrimeiraHora'];
            $valorDemaisHoras  = (int)$rsRegistro['valorDemaisHoras'];
            $desconto = (int)$rsRegistro['desconto'];
    
            $valorFinal = ($primeiraHora*$valorPrimeiraHora) + $demaisHoras * $valorDemaisHoras;

            if($timeDiffHour[0] == "00"){

                $valorFinal = 0;
                return $valorFinal;

            }
            else if($desconto > 0){

                $desconto = $desconto/100;
                $valorComDesconto = $valorFinal * $desconto;

                $valorFinal = $valorFinal - $valorComDesconto;

                return $valorFinal;       

            }
            else{                     
                return $valorFinal;
                
            }  
    
}

function subtrairHora($tempoA, $tempoB){

    $arrayTempoA = explode(":", $tempoA);
    $arrayTempoB = explode(":", $tempoB);

    /*com o explode eu divido o formato de horário "00:00:00" em um array desta forma
    Ex: 17:30:15
    
    array(

        [0]-> 17,
        [1]-> 30,
        [2]-> 15

    );

    */

    $tempoAInt = (int)$arrayTempoA[0];
    $tempoBInt = (int)$arrayTempoB[0];

    $subtracaoHoras = $tempoAInt - $tempoBInt;

    return $subtracaoHoras;
}

function inserirRegistro($dadosJson){

    //Import do arquivo de Variaveis e Constantes
  require_once('../modulo/config.php');

  //Import do arquivo de função para conectar no BD  
  require_once('conexaoMysql.php');

  if(!$conex = conexaoMysql())
  {
      echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
  }

  $valorPrimeiraHora = $dadosJson['valorPrimeiraHora'];
  $valorDemaisHoras = $dadosJson['valorDemaisHoras'];
  $quantidadeDeVagas = $dadosJson['quantidadeDeVagas'];
  $desconto = $dadosJson['desconto'];


  $sql = "insert into tblregistro(valorPrimeiraHora, valorDemaisHoras, qtde_de_vagas, desconto)
          values('".$valorPrimeiraHora."', '".$valorDemaisHoras."', '".$quantidadeDeVagas."', '".$desconto."')";

    if(mysqli_query($conex, $sql))
        return $dadosJson;
    else
        return false;
    
}

function listarRegistro(){


    //Import do arquivo de Variaveis e Constantes
    require_once('../modulo/config.php');

    //Import do arquivo de função para conectar no BD  
    require_once('conexaoMysql.php');

    if(!$conex = conexaoMysql())
    {
        echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
    }

     $sql = "select * from tblRegistro";
             

        $select = mysqli_query($conex, $sql);
        
        while($rsRegistro = mysqli_fetch_assoc($select)) {
            //varios itens para o json
            $dados[] = array (
                //          => - o que alimenta o dado de um array
                'idRegistro'              => $rsRegistro['idRegistro'],
                'valorPrimeiraHora'       => $rsRegistro['valorPrimeiraHora'],
                'valorDemaisHoras'        => $rsRegistro['valorDemaisHoras'],
                'quantidadeDeVagas'       => $rsRegistro['qtde_de_vagas'],
                'desconto'                => $rsRegistro['desconto']."%"
             
            );            
        }
    
    if(isset($dados))
        return $dados;
    else 
        return false;

}

function atualizarRegistro($dadosRegistro){

  //Import do arquivo de Variaveis e Constantes
  require_once('../modulo/config.php');

  //Import do arquivo de função para conectar no BD  
  require_once('conexaoMysql.php');

  if(!$conex = conexaoMysql())
  {
      echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
  }

  $getRegistro = listarRegistro();

  $valorPrimeiraHora = $dadosRegistro['valorPrimeiraHora'];
  $valorDemaisHoras = $dadosRegistro['valorDemaisHoras'];
  $quantidadeDeVagas = $dadosRegistro['qtde_de_vagas'];
  $desconto = $dadosRegistro['desconto'];

  $update = "update tblRegistro set

          valorPrimeiraHora = ".$valorPrimeiraHora.",
          valorDemaisHoras = ".$valorDemaisHoras.",
          qtde_de_vagas = ".$quantidadeDeVagas.",
          desconto = ".$desconto."
          where idRegistro = ".$getRegistro[0]['idRegistro'];

    mysqli_query($conex, $update);
 

    $sql = "select * from tblRegistro
            where tblRegistro.idRegistro = ".$getRegistro[0]['idRegistro'];


    $select = mysqli_query($conex, $sql);

        while($rsRegistroAtualizado = mysqli_fetch_assoc($select)) {
            //varios itens para o json
            $dadosAtualizados[] = array (
                //          => - o que alimenta o dado de um array
                'idRegistro'              => $rsRegistroAtualizado['idRegistro'],
                'valorPrimeiraHora'       => $rsRegistroAtualizado['valorPrimeiraHora'],
                'valorDemaisHoras'        => $rsRegistroAtualizado['valorDemaisHoras'],
                'quantidadeDeVagas'       => $rsRegistroAtualizado['qtde_de_vagas'],
                'desconto'                => $rsRegistroAtualizado['desconto']."%"
            
            );            
        }
    

    if(isset($dadosAtualizados)){
        return $dadosAtualizados;
    }
    else{
        return false;
    }

}

function excluirRegistro($id){
 
  //Import do arquivo de Variaveis e Constantes
  require_once('../modulo/config.php');

  //Import do arquivo de função para conectar no BD  
  require_once('conexaoMysql.php');

  if(!$conex = conexaoMysql())
  {
      echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
  }

  $sqlDiario = "select idRendimentoDiario from rendimentoDiario";
  $selectDiario = mysqli_query($conex, $sqlDiario);
  $idRendimentoDiario = mysqli_fetch_assoc($selectDiario);

  $sqlMensal = "select idRendimentoMensal from rendimentoMensal";
  $selectMensal = mysqli_query($conex, $sqlMensal);
  $idRendimentoMensal = mysqli_fetch_assoc($selectMensal);

  $sqlAnual= "select idRendimentoAnual from rendimentoAnual";
  $selectAnual= mysqli_query($conex, $sqlAnual);
  $idRendimentoAnual = mysqli_fetch_assoc($selectAnual);

  $deleteDiario = "delete from rendimentoDiario where idRendimentoDiario = ".$idRendimentoDiario['idRendimentoDiario'];

  $deleteMensal = "delete from rendimentoMensal where idRendimentoMensal = ".$idRendimentoMensal['idRendimentoMensal'];

  $deleteAnual = "delete from rendimentoAnual where idRendimentoAnual = ".$idRendimentoAnual['idRendimentoAnual'];

  if(mysqli_query($conex, $deleteDiario) && mysqli_query($conex, $deleteMensal) && mysqli_query($conex, $deleteAnual)){

    $sql = "delete from tblRegistro where tblRegistro.idRegistro = ".$id;
          
    if(mysqli_query($conex, $sql))
        return true;
    else
        return false;
      
  }
}

function listarClientesPagantes($args){

 //Import do arquivo de Variaveis e Constantes
 require_once('../modulo/config.php');

 //Import do arquivo de função para conectar no BD  
 require_once('conexaoMysql.php');

 if(!$conex = conexaoMysql())
 {
     echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
 }

 $sql = "select tblCliente.*, tblVeiculo.placa, tblVeiculo.cor
        from tblCliente, tblVeiculo
        where tblCliente.idVeiculo = tblVeiculo.idVeiculo
        and tblCliente.valorAPagar <> 'null'";

        if($args == 'diario'){

            $sql = $sql . "and day(tblCliente.horarioSaida) = day(current_date())";
        }

        if($args == 'mensal'){

            $sql = $sql . "and month(tblCliente.horarioSaida) = month(current_date())";
        }

        if($args == 'anual'){

            $sql = $sql . "and year(tblCliente.horarioSaida) = year(current_date())";
        }
       

        $select = mysqli_query($conex, $sql);
        
        while($rsClientes = mysqli_fetch_assoc($select)) {
            //varios itens para o json
            $dados[] = array (
                //          => - o que alimenta o dado de um array
                'idCliente'         => $rsClientes['idCliente'],
                'nomeCliente'       => $rsClientes['nomeCliente'],
                'placa'             => $rsClientes['placa'],
                'cor'               => $rsClientes['cor'],
                'horarioEntrada'    => $rsClientes['horarioEntrada'],
                'horarioSaida'      => $rsClientes['horarioSaida'],
                'valorAPagar'       => "R$".$rsClientes['valorAPagar']
             
            );            
        }

    
    if(isset($dados))
        return $dados;
    else 
        return false;

}

function relatorioDiario($idRegistro, $tipoRelatorio){

  //Import do arquivo de Variaveis e Constantes
  require_once('../modulo/config.php');

  //Import do arquivo de função para conectar no BD  
  require_once('conexaoMysql.php');

  if(!$conex = conexaoMysql())
  {
      echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
  }

    $informacao = contagemEValor($tipoRelatorio);

    $sqlSelect = "select * from rendimentoDiario";
    $select = mysqli_query($conex, $sqlSelect);
    $rsRelatorioDiario = mysqli_fetch_assoc($select);

    if($rsRelatorioDiario['qtde_de_clientes'] == null && $rsRelatorioDiario['valorTotal'] == null){

        $sqlInsert = "insert into rendimentoDiario(data, qtde_de_clientes, valorTotal, idRegistro)
        values(

        curdate(), 
        ".$informacao[0]['qtde_de_clientes'].", 
        ".$informacao[0]['valorTotal'].", 
        ".$idRegistro."

            )";

        mysqli_query($conex, $sqlInsert);

        $sqlSelect = "select * from rendimentoDiario";
        $select = mysqli_query($conex, $sqlSelect);

        while($rsRelatorioDiario = mysqli_fetch_assoc($select)){

            $dados[] = array(
    
                "data"                  => $rsRelatorioDiario['data'],
                "quantidadeDeClientes"  => $rsRelatorioDiario['qtde_de_clientes'],
                "valorTotal"            => "R$".$rsRelatorioDiario['valorTotal']
    
            );

          
            
            if(isset($dados))
                return $dados;
            else
                return false;
        }


    }
    elseif($rsRelatorioDiario['qtde_de_clientes'] != $informacao[0]['qtde_de_clientes'] || $rsRelatorioDiario['valorTotal'] != $informacao[0]['valorTotal'])
    {
        $sqlUpdate = "update rendimentoDiario set

        data = current_date(),
        qtde_de_clientes = ".$informacao[0]['qtde_de_clientes'].",
        valorTotal = ".$informacao[0]['valorTotal']."

        where rendimentoDiario.idRegistro = ".$idRegistro;

        mysqli_query($conex, $sqlUpdate);

        $sqlSelect = "select * from rendimentoDiario";
        $select = mysqli_query($conex, $sqlSelect);

        while($rsRelatorioDiario = mysqli_fetch_assoc($select)){

            $dados[] = array(
    
                "data"                  => $rsRelatorioDiario['data'],
                "quantidadeDeClientes"  => $rsRelatorioDiario['qtde_de_clientes'],
                "valorTotal"            => "R$".$rsRelatorioDiario['valorTotal']
    
            );


            if(isset($dados))
                return $dados;
            else
                return false;

        }
    }
    else{

        $sqlSelect = "select * from rendimentoDiario";
        $select = mysqli_query($conex, $sqlSelect);

        while($rsRelatorioDiario = mysqli_fetch_assoc($select)){

            $dados[] = array(
    
                "data"                  => $rsRelatorioDiario['data'],
                "quantidadeDeClientes"  => $rsRelatorioDiario['qtde_de_clientes'],
                "valorTotal"            => "R$".$rsRelatorioDiario['valorTotal']
    
            );

        if(isset($dados))
            return $dados;
        else
            return false;


        }
     
    }
}

function relatorioMensal($idRegistro, $tipoRelatorio){

    //Import do arquivo de Variaveis e Constantes
    require_once('../modulo/config.php');
    
    //Import do arquivo de função para conectar no BD  
    require_once('conexaoMysql.php');
    
    if(!$conex = conexaoMysql())
    {
    echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
    }
    
    $informacao = contagemEValor($tipoRelatorio);
    
    $sqlSelect = "select * from rendimentoMensal";
    $select = mysqli_query($conex, $sqlSelect);
    $rsRelatoriomensal = mysqli_fetch_assoc($select);
    
    if($rsRelatoriomensal['qtde_de_clientes'] == null && $rsRelatoriomensal['valorTotal'] == null){
    
      $sqlInsert = "insert into rendimentoMensal(mes, qtde_de_clientes, valorTotal, idRegistro)
      values(
    
      month(curdate()), 
      ".$informacao[0]['qtde_de_clientes'].", 
      ".$informacao[0]['valorTotal'].", 
      ".$idRegistro."
    
          )";
    
      mysqli_query($conex, $sqlInsert);
    
      $sqlSelect = "select * from rendimentoMensal";
      $select = mysqli_query($conex, $sqlSelect);
    
      while($rsRelatoriomensal = mysqli_fetch_assoc($select)){
    
          $dados[] = array(
    
              "data"                  => $rsRelatoriomensal['mes'],
              "quantidadeDeClientes"  => $rsRelatoriomensal['qtde_de_clientes'],
              "valorTotal"            => "R$".$rsRelatoriomensal['valorTotal']
    
          );
    
        
          
          if(isset($dados))
              return $dados;
          else
              return false;
      }
    
    
    }
    elseif($rsRelatoriomensal['qtde_de_clientes'] != $informacao[0]['qtde_de_clientes'] || $rsRelatoriomensal['valorTotal'] != $informacao[0]['valorTotal'])
    {
      $sqlUpdate = "update rendimentoMensal set
    
      mes = month(current_date()),
      qtde_de_clientes = ".$informacao[0]['qtde_de_clientes'].",
      valorTotal = ".$informacao[0]['valorTotal']."
    
      where rendimentoMensal.idRegistro = ".$idRegistro;
    
      mysqli_query($conex, $sqlUpdate);
    
      $sqlSelect = "select * from rendimentoMensal";
      $select = mysqli_query($conex, $sqlSelect);
    
      while($rsRelatorioMensal = mysqli_fetch_assoc($select)){
    
          $dados[] = array(
    
              "data"                  => $rsRelatorioMensal['mes'],
              "quantidadeDeClientes"  => $rsRelatorioMensal['qtde_de_clientes'],
              "valorTotal"            => "R$".$rsRelatorioMensal['valorTotal']
    
          );
    
    
          if(isset($dados))
              return $dados;
          else
              return false;
    
      }
    }
    else{
    
      $sqlSelect = "select * from rendimentoMensal";
      $select = mysqli_query($conex, $sqlSelect);
    
      while($rsRelatorioMensal = mysqli_fetch_assoc($select)){
    
          $dados[] = array(
    
              "data"                  => $rsRelatorioMensal['mes'],
              "quantidadeDeClientes"  => $rsRelatorioMensal['qtde_de_clientes'],
              "valorTotal"            => "R$".$rsRelatorioMensal['valorTotal']
    
          );
    
      if(isset($dados))
          return $dados;
      else
          return false;
    
    
      }
    
    }
    
}

function relatorioAnual($idRegistro, $tipoRelatorio){

    //Import do arquivo de Variaveis e Constantes
    require_once('../modulo/config.php');
    
    //Import do arquivo de função para conectar no BD  
    require_once('conexaoMysql.php');
    
    if(!$conex = conexaoMysql())
    {
    echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
    }
    
    $informacao = contagemEValor($tipoRelatorio);
    
    $sqlSelect = "select * from rendimentoAnual";
    $select = mysqli_query($conex, $sqlSelect);
    $rsRelatorioAnual = mysqli_fetch_assoc($select);
    
    if($rsRelatorioAnual['qtde_de_clientes'] == null && $rsRelatorioAnual['valorTotal'] == null){
    
      $sqlInsert = "insert into rendimentoAnual(ano, qtde_de_clientes, valorTotal, idRegistro)
      values(
    
      year(curdate()), 
      ".$informacao[0]['qtde_de_clientes'].", 
      ".$informacao[0]['valorTotal'].", 
      ".$idRegistro."
    
          )";
    
      mysqli_query($conex, $sqlInsert);
    
      $sqlSelect = "select * from rendimentoAnual";
      $select = mysqli_query($conex, $sqlSelect);
    
      while($rsRelatorioAnual = mysqli_fetch_assoc($select)){
    
          $dados[] = array(
    
              "data"                  => $rsRelatorioAnual['ano'],
              "quantidadeDeClientes"  => $rsRelatorioAnual['qtde_de_clientes'],
              "valorTotal"            => "R$".$rsRelatorioAnual['valorTotal']
    
          );
    
        
          
          if(isset($dados))
              return $dados;
          else
              return false;
      }
    
    
    }
    elseif($rsRelatorioAnual['qtde_de_clientes'] != $informacao[0]['qtde_de_clientes'] || $rsRelatorioAnual['valorTotal'] != $informacao[0]['valorTotal'])
    {
      $sqlUpdate = "update rendimentoAnual set
    
      ano = year(current_date()),
      qtde_de_clientes = ".$informacao[0]['qtde_de_clientes'].",
      valorTotal = ".$informacao[0]['valorTotal']."
    
      where rendimentoAnual.idRegistro = ".$idRegistro;
    
      mysqli_query($conex, $sqlUpdate);
    
      $sqlSelect = "select * from rendimentoAnual";
      $select = mysqli_query($conex, $sqlSelect);
    
      while($rsRelatorioAnual = mysqli_fetch_assoc($select)){
    
          $dados[] = array(
    
              "data"                  => $rsRelatorioAnual['ano'],
              "quantidadeDeClientes"  => $rsRelatorioAnual['qtde_de_clientes'],
              "valorTotal"            => "R$".$rsRelatorioAnual['valorTotal']
    
          );
    
    
          if(isset($dados))
              return $dados;
          else
              return false;
    
      }
    }
    else{
    
      $sqlSelect = "select * from rendimentoAnual";
      $select = mysqli_query($conex, $sqlSelect);
    
      while($rsRelatorioAnual = mysqli_fetch_assoc($select)){
    
          $dados[] = array(
    
              "data"                  => $rsRelatorioAnual['ano'],
              "quantidadeDeClientes"  => $rsRelatorioAnual['qtde_de_clientes'],
              "valorTotal"            => "R$".$rsRelatorioAnual['valorTotal']
    
          );
    
      if(isset($dados))
          return $dados;
      else
          return false; 
    
      }    
    }
}

function contagemEValor($args){

     //Import do arquivo de Variaveis e Constantes
  require_once('../modulo/config.php');

  //Import do arquivo de função para conectar no BD  
  require_once('conexaoMysql.php');

  if(!$conex = conexaoMysql())
  {
      echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
  }

    
  $sqlQtdeClientes = "select count(*) as qtdeClientes from tblCliente
                      where tblCliente.valorAPagar <> 'null'";

  $sqlValorTotal = "select sum(valorAPagar) as valorTotal from tblCliente
                    where tblCliente.valorAPagar <> 'null'";

    switch($args){

        case 'diario':
        $sqlQtdeClientes = $sqlQtdeClientes . "and day(tblCliente.horarioSaida) = day(current_date())";
        $selectQtdeClientes = mysqli_query($conex, $sqlQtdeClientes);
        $qtde_de_clientes = mysqli_fetch_assoc($selectQtdeClientes);

        $sqlValorTotal = $sqlValorTotal . "and day(tblCliente.horarioSaida) = day(current_date())";
        $selectValorTotal = mysqli_query($conex, $sqlValorTotal);
        $valorTotal = mysqli_fetch_assoc($selectValorTotal);
        break;

        case 'mensal':
        $sqlQtdeClientes = $sqlQtdeClientes . "and month(tblCliente.horarioSaida) = month(current_date())";
        $selectQtdeClientes = mysqli_query($conex, $sqlQtdeClientes);
        $qtde_de_clientes = mysqli_fetch_assoc($selectQtdeClientes);

        $sqlValorTotal = $sqlValorTotal . "and month(tblCliente.horarioSaida) = month(current_date())";
        $selectValorTotal = mysqli_query($conex, $sqlValorTotal);
        $valorTotal = mysqli_fetch_assoc($selectValorTotal);
        break;

        case 'anual':
        $sqlQtdeClientes = $sqlQtdeClientes . "and year(tblCliente.horarioSaida) = year(current_date())";
        $selectQtdeClientes = mysqli_query($conex, $sqlQtdeClientes);
        $qtde_de_clientes = mysqli_fetch_assoc($selectQtdeClientes);

        $sqlValorTotal = $sqlValorTotal . "and year(tblCliente.horarioSaida) = year(current_date())";
        $selectValorTotal = mysqli_query($conex, $sqlValorTotal);
        $valorTotal = mysqli_fetch_assoc($selectValorTotal);
        break;

    }

    $information[] = array(

        "qtde_de_clientes"  => $qtde_de_clientes['qtdeClientes'],
        "valorTotal"        => $valorTotal['valorTotal']
    );

    return $information;

}