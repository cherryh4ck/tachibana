const selector_categorias = document.getElementById("categoria-input-index");
const selector_orden = document.getElementById("categoria-input-categoria");
const tag_categoria = document.getElementById("input-tag-rojo-index")
const input_busqueda = document.getElementById("input-busqueda");

let categoria = "any";

selector_categorias.addEventListener("change", function() {
    const opcionSeleccionada = this.options[this.selectedIndex];
    const valorSeleccionado = opcionSeleccionada.value;

    categoria = valorSeleccionado;
    tag_categoria.textContent = "/" + valorSeleccionado + "/"; 
    if (input_busqueda.value.length > 0){
        window.location.replace("?categoria=" + categoria + "&q=" + input_busqueda.value + "&orden=" + selector_orden.value);
    }
    else{
        window.location.replace("?categoria=" + categoria + "&orden=" + selector_orden.value);
    }
});
