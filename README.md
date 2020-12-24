# ProjetoUpdated
versão atualizada do projeto integrado com relatórios na API 

## Domínio da API:

http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/


ENDPOINTS:

**Título**          | **Listar, inserir clientes no sistema**
--------------------|-
Endpoint            | /clientes 
Método              | POST, GET
Resposta de sucesso | Código: 200 Retorna o JSON com os dados do cliente
Resposta de erro    | Código: 400 Bad Request
Resposta de erro    | Código: 401 {"status":"Fail", "Message":"Falha ao inserir os dados no BD. Verificar se os dados enviados estão corretos"}
Resposta de erro    | Código: 415 {"status":"Fail", "Message":"Erro no Content-Type da Requisição"}


**Título**          | **Atualizar e excluir clientes no sistema**
--------------------|-
Endpoint            | /clientes/{id}
Método              | PUT, DELETE
Resposta de sucesso | (PUT): Código 200 - Retorna o JSON com os dados atualizados
Resposta de sucesso | (DELETE): Código 200   { "status":"Sucesso", "message":"Contato deletado com sucesso." }
Resposta de erro    | (PUT): Código: 409 '{"status":"Fail", "message":"Esse cliente já foi atualizado."}'
Resposta de erro    | (PUT): Código: 400 {"status":"Fail","message":"Cliente inexistente."}              
Resposta de erro    | (DELETE): Código: 415 {"status":"Falha", "message":"Erro ao deletar o contato no banco de dados. }


~~~
{id} -- corresponde ao ID do campo no banco de dados, voltado ao desenvolvedor
~~~

~~~
Registros: corresponde aos valores que a empresa precisa para determinar
quanto é cobrado por hora, quantas vagas, disponíveis e se há um desconto atribuído
~~~

**Título**          | **Buscar, inserir e atualizar um registro no sistema**
--------------------|-
Endpoint            | /registro/
Método              | GET, POST, PUT
Resposta de sucesso | Código 200 - Retorna o JSON com os dados do registro
Resposta de erro    | (GET) Código 400 Bad Request
Resposta de erro    | (POST) Código 400 {"status":"Fail", "Message":"Dados enviados não podem ser nulos"}
Resposta de erro    | (POST) Código 401 {"status":"Fail", "Message":"Falha ao inserir os dados no BD. Verificar se os dados enviados estão corretos"}
Resposta de erro    | (POST|PUT) Código 415  {"status":"Fail", "Message":"Erro no Content-Type da Requisição"}
Resposta de erro    | (POST) Código 409   {"status":"Fail", "Message":"Já existe um registro no banco de dados."}
Resposta de erro    | (PUT): Código: 409   {"status":"Fail",","Message":"Falha ao atualizar o registro."}
Resposta de erro    | (PUT): Código: 412  {"status":"Fail", "Message":"Não é permitido mudar o ID do registro!"}
Resposta de erro    | (PUT): Código: 400 {"status":"Fail","Message":"Cliente inexistente."}              

**Título**          | **Buscar, inserir e atualizar um registro no sistema**
--------------------|-
URL                 | /registro/{id}
Método              | DELETE
Resposta de sucesso | (DELETE) Código 200 -  {"status":"Sucesso","Message":"Registro deletado com sucesso."}
Resposta de erro    | (DELETE): Código: 400   {"status":"Falha","message":"Erro ao deletar o registro no no banco de dados. }


~~~
*Relatórios: Exibem quantos clientes a empresa recebeu 
em um determinado dia, mês, ou ano; 
Retorna-se a quantidade de clientes, a data e o valor total ganho
~~~

**Título**          | **Buscar, inserir e atualizar um registro no sistema**
--------------------|-
Endpoint            | /relatorios/{tipo}
Método              | GET
Resposta de sucesso | Código 200 -  {"status":"Sucess", "clientes": [{...}], "relatorio":[{...}]}
Resposta de erro    | Código 400 - {"status":"Fail", "Message":"Falha ao trazer o relatório diário." }


~~~
{tipo} -- 'diario', 'mensal', 'anual'
~~~
