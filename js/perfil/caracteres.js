const descripcion_input = document.getElementsByClassName("descripcion-input-perfil")[0];
const caracteres_texto = document.getElementById("perfil-banner-parte1-modificado-input-caracteres");

caracteres_texto.style.transition = "opacity 0.3s ease";
caracteres_texto.style.opacity = 0;

let max_caracteres = 400;
let caracteres_actuales = 400;
let texto = descripcion_input.value;

descripcion_input.addEventListener("focus", function(e){
    texto = descripcion_input.value;
    caracteres_actuales = max_caracteres - texto.length;
    caracteres_texto.innerHTML = `${caracteres_actuales} caracteres restantes`;
    caracteres_texto.style.opacity = 0;
    caracteres_texto.style.display = "block";
    requestAnimationFrame(() => {
        caracteres_texto.style.opacity = 1; 
    });
});

descripcion_input.addEventListener("input", function(e){
    texto = descripcion_input.value;
    caracteres_actuales = max_caracteres - texto.length;
    if (caracteres_actuales < 0) {
        descripcion_input.value = texto.substring(0, max_caracteres);
        caracteres_actuales = 0;
    }
    caracteres_texto.innerHTML = `${caracteres_actuales} caracteres restantes`;
});

descripcion_input.addEventListener("blur", function(e){
    caracteres_texto.style.opacity = "0";
});

caracteres_texto.addEventListener('transitionend', e=>{
    if (e.propertyName === 'opacity' && getComputedStyle(caracteres_texto).opacity === "0") {
      caracteres_texto.style.display = "none";
    }
});
