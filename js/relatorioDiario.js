// GET Relatorio Diário

const getRelatorioDiario = () =>{
    const url = `hhttp://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/relatorios/diario`;  
    const options = {
        method: 'GET',
        headers: {

            'Content-type': 'application/json'
        }
    };
    fetch(url).then(response => response.json())
              .then(data => listaRelatorioDiario(data));    
  }
  
function inserirTabelaDiario(element){

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

function inserirDetalhesDiario(element){

    const table = document.createElement('table');

    table.id = 'tblInformacoes-importantes';

    table.innerHTML = 
    `
    <tr class="tr-relacao">
        <td class="td-diario">Valor Total Do Dia :</td>
        <td class="td-diario">${element.valorTotal}</td>
    </tr>
    <tr class="tr-relacao">
        <td class="td-diario">Qtde de clientes:</td>
        <td class="td-diario">${element.quantidadeDeClientes}</td>
    </tr>
    
    `;

    return table;

}

function inserirDataDiario(element){

    const table = document.createElement('table');

    table.id = 'tblInfo-dataDiario';

    table.innerHTML = 
    `
    <tr id="tr-diario">
        <td class="td-diario">Dia: ${element.data}</td>
    </tr>
    
    `;

    return table;

}

const listaRelatorioDiario = (data) => {

    const container = document.getElementById('tblRelatorio');
    const detalhes = document.getElementById('caixa-informacoes-importantes');
    const detalheData = document.getElementById('caixa-info-dataDiaria');

  
    data['clientes'].forEach(element => {
      container.appendChild(inserirTabelaDiario(element));
  
    });
    
    data['relatorio'].forEach(element => {

        detalhes.appendChild(inserirDetalhesDiario(element));
    
      });

    data['relatorio'].forEach(element => {

        detalheData.appendChild(inserirDataDiario(element));
    
      });    
}

getRelatorioDiario();