<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mymba Rekove Shop</title>
    <link rel="stylesheet" href="Estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="login/login.js"></script>
    <style>
        
body{

background: linear-gradient(135deg, #caa678, #f5f5f5 );

padding: 0;
 margin: 0;
}
:root{
--background: linear-gradient(0deg,#fdc322 100%,#ffc444 100%);
--color-primary:#161516;
--color-secundary:#201f20;
--bottom-padding: 20px 40px;

}
header {
background-color: white;
justify-content: center;
height: 90px;
width: 100%;
top: 0;
position: fixed;
}

#navegar {
list-style-type: none; /* Quita los puntos de la lista */
display: flex; /* Hace que los elementos se distribuyan en una línea */
justify-content: center; /* Centra horizontalmente los elementos */
align-items: center; /* Centra verticalmente los elementos */
margin: 0; /* Asegura que no haya espacios de margen en el ul */
padding: 0; /* Asegura que no haya espacios de relleno en el ul */
}

li {
margin: 0 10px; /* Agrega un margen horizontal entre los elementos */
}

button a {
text-decoration: none; /* Quita el subrayado del enlace dentro del botón */
color: inherit; /* Hereda el color del texto del botón */
}

button a:hover {
text-decoration: none; /* Subraya el enlace dentro del botón */
}

.center-item {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.right-item {
text-align: right;
display: flex;
align-items: center;
}
ul li h1{
font-size: 15px
}
li.right-item a {
text-decoration: none;
color: #333;
border-bottom: none; /* Quita la raya inferior en los enlaces */
font-family: 'Oxygen', sans-serif;
}
ul li .logo{
width: 110px;
height: 110px;
}

.acceso a{
color: white;
text-decoration: none;
border-bottom: none;
}
ul li button {
background-color: black;
color: white;
text-decoration: none;
border: none;
padding: 10px 20px;
border-radius: 5px;
font-size: 14px;
cursor: pointer;
transform: translateX(55px);
transition: background-color 0.3s; /* Agrega una transición para cambiar de color suavemente */
}
ul li button:hover{
background: #6b6b6b;
}

input[type="search"] {
font-family: 'Material Icons Outlined';
font-size: 16px;
padding: 8px;
border: none;
background-color: #f2f2f2;
border-radius: 5px;
}
.material-symbols-outlined {
font-family: 'Material Symbols Outlined';
font-size: 20px;
color: #fff;
cursor: pointer;
margin-left: -28px;
margin-top: 10px;
}
.search{
width: 420px;
height: 40px;
border-radius:16px;
border: none;
border-color: #efefef;
background-color: #efefef;
margin-bottom: 10px;
text-align: center;

}
.material-symbols-outlined {
font-family: 'Material Symbols Outlined';
font-size: 20px;
margin-right: 10px; /* Ajusta el espaciado entre el ícono y el campo de búsqueda */
margin-top: 2px; /* Mueve la lupa hacia abajo */
color: #333; /* Ajusta el color del ícono */
cursor: pointer; /* Cambia el cursor al pasar sobre el ícono */

translate: -10px 7px;
}


h1 {
font-family: 'Oxygen', sans-serif;
text-align: right;
margin: 30px 0px;
}

img {
width: 420px;
height: 440px;
object-fit: cover;
margin-left: 100px;
}


.carrito {
filter: 100%;
width: 35px;
height: 35px;
}
body{
font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
}

.container{
width: 90%;
margin: 0 auto;
overflow: hidden;
padding: 80px 0;
max-width: 1500px;

}

.subtitle{
color: var(--color-primary);
font-size: 2.5rem;
margin-bottom: 0px;
text-align: center;
}

.subtitle2{

color: #000000;
font-size: 2.5rem;
margin-bottom: 0px;
text-align: center;
}

.subtitle3{

color: #0a0a0a;
font-size: 2.5rem;
margin-bottom: 0px;
text-align: center;
}




.hero{
height: 100vh;
background-image:url();
background-repeat: no-repeat;
background-size: cover;
background-attachment: fixed;
background-position: center;
position: relative;
}

.hero .container{
padding: 0;

}

.nav{
display: flex;
justify-content: flex-end;
height: 70px;
align-items: center;
font-weight: 700;

}

.nav--footer{
font-weight: 300;
justify-content: flex-start;

}

.nav_items{
color: #000000;
text-decoration: none;
margin-right: 20px;
padding: 10px 15px;
font-weight: inherit;
}

.nav_items--cta{
border: 1px solid #080808;
}

nav_items--cta{
border: 1px solid #e37fec;
}
nav_items--cta{
    border: 1px solid #030303;
}       


.nav_items--footer{

padding: 10px;

}

.hero_container{
display: flex;
height: calc(100vh - 70px);
align-items: center;
color:#000000;

}

.hero_texts{
width: 80%;
margin-bottom: 50px;
}

.hero_title{
font-size: 3.2rem;
color: #000000(117, 86, 0);
}

.hero_las{
font-size: 3.2rem;
color: #0a0a0a ;
}

.hero_subtitle{
font-size: 2rem;
font-weight: 300;
margin: 15px;
}

.hero_cta{
display: inline-block;
background-color: #95F5D5;
padding: var(--bottom-padding);
color: #080808;
text-decoration: none;
border-radius: 40px;

}
.hero_wave{
position: absolute;
bottom: 0;
left: 0;
width: 100%;
height: 200px;
}




.Kius{
padding: 6%;
text-align: center;

}

.Kius_copy{
font-size: 1.5rem;
margin: 0 auto;
width: 100%;
line-height: 150%;
color: #080808;
}

.Kius_cta{
display: inline-block;
margin-top: 12px;
background: #431e0be3;
color: ghostwhite;
text-decoration: none;
padding: 20px 40px;
border-radius: 40px;
}


.about{
padding: 0%;
min-height: 100px;
display: grid;
grid-template-columns: 1fr 1fr;
justify-items: center;
align-items: center;

}

.about_img{
text-align: center;

}

.about_picture{
max-width: 100%;
}

.about_paragraph{
margin-bottom: 5px;
line-height: 1.5;
font-weight: 300;
font-size: 1.4rem;
text-align: left;
color: #000000 ;
}

.about2{
min-height: 100px;
display: grid;
grid-template-columns: 1fr 1fr;
row-gap: 0;
justify-items: center;
align-items: center;
}

.about2_img{
text-align: right;
}

.about2_picture{
max-width: 100%;
}

.about3{
min-height: 100px;
display: grid;
grid-template-columns: 1fr 1fr;
row-gap: 0;
justify-items: center;
align-items: center;
}

.about3_img{
text-align: left;
}

.about3_picture{
max-width: 100%;
}

*{
box-sizing: border-box;

}


.row{

display: flex;
padding: 5px;
flex-wrap: wrap;
}

.column{
flex: 25px;
padding: 5px;
}

.column img{
margin-top: 5px;

}


/* Estilos para el menú desplegable */
#menu {
font-size: 16px;
padding: 10px;
border: 1px solid #ccc;
border-radius: 5px;
background-color: #f1f1f1;
color: #333;
width: 200px;
}

/* Estilos para las opciones del menú */
#menu option {
background-color: #f1f1f1;
color: #333;
}

/* Estilos para el botón del menú */
#menu-button {
padding: 12px 20px;
font-size: 18px;
background-color: #000000;
color: white;
border: none;
border-radius: 5px;
cursor: pointer;
}

/* Estilos para el botón del menú al pasar el cursor sobre él */
#menu-button:hover {
background-color: #000000;
}

.footer{
margin-top: 50px;
width: 100%;
padding: 100px;
background-color: #333;
color: #efefef;
display: flex;
height: 350px;
font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}
.footer div{
text-align: center;

}
.col-2{
flex-grow: 2;
}
.footer div h3{
font-weight: 200;
margin-bottom: 30px;
letter-spacing: 1px;
}
.col-1 a{
display: block;
text-decoration: none;
color: #efefef;
margin-top: 10px;
font-family: 'Oxygen', sans-serif;
}
form input{
width: 400px;
height: 40px;
border-radius: 15px;
text-align: center;
margin-top: 20px;
margin-bottom: 40px;
outline: none;
border: none;
}
form button{
background: transparent;
border: 2px solid #fff;
color: #Fff;
border-radius: 30px;
padding: 10px 30px;
font-size: 12px;
cursor: pointer;
}
    </style>
</head>
<body>
    <!--<header>
        <ul id="navegar">
            <li algin="right">
                <div>
                <img class="logo" src="catalogo/imgs/productos/Copia de Logo veterinaria animado azul rosado.png" alt="">
            </div>
            </li>
            <li algin="right">
                <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
                <input class="search" placeholder="¿Qué producto deseas comprar?"></input>
                <span class="material-symbols-outlined">
                    search
                    </span>
            </li>
            <li class="right-item">
                <h1></h1>
                <img class="carrito" src="catalogo/imgs/productos/carshop.png" alt="carrito-compras">
                <div id="carritoFlotante" class="carrito-flotante">
                    <div class="carrito-contenido" id="carritoContenido">
    
                    </div>
                  </div>
            </li>
            <li class="right-item"><a href="catalogo/catalogo.php">Tienda</a></li>
        </ul>
    </header>-->

            <section class="hero_container">
                <div class="hero_texts">
                  
                    <img class="animacion-imagen" src="catalogo/imgs/Logo veterinaria animado azul rosado.png">
                    </div>
                <div class="hero_texts">
                   
                  
                    
                    <center> <div class="hero_las"></center>
                        <h2 class="subtitle2">¡Productos,servicios y todo lo que necesites para tu mascota!</h2 >
                        <br>
                        <br>
                        <h3 class="subtitle">¿Quienes somos?</h3>
                    <h3>Mymba es un sotfware dedicado a la venta de productos y servicios para mascotas,ofreciendo los mejores precios,calidad y una asesoria con expertos dispuestos para resolver todo tipo de dudas relacionadas. </h3>
                   <a class="button is-black" href="catalogo/registro.php">Comenzar</a>

            </section>
        </div>
        <div class="hero_wave" style="overflow: hidden;" ><svg viewBox="0 0 100 100" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #a89166;"></path></svg></div>           
</body>
</html>