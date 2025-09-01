const form_login = document.getElementById("formulario-login");
const user_input = document.getElementById("user-input");
const password_input = document.getElementById("password-input");

const mensaje_error = document.getElementById("formulario-mensaje");

let error = false;

mensaje_error.style.transition = "opacity 0.3s ease";
mensaje_error.style.opacity = 0;

form_login.addEventListener("submit", function (e){
    user_input.value = user_input.value.trim();
    password_input.value = password_input.value.trim();

    if(user_input.value.length < 1 || password_input.value.length < 1){
        e.preventDefault();
        mensaje_error.innerHTML = "<span>Error:</span> Los campos no pueden estar vacios";
        error = true;
    }
    else if (user_input.value.length < 4 || user_input.value.length > 19){
        e.preventDefault();
        mensaje_error.innerHTML = "<span>Error:</span> El usuario es muy corto o es muy largo";
        error = true;
    }

    if (error == true){
        mensaje_error.style.opacity = 0;
        mensaje_error.style.display = "block";
        requestAnimationFrame(() => {
            mensaje_error.style.opacity = 1; 
        });
    }
});

mensaje_error.addEventListener('transitionend', e=>{
    if (e.propertyName === 'opacity' && getComputedStyle(mensaje_error).opacity === "0") {
      mensaje_error.style.display = "none";
    }
});
