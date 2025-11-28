document.addEventListener('DOMContentLoaded', function() {
    // ---------- VALIDASI FORM ----------
    const form = document.getElementById('loginForm');
    if (form) {
        const errorContainer = document.createElement('div');
        errorContainer.className = 'error-messages';
        form.prepend(errorContainer);

        form.addEventListener('submit', function(e) {
            errorContainer.innerHTML = '';
            const email = form.email.value.trim();
            const password = form.password.value.trim();
            let errors = [];

            if (!email.includes('@') || !email.includes('.')) {
                errors.push("Email tidak valid!");
            }

            if (password.length < 5) {
                errors.push("Password minimal 5 karakter!");
            }

            if (errors.length > 0) {
                e.preventDefault();
                errors.forEach(function(err) {
                    const p = document.createElement('p');
                    p.textContent = err;
                    p.style.color = 'red';
                    p.style.margin = '5px 0';
                    errorContainer.appendChild(p);
                });
            }
        });
    }

    // ----- HIDE/SHOW PASSWORD -----
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    if (passwordInput && togglePassword) {
        togglePassword.addEventListener('click', function () {
            const icon = this.querySelector('i');
            if (icon) {
                if (icon.classList.contains('fa-eye-slash')) {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            }
        });
    }
});
