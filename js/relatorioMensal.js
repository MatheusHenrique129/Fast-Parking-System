// GET Relatorio Diário


const getRelatorioMensal = () =>{
    const url = `http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/relatorios/mensal`;  
    const options = {
        method: 'GET',
        headers: {

            'Content-type': 'application/json'
        }
    };
    fetch(url).then(response => response.json())
              .then(data => listaRelatorioMensal(data));    
  }
  
function inserirTabelaMensal(element){

  const tr = document.createElement('tr');

  tr.classList.add('tr-relatorio');

  tr.innerHTML = `
  <td class="td-titulo">${element.idCliente}</td>
  <td class="td-titulo">${element.nomeCliente}</td>
  <td class="td-titulo">${element.placa}</td>
  <td class="td-titulo">${element.cor}</td>
  <td class="td-titulo">${element.horarioEntrada}</td>
  <td class="td-titulo">${element.horarioSaida}</td>
  <td class="td-titulo">${element.valorAPagar}</td>
    `;

  return tr;

}

function inserirDetalhesMensal(element){

    const table = document.createElement('table');

    table.id = 'tblInformacoes-importantes';

    table.innerHTML = 
    `
    <tr class="tr-relacao">
        <td class="td-mensal">Valor Total Do Mês :</td>
        <td class="td-mensal">${element.valorTotal}</td>
    </tr>
    <tr class="tr-relacao">
        <td class="td-mensal">Qtde de clientes:</td>
        <td class="td-mensal">${element.quantidadeDeClientes}</td>
    </tr>
    
    `;

    return table;

}

function inserirDataMensal(element){

    const table = document.createElement('table');

    table.id = 'tblInfo-dataMensal';

    table.innerHTML = 
    `
    <tr id="tr-mensal">
        <td class="td-mensal">Mês: ${element.data}</td>
    </tr>
    
    `;

    return table;

}

const listaRelatorioMensal = (data) => {

    const container = document.getElementById('tblRelatorioMensal');
    const detalhes = document.getElementById('caixa-informacoes-importantesMensal');
    const detalheData = document.getElementById('caixa-info-dataMensal');

  
    data['clientes'].forEach(element => {
      container.appendChild(inserirTabelaMensal(element));
  
    });
    
    data['relatorio'].forEach(element => {

        detalhes.appendChild(inserirDetalhesMensal(element));
    
      });

    data['relatorio'].forEach(element => {

        detalheData.appendChild(inserirDataMensal(element));
    
      });
    
}

getRelatorioMensal();