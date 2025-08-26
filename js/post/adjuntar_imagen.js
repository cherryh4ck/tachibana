const boton = document.getElementById("post-comentarios-adjuntar-imagen-falso");
const input_archivo = document.getElementById("post-comentarios-adjuntar-imagen");
const imagen_frame = document.getElementById("post-comentarios-imagen");
const imagen_nombre_data = document.getElementById("imagen-nombre-data");
const imagen_data = document.getElementById("imagen-tamano-res-data");
const data_div = document.getElementsByClassName("post-comentarios-comentar-botones-imagen-data")[0];

input_archivo.addEventListener("change", function(e){
    const imagen = e.target.files[0];
    imagen_nombre_data.textContent = imagen.name;

    imagen_frame.src = URL.createObjectURL(imagen);

    let width, height;
    imagen_frame.onload = () => {
        width = imagen_frame.naturalWidth;
        height = imagen_frame.naturalHeight;

        imagen_data.textContent = `${width}x${height} ${(imagen.size / 1024).toFixed(2)} KB`;
        data_div.style.display = "block";
    };
});

boton.addEventListener("click", function(e) {
    input_archivo.click();
});