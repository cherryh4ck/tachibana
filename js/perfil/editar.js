const avatar_input = document.getElementById("avatar-file");
const avatar_preview = document.getElementById("avatar-img");

const imagen_estirada_aviso = document.getElementById("mensaje-aviso");

avatar_input.addEventListener("change", (event) => {
    const imagen = event.target.files[0];
    avatar_preview.src = URL.createObjectURL(imagen);
    avatar_preview.onload = () => {
        const width = avatar_preview.naturalWidth;
        const height = avatar_preview.naturalHeight;

        if (width !== height) {
            imagen_estirada_aviso.style.display = "block";
        } else {
            imagen_estirada_aviso.style.display = "none";
        }
    };
});