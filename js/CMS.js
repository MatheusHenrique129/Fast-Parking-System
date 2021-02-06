// POST CMS - Inserir os valores cobrados pela empresa

const valorPrimeiraHora = document.getElementById("valorPrimeiraHora");

const valorDemaisHoras = document.getElementById("valorDemaisHoras");

const qtde_de_vagas = document.getElementById("qtde_de_vagas");

const desconto = document.getElementById("desconto");

const enviarCms = document.getElementById("enviarCms");

const atualizarCms = document.getElementById("atualizarCms");

const excluirCms = document.getElementById("excluirCms");

function criarRegistro(registro) {
  const url =
    "http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/registro";
  const options = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(registro),
  };

  fetch(url, options);
}

let registro;
const dadosRegistro = () => {
  registro = {
    valorPrimeiraHora: valorPrimeiraHora.value,
    valorDemaisHoras: valorDemaisHoras.value,
    quantidadeDeVagas: qtde_de_vagas.value,
    desconto: desconto.value,
  };
  criarRegistro(registro);
  alert("Valores inseridos com sucesso!");
};

// GET CMS - Mostrar os valores do sistema

const getRegistro = () => {
  const url = `http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/registro`;
  fetch(url)
    .then((response) => response.json())
    .then((data) => insertCms(data));
};

const insertCms = (data) => {
  const div = document.getElementById("listagemCms");

  div.innerHTML = `
<form name="frmCms" id="segura-conteudocms">

  <div class="cmsList centerObject">
      <div class="cmsItem">
          <p> Valor Primeira Hora: </p>
      </div>
      <div class="cmsResult">
          <i class="fas fa-grip-vertical icon-grip"></i>
          <p>R$ ${data[0].valorPrimeiraHora}</p>
      </div>
  </div>

  <div class="cmsList centerObject">
      <div class="cmsItem">
          <p> Valor Demais Horas: </p>
      </div>
      <div class="cmsResult">
          <i class="fas fa-grip-vertical icon-grip"></i>
          <p>R$ ${data[0].valorDemaisHoras}</p>
      </div>
  </div>

  <div class="cmsList centerObject">
      <div class="cmsItem">
          <p> Qtde de Vagas: </p>
      </div>
      <div class="cmsResult">
          <i class="fas fa-grip-vertical icon-grip"></i>
          <p>${data[0].quantidadeDeVagas}</p>
      </div>
  </div>

  <div class="cmsList centerObject">
      <div class="cmsItem">
          <p> Desconto: </p>
      </div>
      <div class="cmsResult">
          <i class="fas fa-grip-vertical icon-grip"></i>
          <p>${data[0].desconto}</p>
      </div>
  </div>
</form>

  `;

  return div;
};

// !!NÃO FUNCIONANDO A PARTIR DAQUI!!

//PUT CMS - Atualizar os valores do sistema

function updateRegistro(registroAtualizado) {
  const url = `http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/registro`;
  const options = {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },

    body: JSON.stringify(registroAtualizado),
  };

  fetch(url, options)
    .then((response) => response.json())
    .then((data) => console.log(data));
}

let registroAtualizado;
const dadosRegistroAtualizados = () => {
  registroAtualizado = {
    valorPrimeiraHora: valorPrimeiraHora.value,
    valorDemaisHoras: valorDemaisHoras.value,
    quantidadeDeVagas: qtde_de_vagas.value,
    desconto: desconto.value,
  };
  updateRegistro(registroAtualizado);
};

const updateCaixaDados = (data) => {
  const div = document.getElementById("listagemCms");

  div.innerHTML = `
<form name="frmCms" id="segura-conteudocms">

  <div class="cmsList centerObject">
      <div class="cmsItem">
          <p> Valor Primeira Hora: </p>
      </div>
      <div class="cmsResult">
          <i class="fas fa-grip-vertical icon-grip"></i>
          <p>${data[0].valorPrimeiraHora}</p>
      </div>
  </div>

  <div class="cmsList centerObject">
      <div class="cmsItem">
          <p> Valor Demais Horas: </p>
      </div>
      <div class="cmsResult">
          <i class="fas fa-grip-vertical icon-grip"></i>
          <p>${data[0].valorDemaisHoras}</p>
      </div>
  </div>

  <div class="cmsList centerObject">
      <div class="cmsItem">
          <p> Qtde de Vagas: </p>
      </div>
      <div class="cmsResult">
          <i class="fas fa-grip-vertical icon-grip"></i>
          <p>${data[0].quantidadeDeVagas}</p>
      </div>
  </div>

  <div class="cmsList centerObject">
      <div class="cmsItem">
          <p> Desconto: </p>
      </div>
      <div class="cmsResult">
          <i class="fas fa-grip-vertical icon-grip"></i>
          <p>${data[0].desconto}</p>
      </div>
  </div>
</form>

  `;

  return div;
};

//DELETE CMS

function excluirRegistro(idRegistro) {
  const url = `http://localhost/Matheus/Projeto-Integrado/ProjetoUpdated/api/api.php/registro/${$idRegistro}`;
  const options = {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
  };
  fetch(url, options);
  location.reload();
}

enviarCms.addEventListener("click", dadosRegistro);
getRegistro();