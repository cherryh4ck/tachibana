const formulario = document.getElementById("formulario-buscar-usuario");
const query = document.getElementById("nombreUsuario");

formulario.addEventListener("submit", function(event) {
    query.value = query.value.trim();
    if (query.value.length <= 2) {
        event.preventDefault();
    }
});
