'use strict'

const containerConteudo = document.getElementById('clientes');

const consultaCliente = document.getElementById('consultarCliente');

const chamaCliente = document.getElementById('index-cliente');

const relatorios = document.getElementById('relatorios');

const cmsLink = document.getElementById('cms');

const chamaRelatorio = document.getElementById('index-relatorio');


/*SEÇÃO DE ATUALIZAR O RELATÓRIO*/

const chamaSelect = document.getElementById('chamaSelect');

const chamaDiaria = document.getElementById('chamaDiaria');

const chamaMensal = document.getElementById('chamaMensal');

const chamaAnual = document.getElementById('chamaAnual');

const chamaCms = document.getElementById('index-cms');


function consulta() {
    
    chamaRelatorio.style.display = 'none';
    chamaCms.style.display = 'none';
    chamaCliente.style.display = 'block';
    
}


function relatorio() {
    
   chamaCliente.style.display = 'none';  
    chamaCms.style.display = 'none';
   chamaRelatorio.style.display = 'block';
} 

function cms() {
    
    chamaCliente.style.display = 'none';
    chamaRelatorio.style.display = 'none';
    chamaCms.style.display = 'block';
}

function mudarRelatorio() {
    
    const chamaDiaria = document.getElementById('chamaDiaria');
    const chamaMensal = document.getElementById('chamaMensal');
    const chamaAnual = document.getElementById('chamaAnual');
 
    const chamaSelect = document.getElementById('chamaSelect');
   
    const containerRelatorio = document.getElementById('segura-tblRelatorio');
    
    
    if (chamaSelect.value == 'Diaria')
        {
            chamaMensal.style.display = 'none';
            chamaAnual.style.display = 'none';
            
            chamaDiaria.style.display = 'block';
    

        }
    
    if (chamaSelect.value == 'Mensal')
    {
        chamaDiaria.style.display = 'none';
        chamaAnual.style.display = 'none';
        
        chamaMensal.style.display = 'block';
   
    }
    
    if (chamaSelect.value == 'Anual')
        {
            chamaDiaria.style.display = 'none';
            chamaMensal.style.display = 'none';
            
            chamaAnual.style.display = 'block';
            
         }    
}


chamaSelect.addEventListener('change', mudarRelatorio);
consultarCliente.addEventListener('click', consulta);
relatorios.addEventListener('click', relatorio);
cmsLink.addEventListener('click', cms);


