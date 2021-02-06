const getRelatorioAnual = () =>{
    const url = `http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/relatorios/anual`;  
    const options = {
        method: 'GET',
        headers: {

            'Content-type': 'application/json'
        }
    };
    fetch(url).then(response => response.json())
              .then(data => listaRelatorioAnual(data));    
  }
  
function inserirTabelaAnual(element){

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

function inserirDetalhesAnual(element){

    const table = document.createElement('table');

    table.id = 'tblInformacoes-importantes';

    table.innerHTML = 
    `
    <tr class="tr-relacao">
        <td class="td-anual">Valor Total Do Ano:</td>
        <td class="td-anual">${element.valorTotal}</td>
    </tr>
    <tr class="tr-relacao">
        <td class="td-anual">Qtde de clientes:</td>
        <td class="td-anual">${element.quantidadeDeClientes}</td>
    </tr>
    
    `;

    return table;

}

function inserirDataAnual(element){

    const table = document.createElement('table');

    table.id = 'tblInfo-dataAnual';

    table.innerHTML = 
    `
    <tr id="tr-anual">
        <td class="td-anual">Ano: ${element.data}</td>
    </tr>
    
    `;

    return table;

}

const listaRelatorioAnual = (data) => {

    const container = document.getElementById('tblRelatorioAnual');
    const detalhes = document.getElementById('caixa-informacoes-importantesAnual');
    const detalheData = document.getElementById('caixa-info-dataAnual');

  
    data['clientes'].forEach(element => {
      container.appendChild(inserirTabelaAnual(element));
  
    });
    
    data['relatorio'].forEach(element => {

        detalhes.appendChild(inserirDetalhesAnual(element));
    
      });

    data['relatorio'].forEach(element => {

        detalheData.appendChild(inserirDataAnual(element));
    
      });
    
}

getRelatorioAnual();