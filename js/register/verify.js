const formulario = document.getElementById("formulario");
const username = document.getElementById("usernameF");
const contraseña = document.getElementById("contraseña");
const repetirContraseña = document.getElementById("repetirContraseña");
const divMensaje = document.getElementById("register-mensaje");

const mensaje = document.createElement("p");
mensaje.id = "formulario-mensaje";
mensaje.innerHTML = "<span>Error:</span> El usuario ya existe.";

formulario.addEventListener("submit", function(event) {
    divMensaje.innerHTML = "";

    if (contraseña.value !== repetirContraseña.value){
        event.preventDefault();
        mensaje.innerHTML = "<span>Error:</span> Las contraseñas no coinciden";
    }
    else{
        if (contraseña.value == usernameF.value){
            event.preventDefault();
            mensaje.innerHTML = "<span>Error:</span> Las contraseñas no coinciden";
        }
        else{
            if (contraseña.value.length < 6){
                event.preventDefault();
                mensaje.innerHTML = "<span>Error:</span> La contraseña debe tener al menos 6 caracteres";
            }
            else{
                mensaje.innerHTML = "Creando cuenta...";
            }
        }
    }

    divMensaje.append(mensaje);
});
