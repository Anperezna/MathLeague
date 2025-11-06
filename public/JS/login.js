document.addEventListener('DOMContentLoaded', function() {
    const loginBtn = document.getElementById('loginBtn');
    const registerBtn = document.getElementById('registerBtn');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    // Función para cambiar al formulario de login
    function showLogin() {
        loginBtn.classList.add('active');
        registerBtn.classList.remove('active');
        loginForm.classList.add('active');
        registerForm.classList.remove('active');
    }

    // Función para cambiar al formulario de registro
    function showRegister() {
        registerBtn.classList.add('active');
        loginBtn.classList.remove('active');
        registerForm.classList.add('active');
        loginForm.classList.remove('active');
    }

    // Event listeners para los botones
    loginBtn.addEventListener('click', showLogin);
    registerBtn.addEventListener('click', showRegister);

    // Opcional: Detectar si hay errores de validación y mostrar el formulario correspondiente
    const registerErrors = document.querySelectorAll('#registerForm .error, #registerForm .alert-danger');
    const loginErrors = document.querySelectorAll('#loginForm .error, #loginForm .alert-danger');

    if (registerErrors.length > 0) {
        showRegister();
    } else if (loginErrors.length > 0) {
        showLogin();
    }
});