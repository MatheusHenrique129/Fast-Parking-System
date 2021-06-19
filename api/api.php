<?php 

require_once("vendor/autoload.php"); 


$app = new \Slim\App();


$app->get('/clientes', function($request, $response, $args){

    
    require_once('../bd/funcoesApi.php');


    $listarClientes = listarClientes(0);


    if($listarClientes) { // função para listar todos os contatos 
        return $response    -> withStatus(200)
                            -> withHeader('Content-Type', 'application/json')
                            -> write(json_encode($listarClientes));
        //widthStatus (status http)
        //widthHeader ('Content-Type' , 'application/tipo')
        //write() escreve na tela
    }else {
        return $response    -> withStatus(400);
    } 
    

});

$app->get('/clientes/{id}', function($request, $response, $args){

    $id = $args['id'];
    
    require_once('../bd/funcoesApi.php');

    $listarClientes = listarClientes($id);
    
    if($listarClientes) { // função para listar todos os contatos 
        return $response    -> withStatus(200)
                            -> withHeader('Content-Type', 'application/json')
                            -> write(json_encode($listarClientes));
        //widthStatus (status http)
        //widthHeader ('Content-Type' , 'application/tipo')
        //write() escreve na tela
    }else {
        return $response    -> withStatus(400);
    } 
    

});


$app->post('/clientes', function($request, $response, $args){


    $contentType = $request->getHeaderLine('Content-Type');

    if($contentType == 'application/json') {
            //recebe todos os dados enviados para a api
        $dadosJson = $request->getParsedBody();
    
        if ($dadosJson=="" || $dadosJson==null) {

            return $response -> withStatus(400)
                            -> withHeader('Content-Type', 'application/json')
                            -> write('
                                {
                                    "status":"Fail",
                                    "Message":"Dados enviados não podem ser nulos"
                                }
                                ');

        }
        else{

    
            require_once('../bd/funcoesApi.php');

            if($dados = inserirCliente($dadosJson)){

                return $response -> withStatus(201)
                                -> withHeader('Content-Type', 'application/json')
                                -> write(json_encode($dados)); 

            }else {

                return $response -> withStatus(401)
                                -> withHeader('Content-Type', 'application/json')
                                -> write('
                                        {
                                        "status":"Fail",
                                        "Message":"Falha ao inserir os dados no BD. Verificar se os dados enviados estão corretos"
                                        }
                                    ');

            }


        }

    }else {
        //mensagem de erro de Content-Type
        return $response -> withStatus(415)
                        -> withHeader('Content-Type', 'application/json')
                        -> write('
                                {
                                    "status":"Fail",
                                    "Message":"Erro no Content-Type da Requisição"

                                }');

        }

});

$app->put('/clientes/{id}', function($request, $response, $args){


    $id = $args['id'];
     
    require_once('../bd/funcoesApi.php');

    $getClientes = listarClientes($id);

    $retornoFuncao = atualizarCliente($id);
     
     if($retornoFuncao){
         if($getClientes[0]['valorAPagar'] == "null" || $getClientes[0]['horarioSaida'] == null){

             return $response ->withStatus(200)
                              ->withHeader('Content-type', 'application/json')
                              ->write(json_encode($retornoFuncao));
        }
        else{

            return $response    ->withStatus(409)
                                ->withHeader('Content-type', 'application/json')
                                ->write('{

                                        "status":"Fail",
                                        "message":"Esse cliente já foi atualizado."

                                        }');
        }
     }
     else{
         
         return $response    ->withStatus(400)
                             ->withHeader('Content-type', 'application/json')
                             ->write('
                             
                                     {
                                     
                                     "status":"Fail",
                                     "message":"Cliente inexistente."
                                     
                                     }
                             
                                     ');
     }
     


});


$app->delete('/clientes/{id}', function($request, $response, $args){

    $id = $args['id'];
    
    require_once('../bd/funcoesApi.php');
    
    if($delete = excluirCliente($id)){
        
        return $response    ->withStatus(200)
                            ->withHeader('Content-type', 'application/json')
                            ->write('
                            
                                    {
                                    
                                    "status":"Sucesso",
                                    "message":"Contato deletado com sucesso."

                                    }
                            
                                    ');
        
    }
    else {
        
        return $response    ->withStatus(400)
                            ->write('
                            
                            {

                                "status":"Falha",
                                "message":"Erro ao deletar o contato no banco de dados. 

                            }

                          ');
    }


});

$app->get('/registro', function($request, $response, $args){

    require_once('../bd/funcoesApi.php');

    $listarRegistros = listarRegistro();

    if($listarRegistros) { // função para listar todos os contatos 
        return $response    -> withStatus(200)
                            -> withHeader('Content-Type', 'application/json')
                            -> write(json_encode($listarRegistros));
        //widthStatus (status http)
        //widthHeader ('Content-Type' , 'application/tipo')
        //write() escreve na tela
    }else {
        return $response    -> withStatus(400);
    } 
    

});

$app->post('/registro', function($request, $response, $args){

    require_once('../bd/funcoesApi.php');

    $contentType = $request->getHeaderLine('Content-Type');

    if(listarRegistro() == null){
        if($contentType == 'application/json') {
                //recebe todos os dados enviados para a api
            $dadosJson = $request->getParsedBody();
        
            if ($dadosJson=="" || $dadosJson==null) {

                return $response -> withStatus(400)
                                 -> withHeader('Content-Type', 'application/json')
                                 -> write('
                                    {
                                        "status":"Fail",
                                        "Message":"Dados enviados não podem ser nulos"
                                    }
                                    ');

            }
            else{

                if($dados = inserirRegistro($dadosJson)){

                    return $response -> withStatus(201)
                                     -> withHeader('Content-Type', 'application/json')
                                     -> write(json_encode($dados)); 

                }else {

                    return $response -> withStatus(401)
                                     -> withHeader('Content-Type', 'application/json')
                                     -> write('
                                            {
                                            "status":"Fail",
                                            "Message":"Falha ao inserir os dados no BD. Verificar se os dados enviados estão corretos"
                                            }
                                        ');

                }

            }
        }else {
            //mensagem de erro de Content-Type
            return $response -> withStatus(415)
                            -> withHeader('Content-Type', 'application/json')
                            -> write('
                                    {
                                        "status":"Fail",
                                        "Message":"Erro no Content-Type da Requisição"

                                    }');

            }
    }else{

        return $response -> withStatus(409)
                        -> withHeader('Content-Type', 'application/json')
                        -> write('
                                {
                                    "status":"Fail",
                                    "Message":"Já existe um registro no banco de dados."

                                }');

    }

});

$app->put('/registro', function($request, $response, $args){

    $contentType = $request->getHeaderLine('Content-type', 'application/json');

    if($contentType == 'application/json') {

        $dadosJson = $request->getParsedBody();

        if ($dadosJson=="" || $dadosJson==null) {

            return $response -> withStatus(400)
                            -> withHeader('Content-Type', 'application/json')
                            -> write('
                                    {
                                        "status":"Fail",
                                        "Message":"Dados enviados não podem ser nulos"
                                    }
                                    ');

        }
        else{

        require_once('../bd/funcoesApi.php');

        $getRegistro = listarRegistro();

        $retornoFuncao = atualizarRegistro($dadosJson);
        
            if($retornoFuncao){

                if($getRegistro[0]['idRegistro'] == $retornoFuncao[0]['idRegistro']){
                    
                    return $response    ->withStatus(200)
                                        ->withHeader('Content-type', 'application/json')
                                        ->write(json_encode($retornoFuncao));
                }
                else{

                    return $response    ->withStatus(412)
                                        ->withHeader('Content-type', 'application/json')
                                        ->write('
                                                {

                                                "status":"Fail",
                                                "message":"Não é permitido mudar o ID do registro!"

                                                }');

                    } 
        }else{
            
            return $response    ->withStatus(400)
                                ->withHeader('Content-type', 'application/json')
                                ->write('
                                
                                        {
                                        
                                        "status":"Fail",
                                        "message":"Falha ao atualizar o registro."
                                        
                                        }
                                
                                        ');

            }
        }

    }else{

        return $response -> withStatus(415)
                        -> withHeader('Content-Type', 'application/json')
                        -> write('
                                {
                                    "status":"Fail",
                                    "Message":"Erro no Content-Type da Requisição"

                                }');

    }
     

});

$app->delete('/registro/{id}', function($request, $response, $args){

    $idRegistro = $args['id'];  

    require_once('../bd/funcoesApi.php');
    
    if(excluirRegistro($idRegistro)){
        
        return $response    ->withStatus(200)
                            ->withHeader('Content-type', 'application/json')
                            ->write('
                            
                                    {
                                    
                                    "status":"Sucesso",
                                    "message":"Registro deletado com sucesso."

                                    }
                            
                                    ');
        
    }
    else {
        
        return $response    ->withStatus(400)
                            ->withHeader('Content-type', 'application/json')
                            ->write('
                            
                                {

                                "status":"Falha",
                                "message":"Erro ao deletar o registro no no banco de dados. 

                                }

                                  ');
    }

});

$app->get('/relatorios/{tipo}', function($request, $response, $args){

    $tipo = $args['tipo'];

    require_once('../bd/funcoesApi.php');

    $listarClientes = listarClientesPagantes($tipo);

    $idRegistro = listarRegistro();

    switch($tipo){

        case('diario'):
            $relatorio = relatorioDiario($idRegistro[0]['idRegistro'], $tipo);
            break;
        
        case('mensal'):
            $relatorio = relatorioMensal($idRegistro[0]['idRegistro'], $tipo);
            break;

        case('anual'):
            $relatorio = relatorioAnual($idRegistro[0]['idRegistro'], $tipo);
            break;

    }


    if($relatorio) {
            return $response    -> withStatus(200)
                                -> withHeader('Content-Type', 'application/json')
                                -> write('
                                        {

                                        "status":"Sucess",
                                        "clientes": '.json_encode($listarClientes).',

                                        "relatorio":'.json_encode($relatorio).'

                                        }');

    }else {
        return $response    -> withStatus(400)
                            -> withHeader('Content-Type', 'application/json')
                            -> write('{

                                    "status":"Fail",
                                    "message":"Falha ao trazer o relatório diário."

                                    }');
    } 
    


});


$app->run();