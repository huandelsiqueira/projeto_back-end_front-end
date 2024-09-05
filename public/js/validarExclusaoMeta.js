function getUrlParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Verifica se a exclusão foi bem-sucedida
const success = getUrlParameter('success');
const message = getUrlParameter('message');

// Logs para verificar se os parâmetros estão sendo capturados corretamente
console.log('Success:', success);
console.log('Message:', message);

// Exibe a mensagem de acordo com o parâmetro
if (success === 'true') {
    alert('Meta excluída com sucesso!');
} else if (success === 'false' && message) {
    alert('Erro ao excluir meta: ' + decodeURIComponent(message));
}