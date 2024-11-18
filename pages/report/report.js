document.addEventListener('DOMContentLoaded', function() {
    console.log("Script cargado correctamente");

    const tipoUsuarioSelect = document.getElementById('tipo-usuario');
    const tablaReporte = document.getElementById('tabla-reporte');
    const cabeceraTabla = document.getElementById('cabecera-tabla');

    // Verifica si los elementos se obtuvieron correctamente
    if (!tipoUsuarioSelect) console.error("Select de tipo de usuario no encontrado");
    if (!tablaReporte) console.error("Tabla de reportes no encontrada");
    if (!cabeceraTabla) console.error("Cabecera de tabla no encontrada");

    // Añade el evento click al botón
    document.getElementById('generar-reporte').addEventListener('click', function() {
        console.log("Botón 'Generar Reporte' clickeado");
        const tipoUsuario = tipoUsuarioSelect.value;
        generarCabeceraTabla(tipoUsuario);
        generarDatosReporte(tipoUsuario);
    });

    // Función para generar la cabecera de la tabla
    function generarCabeceraTabla(tipoUsuario) {
        // Limpia la cabecera
        cabeceraTabla.innerHTML = '';

        // Genera las columnas de acuerdo al tipo de usuario
        if (tipoUsuario === 'instructor') {
            cabeceraTabla.innerHTML = `
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Fecha de Ingreso</th>
                <th>Cursos Ofrecidos</th>
                <th>Total de Ganancias</th>
            `;
        } else if (tipoUsuario === 'estudiante') {
            cabeceraTabla.innerHTML = `
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Fecha de Ingreso</th>
                <th>Cursos Inscritos</th>
                <th>% de Cursos Terminados</th>
            `;
        }
        console.log("Cabecera de tabla generada para:", tipoUsuario);
    }

    // Función para generar los datos del reporte
    function generarDatosReporte(tipoUsuario) {
        const tbody = tablaReporte.querySelector('tbody');
        tbody.innerHTML = ''; // Limpiar tabla

        // Datos de ejemplo estáticos
        let datosReporte = [];

        if (tipoUsuario === 'instructor') {
            datosReporte = [
                { usuario: 'Usuario123', nombre: 'Juan Pérez', fechaIngreso: '14/01/2023', cursosOfrecidos: 5, ganancias: '$525' },
                { usuario: 'Usuario456', nombre: 'Sandra Gómez', fechaIngreso: '25/08/2024', cursosOfrecidos: 3, ganancias: '$380' }
            ];
        } else if (tipoUsuario === 'estudiante') {
            datosReporte = [
                { usuario: 'Usuario654', nombre: 'Jorge Ramírez', fechaIngreso: '22/05/2024', cursosInscritos: 2, porcentajeCompletados: '65%' },
                { usuario: 'Usuario321', nombre: 'Ana Cervantes', fechaIngreso: '24/12/2023', cursosInscritos: 5, porcentajeCompletados: '100%' }
            ];
        }

        // Insertar las filas en la tabla
        datosReporte.forEach(usuario => {
            const fila = document.createElement('tr');
            if (tipoUsuario === 'instructor') {
                fila.innerHTML = `
                    <td>${usuario.usuario}</td>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.fechaIngreso}</td>
                    <td>${usuario.cursosOfrecidos}</td>
                    <td>${usuario.ganancias}</td>
                `;
            } else if (tipoUsuario === 'estudiante') {
                fila.innerHTML = `
                    <td>${usuario.usuario}</td>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.fechaIngreso}</td>
                    <td>${usuario.cursosInscritos}</td>
                    <td>${usuario.porcentajeCompletados}</td>
                `;
            }
            tbody.appendChild(fila);
        });
        console.log("Datos de reporte generados para:", tipoUsuario);
    }
});
