function togglePassword(inputId, toggleId) {
    const passwordInput = document.getElementById(inputId);
    const toggleText = document.getElementById(toggleId);

    if (passwordInput && toggleText) {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleText.textContent = 'Hide';
        } else {
            passwordInput.type = 'password';
            toggleText.textContent = 'Show';
        }
    }
}
