const formulario = document.getElementById("formulario-busqueda");
const query = document.getElementById("input-busqueda");

formulario.addEventListener("submit", function(e) {
    query.value = query.value.trim();
    if (query.value.length <= 2 && !(query.value === "")) {
        e.preventDefault();
    }
});