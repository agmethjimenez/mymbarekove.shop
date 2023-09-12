function abrirmodal(){
    document.getElementById('modal').style.display = 'flex';
}
function cerrarmodal(){
    document.getElementById('modal').style.display = 'none';
}

$(document).ready(function() {
    $(".detalles").click(function() {
        var productoId = $(this).data("producto-id");
        var imagenSrc = $(this).closest(".producto").find("img").attr("src");
        $.ajax({
            method: "GET",
            url: "modal.php",
            data: { id: productoId },
            success: function(response) {
                var producto = JSON.parse(response);
        
                $("#modal").html(`
                    <span class="cerrar" onclick="cerrarmodal()">&times;</span>
                    <div class="mod1">
                    <img class="modalimg" src="${imagenSrc}" alt="Producto Ampliado">
                    </div>
                    <div class="info">
                    <h1>${producto.nombre}</h1>
                    <p>${producto.descripcion}</p>
                    <p>${producto.contenido}</p>
                    <p>$ ${producto.precio}</p>
                    </div>
                    <!-- Agregar más elementos aquí -->
                `);
                abrirmodal();
            }
        });
    });
});
