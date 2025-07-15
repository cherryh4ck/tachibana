formulario = document.getElementById("formulario");
contraseña = document.getElementById("contraseña");
repetirContraseña = document.getElementById("repetirContraseña");


formulario.addEventListener("submit", function(event) {
    if (contraseña.value !== repetirContraseña.value){
        event.preventDefault();
        alert("Las contraseñas no coinciden");
    }
});