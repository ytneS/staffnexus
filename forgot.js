const email = document.getElementById('email');
const emailError = document.querySelector("#email-error");
const form = document.querySelector('form');

function showError(input, message) {
    const formControl = input.parentElement;
    formControl.className = 'form-control error';
    const small = formControl.querySelector('small');
    small.innerText = message;
}

function showSuccess(input) {
    const formControl = input.parentElement;
    formControl.className = 'form-control success';
}

function checkEmail(email) {
    const emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
    return emailRegex.test(email);
}
    
function checkRequired(inputArr) {
    let isRequired = false;

    inputArr.forEach(function (input) {
        if (input.value.trim() === '') {
            showError(input, `*Field is required`);
            isRequired = true;
        } else {
            showSuccess(input);
        }
    });

    if (!checkEmail(email.value)) {
        showError(email, "*Email nie je platný.");
        isRequired = true;
    }

    return !isRequired;
}

email.addEventListener("input", function () {
    emailError.textContent = ""; 
});

form.addEventListener('submit', function (e) {
    if (!checkRequired([email])) {
        e.preventDefault();
    }
});
