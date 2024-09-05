// Função para salvar os dados do formulário no localStorage
function salvarDadosFormulario() {
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;
  
    // Armazenar os dados no localStorage
    localStorage.setItem('email', email);
    localStorage.setItem('senha', senha); // Pode não ser recomendável salvar senhas assim, apenas para fins educacionais
  }
  
  // Função para carregar os dados armazenados do localStorage
  function carregarDadosFormulario() {
    const emailSalvo = localStorage.getItem('email');
    const senhaSalva = localStorage.getItem('senha');
  
    // Verificar se os dados existem e preencher os campos
    if (emailSalvo) {
      document.getElementById('email').value = emailSalvo;
    }
    if (senhaSalva) {
      document.getElementById('senha').value = senhaSalva;
    }
  }
  
  // Função para limpar os dados armazenados
  function limparDadosFormulario() {
    localStorage.removeItem('email');
    localStorage.removeItem('senha');
  }
  
  // Adicionar os eventos aos campos e botões
  document.addEventListener('DOMContentLoaded', function () {
    carregarDadosFormulario(); // Carregar dados quando a página carregar
  
    // Salvar os dados quando o formulário for submetido
    const form = document.getElementById('loginForm');
    form.addEventListener('submit', function () {
      salvarDadosFormulario();
    });
  
    // Caso queira limpar os dados quando o utilizador clicar no botão "Voltar"
    const voltar = document.querySelector('a[href="./index.php"]');
    if (voltar) {
      voltar.addEventListener('click', function () {
        limparDadosFormulario();
      });
    }
  });
  