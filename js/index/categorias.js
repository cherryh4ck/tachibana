const selector_categorias = document.getElementById("categoria-input-index");
const tag_categoria = document.getElementById("input-tag-rojo-index")
const categoria = "any";

selector_categorias.addEventListener("change", function() {
    const opcionSeleccionada = this.options[this.selectedIndex];
    const valorSeleccionado = opcionSeleccionada.value;

    categoria = valorSeleccionado;
    tag_categoria.textContent = "/" + valorSeleccionado + "/"; 
});
