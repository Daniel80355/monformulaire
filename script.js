// form validation and simple animation effects

const form = document.querySelector('form');
const errorDiv = document.getElementById('error-message');


// helper to show or clear inline messages
function validateField(field) {
    const span = field.nextElementSibling;
    let msg = '';
    const value = field.value.trim();
    if (!value) {
        msg = 'Champ requis';
    } else if (field.type === 'email') {
        if (!/^\S+@\S+\.\S+$/.test(value)) {
            msg = "Format d'email invalide";
        }
    }
    span.textContent = msg;
    return msg === '';
}

// attach input listeners for live feedback
[...form.elements].forEach(el => {
    if (el.tagName.toLowerCase() === 'input') {
        el.addEventListener('input', () => validateField(el));
    }
});

// submit handler still performs full check
form.addEventListener('submit', function(event) {
    errorDiv.style.display = 'none';
    let valid = true;
    [...form.elements].forEach(el => {
        if (el.tagName.toLowerCase() === 'input') {
            if (!validateField(el)) valid = false;
        }
    });

    if (!valid) {
        event.preventDefault();
        errorDiv.textContent = 'Merci de corriger les erreurs indiquées.';
        errorDiv.style.display = 'block';
        form.classList.add('shake');
        setTimeout(() => form.classList.remove('shake'), 500);
    }
});
