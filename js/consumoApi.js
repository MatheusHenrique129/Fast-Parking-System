'use strict';

const nomeCliente = document.getElementById('nomeCliente');

const placaCarro = document.getElementById('placaCarro');

const corCarro = document.getElementById('corCarro');

const botaoCadastrar = document.getElementById('buttonCadastrar');

const modalComprovante = document.getElementById('modalComprovante');

// POST - INSERIR UM CLIENTE NO SISTEMA
function criarCliente( cliente ) {
    const url = 'http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/clientes';
    const options = {
      method: 'POST',
      headers: {

        'Content-Type':'application/json'

      },
      body: JSON.stringify(cliente)
     
    };
  
  fetch(url, options)
}

let cliente;
const dadosCliente = () => {
  cliente = {
    "nomeCliente": nomeCliente.value,
    "placa": placaCarro.value,
    "cor": corCarro.value
  }
  criarCliente(cliente)
  location.reload()
};


// GET- LISTAR OS CLIENTES REGISTRADOS

const getClientes = () =>{
  const url = `http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/clientes`;  
  fetch(url).then(response => response.json())
            .then(data =>  repeticao(data));    
}

const insertToElement = (element) => {

  const tr = document.createElement('tr');

  tr.classList.add('colunas');

  tr.innerHTML = `
  
    <td class="info">${element.nomeCliente}</td>
    <td class="info">${element.placa}</td>
    <td class="info">${element.cor}</td>
    <td class="info">${element.horarioEntrada}</td>
    <td class="info">
    <div class="buton-options">
      <input type="submit" name="btnCadastrar" value="Excluir" onclick="excluirCliente(${element.idCliente})" class="excluir-cliente">
    </div>
    <div class="buton-options">
    <input onclick="chamaComprovante(); updateCliente(${element.idCliente}); alertComprovante()" type="submit" name="btnCadastrar" value="Gerar Comprovante" id="botaoExcluir" class="emitir-comprovante">
    </div>
    
    </td>
    `;

  return tr;
 
}

const repeticao = (data) => {

  const container = document.getElementById('tbl-Clientes');
  
  data.forEach(element => {
    container.appendChild(insertToElement(element));

  });

}

// DELETE - EXCLUIR UM CLIENTE NO SISTEMA
function excluirCliente(idCliente){

    const url = `http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/clientes/${idCliente}`;
    const options = {
      method: 'DELETE',
      headers: {

        'Content-Type':'application/json'

      },
    }
    fetch(url, options)
    location.reload()

}

// PUT- ATUALIZAR OS DADOS DO CLIENTE 

function updateCliente(idCliente){

  const url = `http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/clientes/${idCliente}`;
  const options = {
    method: 'PUT',
    headers: {

      'Content-Type':'application/json'

    },
  }

  fetch(url, options).then(response => response.json())
                     .then(data =>  repeticaoComprovante(data)); 

}

function emitirComprovante(element){

  const modalContainer = document.createElement('div');

  modalContainer.id = 'modalComprovante';
  modalContainer.classList.add('centerObject');

  modalContainer.innerHTML = `
  <div onclick="fechaComprovante(); location.reload()" class="fechar-modal">X</div>
            <div id="modal-comprovanteConteudo">
                <i class="far fa-check-circle icon-comprovanteModal"></i>
                <h2>Comprovante</h2>
                <p>${element.horarioSaida}</p>
            </div>
            <div class="divideIconeModal">
                <i class="fas fa-user icon-carModal"></i>
                <h3>Informações Do Cliente</h3>
            </div>
            <div class="textComprovante">
                <h3>Nome</h3>
                <p>${element.nomeCliente}</p>
            </div>
            <div class="textComprovante">
                <h3>Valor</h3>
                <p>${element.valorAPagar}</p>
            </div>
            <div class="divideIconeModal">
                <i class="fas fa-car icon-carModal"></i>
                <h3>Informações Do Carro</h3>
            </div>
            <div class="textComprovante">
                <h3>Cor Do Carro</h3>
                <p>${element.cor}</p>
            </div>
            <div class="textComprovante">
                <h3>Horario de Entrada</h3>
                <p>${element.horarioEntrada}</p>
            </div>
            <div id="footerModal" class="centerObject">
                <img src="imagens/logo_header.png" width="130" height="60" alt="Logo do Comprovante">
            </div>
  `;

  return modalContainer;

}

const repeticaoComprovante = (data) => {

  const containerModalComprovante = document.getElementById('containerModalComprovante');
  
  data.forEach(element => {

    containerModalComprovante.appendChild(emitirComprovante(element));

  });

}

botaoCadastrar.addEventListener('click', dadosCliente);

getClientes();
