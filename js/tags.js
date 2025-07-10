// por hacer: mensaje de error
// evitar que se repitan los tags

let caracteres_permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_ ";
let tag_permitido = true;

export let tags_introducidos = 0;
import {req1, req2, req3} from "./archivos.js";

let insert_tags = document.getElementById("insert-tags");
let tags_input = document.getElementById("tags-input");
let titulo_input = document.getElementById("titulo-input")
let enviar = document.getElementById("btn-enviar");
// let mensaje_error = document.getElementById("error-msj");

let formulario = document.getElementById("formulario-subir");

function introducirTag(tag){
    tag_permitido = true;
    if ((tag.length <= 20) && (tags_introducidos < 4) && (tag != "") && (/\S/.test(tag) && (tag != null) && (tag.length >= 4))){
        for (let i = 0; i < tag.length; i++) {
            if (caracteres_permitidos.includes(tag[i]) == false) {
                tag_permitido = false;
                break;
            }
        }
        if (tag_permitido){
            tags_introducidos++;
            let span = document.createElement("span");
            span.className = "input-tag";
            span.id = "input-tag";
            span.innerText = tag;
            insert_tags.appendChild(span);
            if (req1 && req2 && req3 && titulo_input.value.trim() != ""){
                enviar.disabled = false;
            }
            else{
                enviar.disabled = true;
            }
        }
        else{
            console.log("Tag no permitido");
        }
    }
    else{
        console.log("Tag demasiado largo, vacío o ya hay 4 tags introducidos");
    }
}

tags_input.addEventListener('keyup', function (e) {
    if (e.key === 'Enter') {
        introducirTag(tags_input.value.toLowerCase());
        tags_input.value = "";
    }
});

formulario.addEventListener("submit", function (e) {
    if (!tags_introducidos > 0){
        e.preventDefault();
    }
});
