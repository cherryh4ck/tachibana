let archivo = document.getElementById("archivo-file");
let image = document.getElementById("image-preview");
let imagen_texto = document.getElementById("imagen-texto");
let imagen_tamano = document.getElementById("imagen-tamano");
let imagen_res = document.getElementById("imagen-res");

let textbox = document.getElementById("titulo-input");
let textarea = document.getElementById("descripcion-input");
let enviar = document.getElementById("btn-enviar");

// 25228792 (25MB)
let maxSize = 6228792; // 5 MB

export let req1 = false, req2 = false, req3 = false;
import {tags_introducidos} from "./tags.js";

archivo.addEventListener("change", (event) => {
    const imagen = event.target.files[0];
    if (imagen.type == "image/gif"){    
        maxSize = 26228792;
    }
    console.log(imagen.type);
    imagen_texto.textContent = imagen.name;
    imagen_tamano.textContent = `${(imagen.size / 1024).toFixed(2)} KB`;
    let width, height;

    image.src = URL.createObjectURL(imagen);
    image.onload = () => {
        width = image.naturalWidth;
        height = image.naturalHeight;
        imagen_res.textContent = `${width}x${height}`;
        if (width >= 400 && height >= 300){
            req1 = true;
            console.log("1 si");
        }
        else{
            req1 = false;
        }

        if (req1 && req2 && req3 && tags_introducidos > 0 && textbox.value.trim() != "" && textarea.value.trim() != "") {
            enviar.disabled = false;
        } else {
            enviar.disabled = true;
        }
    };

    if (imagen.size > 20000){
        req2 = true;
        console.log("2 si");
    }
    else{
        req2 = false;
    }
    if (imagen.size < maxSize) {
        req3 = true;
        console.log("3 si");
    }
    else{
        req3 = false;
    }
});

textbox.addEventListener("input", (e) => {
    if (req1 && req2 && req3 && tags_introducidos > 0 && e.target.value.trim() != "" && textarea.value.trim() != "") {
        enviar.disabled = false;
    }
    else{
        enviar.disabled = true;
    }
});

textarea.addEventListener("input", (e) => {
    if (req1 && req2 && req3 && tags_introducidos > 0 && e.target.value.trim() != "" && textbox.value.trim() != "") {
        enviar.disabled = false;
    }
    else{
        enviar.disabled = true;
    }
});
