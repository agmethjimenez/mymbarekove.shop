function redirectToLogin() {
  window.location.href = "login/loginform.html";
}

function redirectToRegister() {
  window.location.href = "login/registerform.html";
}

function login(event) {
    event.preventDefault(); 

    var username = document.getElementById("loginUsername").value;
    var password = document.getElementById("loginPassword").value;

    if (username.trim() === "" || password.trim() === "") {
        alert("Por favor, ingresa el nombre de usuario y la contraseña.");
        return;
    }
    if(username.trim() === "mymbaadmin" && password.trim() === "mymba1122") {
      window.location.href = "../index.html";
      }
      else  {alert("credenciales de inicio invalidas, intente de nuevo")}
    }


function register(event) {
    event.preventDefault(); 

    var username = document.getElementById("registerUsername").value;
    var password = document.getElementById("registerPassword").value;
    var name = document.getElementById("registerName").value;
    var number = document.getElementById("registerCel").value;
    var residence = document.getElementById("registerResidence").value;
    var rol = document.getElementById("registerRol").value;
    var fecha = document.getElementById("registerFecha").value;

    if (username.trim() === "" || password.trim() === "" || name.trim() === "" || number.trim() === "" || residence.trim() === "" || rol.trim() === "" || fecha.trim() === "") {
        alert("Por favor, no deje campos vacios");
        return;
    }
    window.location.href = "../index.html";
}

