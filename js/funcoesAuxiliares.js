// ALERT PARA CONFIRMAÇÃO DE EMISSÃO DO COMPROVANTE

function alertComprovante(){

    alert('Tem certeza que deseja emitir o comprovante desse cliente?');
  
  }

// EVENTO DE SAIR DA PÁGINA 

function sair() {
    window.history.back();
}

//Nota: esta função não está funcionando
function clearContainer(){

  let colunaInformacao = document.getElementsByClassName('colunas');

  colunaInformacao[0] = " ";


}