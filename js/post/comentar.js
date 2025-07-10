let textarea = document.getElementById("post-comentarios-textarea");
let enviar = document.getElementById("post-comentarios-enviar");

textarea.addEventListener("input", (e) => {
    if (textarea.value.trim() !== "") {
        enviar.disabled = false;
    } else {
        enviar.disabled = true;
    }
});
