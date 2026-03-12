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
    event.preventDefault();
    errorDiv.style.display = 'none';
    let valid = true;
    [...form.elements].forEach(el => {
        if (el.tagName.toLowerCase() === 'input') {
            if (!validateField(el)) valid = false;
        }
    });

    if (!valid) {
        errorDiv.textContent = 'Merci de corriger les erreurs indiquées.';
        errorDiv.style.display = 'block';
        form.classList.add('shake');
        setTimeout(() => form.classList.remove('shake'), 500);
        return;
    }

    // Submit form data asynchronously
    const formData = new FormData(form);
    fetch('insert.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            errorDiv.style.backgroundColor = '#bbffbb';
            errorDiv.style.color = '#228B22';
            errorDiv.textContent = data.message;
            errorDiv.style.display = 'block';
            form.reset();
            [...form.elements].forEach(el => {
                if (el.tagName.toLowerCase() === 'input' && el.nextElementSibling) {
                    el.nextElementSibling.textContent = '';
                }
            });
        } else {
            errorDiv.style.backgroundColor = '#ffbaba';
            errorDiv.style.color = '#d8000c';
            errorDiv.textContent = data.message;
            errorDiv.style.display = 'block';
        }
    })
    .catch(error => {
        errorDiv.style.backgroundColor = '#ffbaba';
        errorDiv.style.color = '#d8000c';
        errorDiv.textContent = 'Erreur: ' + error.message;
        errorDiv.style.display = 'block';
    });
});
