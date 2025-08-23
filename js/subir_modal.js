const ventana_subir = document.getElementsByClassName("contenido-subir")[0];
const ventana_boton = document.getElementById("subir-boton-modal");

ventana_boton.addEventListener("click", function(e) {
    e.preventDefault();
    ventana_subir.showModal();
    ventana_subir.style.display = "flex";
});

ventana_subir.addEventListener("click", (event) => {
    // no tenía ni idea de esto kek
    const dialogRect = ventana_subir.getBoundingClientRect();
    const clickInside =
        event.clientX >= dialogRect.left &&
        event.clientX <= dialogRect.right &&
        event.clientY >= dialogRect.top &&
        event.clientY <= dialogRect.bottom;

    if (!clickInside) {
        ventana_subir.close();
        ventana_subir.style.display = "none";
    }
});