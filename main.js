const registerButton = document.getElementById("register");
const loginButton = document.getElementById("login");
const container = document.getElementById("container");

registerButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

loginButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

const form = document.querySelector('form')
const username = document.getElementById('username')
const usernameError = document.querySelector("#username-error")
const email = document.getElementById('email')
const emailError = document.querySelector("#email-error")
const password = document.getElementById('password')
const passwordError = document.querySelector("#password-error")

function showError(input, message) {
    const formControl = input.parentElement
    formControl.className = 'form-control error'
    const small = formControl.querySelector('small')
    small.innerText = message
}

function showSuccess(input) {
    const formControl = input.parentElement
    formControl.className = 'form-control success'
    const small = formControl.querySelector('small')
    small.innerText = ''
}

function checkEmail(email) {
    const emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
    return emailRegex.test(email);
}

email.addEventListener("input", function(){
    if (!checkEmail(email.value)) {
        showError(email, "*Email nie je platný");
    } else {
        showError(email, ""); 
    }

    if (email.value.trim() !== '') {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'check_email.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.emailExists) {
                    showError(email, "*Tento e-mail sa už používa.");
                }
            }
        };
        xhr.send('email=' + email.value);
    }
})

username.addEventListener("input", function(){
    if (username.value.length < 3) {
        usernameError.textContent = "*Meno musí mať aspoň 3 znaky."
    } else if(username.value.length > 20){
        usernameError.textContent = "*Meno musí byť kratšie ako 20 znakov.";
    } else {
        usernameError.textContent = "";
    }
})

password.addEventListener("input", function(){
    if (password.value.length < 5) {
        passwordError.textContent = "*Heslo musí mať aspoň 5 znakov."
    } else if(password.value.length > 20){
        passwordError.textContent = "*Heslo musí byť kratšie ako 20 znakov."
    } else {
        passwordError.textContent = "";
    }
})

function getFieldName(input) {
    return input.id.charAt(0).toUpperCase() + input.id.slice(1)
}

function checkRequired(inputArr) {
    let isRequired = false;

    inputArr.forEach(function (input) {
        if (input.value.trim() === '') {
            showError(input, `*${getFieldName(input)} is required`);
            isRequired = true;
        } else {
            showSuccess(input);
        }
    });

    if (username.value.length < 3) {
        showError(username, "*Meno musí mať aspoň 3 znaky.");
        isRequired = true;
    }

    
    if (username.value.length > 20) {
        showError(username, "*Meno musí byť kratšie ako 20 znakov.");
        isRequired = true;
    }


    if (!checkEmail(email.value)) {
        showError(email, "*Email nie je platný.");
        isRequired = true;
    }

    if (password.value.length < 5) {
        showError(password, "*Heslo musí mať aspoň 5 znakov.");
        isRequired = true;
    }

    if (isRequired) {
        return false;
    }

    return true;
}

form.addEventListener('submit', function (e) {
    if (!checkRequired([username, email, password])) {
        e.preventDefault();
    }
});

const lgForm = document.querySelector('.form-lg');
const lgEmail = document.querySelector('.email-2');
const lgEmailError = document.querySelector(".email-error-2");
const lgPassword = document.querySelector('.password-2');
const lgPasswordError = document.querySelector(".password-error-2");

function showError2(input, message) {
    const formControl2 = input.parentElement;
    formControl2.className = 'form-control2 error';
    const small2 = formControl2.querySelector('small');
    small2.innerText = message;
}

function showSuccess2(input) {
    const formControl2 = input.parentElement;
    formControl2.className = 'form-control2 success';
    const small2 = formControl2.querySelector('small');
    small2.innerText = '';
}

function checkEmail2(email) {
    if (email.trim() === '') {
        showError2(lgEmail, `*Prosím, zadajte informácie do tohto poľa.`);
        return false;
    } else {
        const emailRegex2 = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
        const isValidEmail = emailRegex2.test(email);
        
        if (!isValidEmail) {
            showError2(lgEmail, "*Email nie je platný.");
        } else {
            lgEmailError.textContent = "";
        }

        return isValidEmail;
    }
}

lgEmail.addEventListener("input", function () {
    lgEmailError.textContent = ""; 
    checkEmail2(lgEmail.value);
});

lgPassword.addEventListener("input", function () {
    lgPasswordError.textContent = ""; 
});

function checkRequiredLg(inputArr2) {
    let isRequiredLg = false;
    inputArr2.forEach(function (input) {
        if (input.value.trim() === '') {
            showError2(input, `*${getFieldNameLg(input)}Prosím, zadajte informácie do tohto poľa.`);
            isRequiredLg = true;
        } else {
            showSuccess2(input);
        }
    });

    return isRequiredLg;
}

function getFieldNameLg(input) {
    return input.id.charAt(0).toUpperCase() + input.id.slice(1);
}

lgForm.addEventListener('submit', function (e) {
    const isRequiredError = checkRequiredLg([lgEmail, lgPassword]);
    const isEmailError = !checkEmail2(lgEmail.value);

    if (isRequiredError || isEmailError) {
        e.preventDefault();
    }
});




