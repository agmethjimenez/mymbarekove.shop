
    <style>
        /* Estilos básicos para la notificación */
        .custom-notification {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
            padding: 1rem;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }

        .custom-notification.hidden {
            opacity: 0;
        }

        .custom-notification.is-success {
            background-color: #48c774;
            color: white;
        }

        .custom-notification.is-danger {
            background-color: #f14668;
            color: white;
        }

        .custom-notification .delete {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: none;
            border: none;
            color: white;
            font-size: 1rem;
            cursor: pointer;
        }

        /* Estilos para la barra de carga */
        .custom-progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }

        .custom-progress-bar::after {
            content: '';
            display: block;
            width: 100%;
            height: 100%;
            background-color: white;
            animation: customProgressBarAnimation 5s linear forwards;
        }

        @keyframes customProgressBarAnimation {
            from { width: 100%; }
            to { width: 0; }
        }
    </style>
<?php
function mostrarNotificacion($mensaje, $tipo) {
    // Asegurarse de que el tipo de notificación sea válido
    $tiposValidos = ['success', 'danger'];
    if (!in_array($tipo, $tiposValidos)) {
        $tipo = 'success'; // Default a success si el tipo no es válido
    }
    
    // Clase CSS para el tipo de notificación
    $claseNotificacion = ($tipo === 'success') ? 'is-success' : 'is-danger';

    // Generar el HTML para la notificación
    echo '
    <div class="custom-notification ' . $claseNotificacion . '">
        
        ' . htmlspecialchars($mensaje) . '
        <div class="custom-progress-bar"></div>
    </div>
    ';
}

?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const notifications = document.querySelectorAll('.custom-notification');
    
    notifications.forEach(notification => {
        // Desaparecer después de 5 segundos
        setTimeout(() => {
            notification.classList.add('hidden');
            setTimeout(() => notification.remove(), 500);
        }, 5000);

        // Cerrar al hacer clic en el botón de borrar
        const deleteButton = notification.querySelector('.delete');
        deleteButton.addEventListener('click', () => {
            notification.classList.add('hidden');
            setTimeout(() => notification.remove(), 500);
        });
    });
});
</script>
