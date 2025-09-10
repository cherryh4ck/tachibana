// humildemente hecho con chatgpt >:3

const respuestas = document.querySelectorAll(".respuesta");
const preview = document.getElementById("preview");

function decodeEntities(encodedString) {
    const textarea = document.createElement("textarea");
    textarea.innerHTML = encodedString;
    return textarea.value;
}

respuestas.forEach(r => {
    r.addEventListener("mouseenter", e => {
        const content = r.dataset.content;
        if (content) {
            const decoded = decodeEntities(content);
            preview.innerHTML = decoded;
            preview.style.display = "block";
        }
    });

    r.addEventListener("mousemove", e => {
        preview.style.left = (e.pageX + 15) + "px";
        preview.style.top = (e.pageY + 15) + "px";
    });

    r.addEventListener("mouseleave", () => {
        preview.style.display = "none";
    });
});