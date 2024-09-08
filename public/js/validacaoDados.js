document.addEventListener('DOMContentLoaded', function () {
    // Elementos do formulário de cadastro
    const cadastroForm = document.getElementById('cadastroForm');
    const nomeInput = document.getElementById('nome');
    const emailCadastroInput = document.getElementById('email'); // Usar 'emailCadastroInput' para evitar conflito com o formulário de login
    const senhaCadastroInput = document.getElementById('senha');

    const nomeError = document.getElementById('nomeError');
    const emailCadastroError = document.getElementById('emailError');
    const senhaCadastroError = document.getElementById('senhaError');

    // Elementos do formulário de login
    const loginForm = document.getElementById('loginForm');
    const emailLoginInput = document.getElementById('email'); // Mesma ID, mas contexto diferente
    const senhaLoginInput = document.getElementById('senha');

    const emailLoginError = document.getElementById('emailError'); // Erro do login
    const senhaLoginError = document.getElementById('passwordError'); // Erro da senha do login

    // Função de validação de email (compartilhada)
    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(String(email).toLowerCase());
    }

    // Função de validação de senha (compartilhada)
    function validatePassword(password) {
        const re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/;
        return re.test(password);
    }

    // Validações do formulário de cadastro
    if (cadastroForm) {
        cadastroForm.addEventListener('submit', function (event) {
            let valid = true;

            // Limpa as mensagens de erro
            if (nomeError) nomeError.textContent = '';
            if (emailCadastroError) emailCadastroError.textContent = '';
            if (senhaCadastroError) senhaCadastroError.textContent = '';

            // Validação do nome
            if (nomeInput && nomeInput.value.trim() === '') {
                valid = false;
                nomeError.textContent = 'Por favor, insira seu nome.';
                nomeError.style.display = 'block';
            }

            // Validação do email
            if (emailCadastroInput && !validateEmail(emailCadastroInput.value)) {
                valid = false;
                emailCadastroError.textContent = 'Por favor, insira um email válido.';
                emailCadastroError.style.display = 'block';
            }

            // Validação da senha
            if (senhaCadastroInput && !validatePassword(senhaCadastroInput.value)) {
                valid = false;
                senhaCadastroError.textContent = 'A senha deve ter no mínimo 8 caracteres, incluindo uma letra maiúscula, uma letra minúscula, um número e um caractere especial.';
                senhaCadastroError.style.display = 'block';
            }

            if (emailLoginInput && validateEmail(emailLoginInput.value)) {
                const email = emailLoginInput.value;
                const senha = senhaLoginInput.value;

                if (senhaLoginInput.value.trim() === '') {
                    valid = false;
                    senhaLoginError.textContent = 'Por favor, insira sua senha.';
                    senhaLoginError.style.display = 'block';
                } else if (!validatePassword(senhaLoginInput.value)) {
                    valid = false;
                    senhaLoginError.textContent = 'A senha deve ter no mínimo 8 caracteres, incluindo uma letra maiúscula, uma letra minúscula, um número e um caractere especial.';
                    senhaLoginError.style.display = 'block';
                } else if (validCredentials[email] && validCredentials[email] !== senha) {
                    // Verifica se o email é válido, mas a senha está incorreta
                    valid = false;
                    senhaLoginError.textContent = 'Senha incorreta.';
                    senhaLoginError.style.display = 'block';
                }
            }

            // Validação da imagem (opcional)

            // Se não for válido, evita o envio do formulário
            if (!valid) {
                event.preventDefault();
            }
        });
    }

    // Validações do formulário de login
    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            let valid = true;

            // Limpa as mensagens de erro
            if (emailLoginError) emailLoginError.textContent = '';
            if (senhaLoginError) senhaLoginError.textContent = '';

            // Validação do email de login
            if (emailLoginInput && !validateEmail(emailLoginInput.value)) {
                valid = false;
                emailLoginError.textContent = 'Por favor, insira um email válido.';
                emailLoginError.style.display = 'block';
            }

            // Validação da senha de login
            if (senhaLoginInput) {
                if (senhaLoginInput.value.trim() === '') {
                    valid = false;
                    senhaLoginError.textContent = 'Por favor, insira sua senha.';
                    senhaLoginError.style.display = 'block';
                } else if (!validatePassword(senhaLoginInput.value)) {
                    valid = false;
                    senhaLoginError.textContent = 'A senha deve ter no mínimo 8 caracteres, incluindo uma letra maiúscula, uma letra minúscula, um número e um caractere especial.';
                    senhaLoginError.style.display = 'block';
                }
            }

            // Se não for válido, evita o envio do formulário
            if (!valid) {
                event.preventDefault();
            }
        });
    }

    // Eventos para limpar mensagens de erro ao digitar no cadastro
    if (nomeInput) {
        nomeInput.addEventListener('input', function () {
            if (nomeError && nomeError.style.display === 'block') {
                nomeError.style.display = 'none';
            }
        });
    }

    if (emailCadastroInput) {
        emailCadastroInput.addEventListener('input', function () {
            if (emailCadastroError && emailCadastroError.style.display === 'block') {
                emailCadastroError.style.display = 'none';
            }
        });
    }

    if (senhaCadastroInput) {
        senhaCadastroInput.addEventListener('input', function () {
            if (senhaCadastroError && senhaCadastroError.style.display === 'block') {
                senhaCadastroError.style.display = 'none';
            }
        });
    }


    // Eventos para limpar mensagens de erro ao digitar no login
    if (emailLoginInput) {
        emailLoginInput.addEventListener('input', function () {
            if (emailLoginError && emailLoginError.style.display === 'block') {
                emailLoginError.style.display = 'none';
            }
        });
    }

    if (senhaLoginInput) {
        senhaLoginInput.addEventListener('input', function () {
            if (senhaLoginError && senhaLoginError.style.display === 'block') {
                senhaLoginError.style.display = 'none';
            }
        });
    }
});