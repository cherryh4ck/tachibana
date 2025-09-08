const formulario = document.getElementById("formulario-buscar-usuario");
const query = document.getElementById("nombreUsuario");

formulario.addEventListener("submit", function(event) {
    if (query.value.trim() === "" || query.value.length <= 2) {
        event.preventDefault();
    }
});
