document.addEventListener('DOMContentLoaded', function() {
    const btnFiltrar = document.getElementById('filtrar');
    btnFiltrar.addEventListener('click', function() {
        const fechaInicio = document.getElementById('fecha-inscripcion-inicio').value;
        const fechaFin = document.getElementById('fecha-inscripcion-fin').value;
        const categoria = document.getElementById('number-of-categories').value; // Cambiado a 'number-of-categories'
        const estado = document.getElementById('estado').value;
        const activo = document.getElementById('activo').value;
        
        // Llamar a la función que obtiene y muestra los datos del Kardex
        cargarKardex(fechaInicio, fechaFin, categoria, estado, activo);
    });
    
    function cargarKardex(fechaInicio, fechaFin, categoria, estado, activo) {
        // Simulación de datos de ejemplo
        const cursos = [
            { nombre: 'Curso de Cocina Internacional', fechaInscripcion: '2024-01-10', ultimaEntrada: '2024-02-05', fechaTerminacion: '2024-03-10', estado: 'completo', categoria: 'Cocina Internacional', activo: false, progreso: 100 },
            { nombre: 'Curso de Repostería y Pastelería', fechaInscripcion: '2024-02-15', ultimaEntrada: '2024-03-01', fechaTerminacion: null, estado: 'incompleto', categoria: 'Repostería y Pastelería', activo: true, progreso: 60 },
            { nombre: 'Cocina de Temporada', fechaInscripcion: '2024-05-29', ultimaEntrada: '2024-09-14', fechaTerminacion: null, estado: 'incompleto', categoria: 'Cocina de Temporada', activo: true, progreso: 20 },
            // Agregar más cursos según sea necesario
        ];

        // Filtrar datos según los criterios seleccionados
        const cursosFiltrados = cursos.filter(curso => {
            const inscripcionValida = (!fechaInicio || new Date(curso.fechaInscripcion) >= new Date(fechaInicio)) &&
                                      (!fechaFin || new Date(curso.fechaInscripcion) <= new Date(fechaFin));
            const categoriaValida = categoria === 'todas' || curso.categoria === categoria;
            const estadoValido = estado === 'todos' || (estado === 'terminados' && curso.estado === 'completo'); 
            const activoValido = activo === 'todos' || (activo === 'activos' && curso.activo);

            return inscripcionValida && categoriaValida && estadoValido && activoValido;
        });

        mostrarKardex(cursosFiltrados);
    }

    function mostrarKardex(cursos) {
        const kardexContainer = document.querySelector('.kardex');
        kardexContainer.innerHTML = ''; // Limpiar resultados anteriores
        
        cursos.forEach(curso => {
            const card = document.createElement('div');
            card.className = 'card';
            
            const progreso = curso.progreso || 0; // Si no hay progreso, poner 0
            const progresoBar = `
                <div class="progreso-barra">
                    <div class="progreso" style="width: ${progreso}%;"></div>
                </div>
            `;
            
            card.innerHTML = `
                <h3>${curso.nombre}</h3>
                <p><strong>Fecha de Inscripción:</strong> ${curso.fechaInscripcion}</p>
                <p><strong>Última Entrada:</strong> ${curso.ultimaEntrada || 'N/A'}</p>
                <p><strong>Fecha de Terminación:</strong> ${curso.fechaTerminacion || 'En curso'}</p>
                <p><strong>Estado:</strong> ${curso.estado === 'completo' ? 'Completo' : 'Incompleto'}</p>
                <p><strong>Categoría:</strong> ${curso.categoria}</p>
                <p><strong>Activo:</strong> ${curso.activo ? 'Sí' : 'No'}</p>
                <p><strong>Progreso:</strong> ${progreso}%</p>
                ${progresoBar}
            `;
            kardexContainer.appendChild(card);
        });
    }
});
