const mensaje_error = document.getElementById("mensaje-error");
const mensaje_aviso = document.getElementById("mensaje-aviso");

mensaje_error.style.transition = "opacity 0.3s ease";
mensaje_error.style.opacity = 0;

mensaje_aviso.style.transition = "opacity 0.3s ease";
mensaje_aviso.style.opacity = 0;

const formulario = document.getElementById("formulario-seguridad-perfil");
const actual_input = document.getElementById("actual-input");
const nueva_input = document.getElementById("nueva-input");
const repetir_input = document.getElementById("repetir-input");

function mostrarErrorSeguridad(texto){
    mensaje_error.innerHTML = "<span>Error al cambiar la contraseña:</span> " + texto;
    mensaje_error.style.opacity = 0;
    mensaje_error.style.display = "block";
    requestAnimationFrame(() => {
        mensaje_error.style.opacity = 1;
    });
}

function mostrarAvisoSeguridad(){
    mensaje_aviso.style.opacity = 0;
    mensaje_aviso.style.display = "block";
    requestAnimationFrame(() => {
        mensaje_aviso.style.opacity = 1;
    });
}

mensaje_error.addEventListener('transitionend', e=>{
    if (e.propertyName === 'opacity' && getComputedStyle(mensaje_error).opacity === "0") {
      mensaje_error.style.display = "none";
    }
});

mensaje_aviso.addEventListener('transitionend', e=>{
    if (e.propertyName === 'opacity' && getComputedStyle(mensaje_aviso).opacity === "0") {
      mensaje_aviso.style.display = "none";
    }
});

formulario.addEventListener("submit", function(e) {
    if ((actual_input.value.length < 1) || (nueva_input.value.length < 1) || (repetir_input.value.length < 1)){
        e.preventDefault();
        mostrarErrorSeguridad("Los campos están vacíos");
    }
    else if (nueva_input.value !== repetir_input.value){
        e.preventDefault();
        mostrarErrorSeguridad("Las contraseñas nuevas no coinciden");
    }
    else if ((nueva_input.value.length < 6) || (nueva_input.value.length > 72)){
        e.preventDefault();
        mostrarErrorSeguridad("La contraseña nueva debe tener entre 6 y 72 caracteres");
    }
});
