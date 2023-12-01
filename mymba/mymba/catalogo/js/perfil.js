document.addEventListener("DOMContentLoaded",()=>{


let botoninfo = document.getElementById("verinfo");
    let botonactualizar = document.getElementById("actualizar");
    let botonclave = document.getElementById("cambiarclave");

    botoninfo.addEventListener("click",()=>{
        document.getElementById("info").style.display = "flex";
        document.getElementById("actualizardatos").style.display="none";
        document.getElementById("cambiarclaved").style.display="none";
    });
    botonactualizar.addEventListener("click",()=>{
        document.getElementById("info").style.display = "none";
        document.getElementById("actualizardatos").style.display="flex";
        document.getElementById("cambiarclaved").style.display="none";
    });
 
});