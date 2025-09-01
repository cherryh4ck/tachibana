const formulario = document.getElementById("formulario");
const username = document.getElementById("usernameF");
const contraseña = document.getElementById("contraseña");
const repetirContraseña = document.getElementById("repetirContraseña");
const divMensaje = document.getElementById("register-mensaje");

const mensaje = document.createElement("p");
mensaje.id = "formulario-mensaje";
mensaje.innerHTML = "<span>Error:</span> El usuario ya existe.";

mensaje.style.transition = "opacity 0.3s ease";
mensaje.style.opacity = 0;

let error = false;

formulario.addEventListener("submit", function(event) {
    divMensaje.innerHTML = "";

    if (contraseña.value !== repetirContraseña.value){
        event.preventDefault();
        mensaje.innerHTML = "<span>Error:</span> Las contraseñas no coinciden";
        error = true;
    }
    else{
        if (contraseña.value == usernameF.value){
            event.preventDefault();
            mensaje.innerHTML = "<span>Error:</span> La contraseña no puede ser igual al usuario";
            error = true;
        }
        else{
            if ((username.value.length < 4) || (username.value.length > 19)){
                event.preventDefault();
                mensaje.innerHTML = "<span>Error:</span> El usuario es muy corto o es muy largo";
                error = true;
            }
            else{
                if (contraseña.value.length < 6){
                    event.preventDefault();
                    mensaje.innerHTML = "<span>Error:</span> La contraseña debe tener al menos 6 caracteres";
                    error = true;
                }
                else{
                    mensaje.innerHTML = "Creando cuenta...";
                }
            }
        }
    }

    divMensaje.append(mensaje);
    if (error == true){
        mensaje.style.opacity = 0;
        mensaje.style.display = "block";
        requestAnimationFrame(() => {
            mensaje.style.opacity = 1; 
        });
    }
});

mensaje.addEventListener('transitionend', e=>{
    if (e.propertyName === 'opacity' && getComputedStyle(mensaje).opacity === "0") {
      mensaje.style.display = "none";
    }
});
