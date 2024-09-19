document.addEventListener('DOMContentLoaded', function() {
    const tablaVentas = document.getElementById('tabla-ventas');
    const cabeceraTabla = document.getElementById('cabecera-tabla-ventas');
    const tablaCursosDiv = document.getElementById('tabla-cursos');
    const resumenVentasDiv = document.getElementById('resumen-ventas');

    document.getElementById('filtrar-ventas').addEventListener('click', function() {
        const tipoReporte = document.getElementById('tipo-reporte').value;
        const categoriaFiltro = document.getElementById('number-of-categories').value;
        const fechaInicio = document.getElementById('fecha-inscripcion-inicio').value;
        const fechaFin = document.getElementById('fecha-inscripcion-fin').value;
        const activoFiltro = document.getElementById('activo').value;

        let datosFiltrados;

        if (tipoReporte === 'general') {
            datosFiltrados = filtrarDatosVentasGeneral(categoriaFiltro, fechaInicio, fechaFin, activoFiltro);
            generarCabeceraTablaGeneral();
            generarDatosVentasGeneral(datosFiltrados);
            tablaCursosDiv.style.display = 'none'; // Ocultar tabla de cursos
        } else {
            generarCabeceraTablaDetallada();
            datosFiltrados = filtrarDatosVentasDetallada(categoriaFiltro, fechaInicio, fechaFin, activoFiltro);
            generarDatosVentasDetallada(datosFiltrados);
            tablaCursosDiv.style.display = 'block'; // Mostrar tabla de cursos
        }
    });

    function generarCabeceraTablaGeneral() {
        cabeceraTabla.innerHTML = `
            <th>Curso</th>
            <th>Alumnos Inscritos</th>
            <th>Nivel Promedio</th>
            <th>Total de Ingresos</th>
        `;
        tablaVentas.parentElement.style.display = 'block';
    }

    function generarDatosVentasGeneral(datosFiltrados) {
        const tbody = tablaVentas.querySelector('tbody');
        tbody.innerHTML = ''; // Limpiar tabla

        datosFiltrados.forEach(venta => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${venta.curso}</td>
                <td>${venta.inscritos}</td>
                <td>${venta.nivelPromedio}</td>
                <td>$${venta.ingresos}</td>
            `;
            tbody.appendChild(fila);
        });

        // Resumen de ingresos por forma de pago
        document.getElementById('resumen-ventas').innerHTML = `
            <h3 class="big-name eerie">Total por forma de pago:</h3>
            <br>
            <p>Efectivo: $5,700.00</p>
            <p>Tarjeta: $3,730.50</p>
        `;

        resumenVentasDiv.style.display = 'block'; // Mostrar resumen de ventas
    }

    function generarCabeceraTablaDetallada() {
        cabeceraTabla.innerHTML = `
            <th>Alumno</th>
            <th>Fecha de Inscripción</th>
            <th>Nivel de Avance</th>
            <th>Precio Pagado</th>
            <th>Forma de Pago</th>
        `;
    }

    function generarDatosVentasDetallada(datosFiltrados) {
        const tablaCursos = document.getElementById('tabla-cursos');
        tablaCursos.innerHTML = ''; // Limpiar el contenedor de tablas

        const tbody = tablaVentas.querySelector('tbody');
        tbody.innerHTML = ''; // Limpiar tabla

        cabeceraTabla.innerHTML = ''; // Limpiar el contenedor de tablas

        const datosAgrupados = datosFiltrados.reduce((acc, alumno) => {
            if (!acc[alumno.curso]) {
                acc[alumno.curso] = [];
            }
            acc[alumno.curso].push(alumno);
            return acc;
        }, {});

        for (const [curso, alumnos] of Object.entries(datosAgrupados)) {
            const tablaCurso = document.createElement('table');
            tablaCurso.className = 'tabla-curso';
            tablaCurso.style.marginBottom = '20px';
            tablaCurso.innerHTML = `
                <caption class="option eerie">${curso}</caption>
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Fecha de Inscripción</th>
                        <th>Nivel de Avance</th>
                        <th>Precio Pagado</th>
                        <th>Forma de Pago</th>
                    </tr>
                </thead>
                <tbody>
                    ${alumnos.map(alumno => `
                        <tr>
                            <td>${alumno.alumno}</td>
                            <td>${alumno.fechaInscripcion}</td>
                            <td>${alumno.nivelAvance}</td>
                            <td>${parseFloat(alumno.precioPagado).toLocaleString('en-US', {
                                style: 'currency',
                                currency: 'USD'
                            })}</td>
                            <td>${alumno.formaPago}</td>
                        </tr>
                    `).join('')}
                </tbody>
            `;
            tablaCursos.appendChild(tablaCurso);
        }

        const totalIngresos = datosFiltrados.reduce((total, alumno) => total + parseFloat(alumno.precioPagado), 0);
        document.getElementById('resumen-ventas').innerHTML = `
            <h3 class="big-name eerie">Total de Ingresos:</h3>
            <p>${totalIngresos.toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD'
            })}</p>
        `;

        resumenVentasDiv.style.display = 'block'; // Mostrar resumen de ventas
    }

    // Datos ficticios para los cursos generales
    const datosVentasGenerales = [
        { curso: 'Nutrición Balanceada', inscritos: 10, nivelPromedio: '2.0', ingresos: '1,250.00', categoria: 'Cocina Saludable', fechaCreacion: '2024-09-01', activo: true },
        { curso: 'Sabores del Mundo', inscritos: 8, nivelPromedio: '3.0', ingresos: '980.50', categoria: 'Cocina Internacional', fechaCreacion: '2024-08-15', activo: true },
        { curso: 'Dulces y Postres Caseros', inscritos: 15, nivelPromedio: '4.0', ingresos: '1,500.00', categoria: 'Repostería y Pastelería', fechaCreacion: '2024-07-22', activo: false },
        { curso: 'Cocina Vegana para Todos', inscritos: 20, nivelPromedio: '5.0', ingresos: '2,000.00', categoria: 'Cocina Vegetariana y Vegana', fechaCreacion: '2024-01-10', activo: true },
        { curso: 'Técnicas Básicas de Cocina', inscritos: 12, nivelPromedio: '1.0', ingresos: '1,000.00', categoria: 'Técnicas de Cocina Básicas', fechaCreacion: '2024-04-01', activo: false },
        { curso: 'Sabores de Temporada', inscritos: 18, nivelPromedio: '3.0', ingresos: '1,800.00', categoria: 'Cocina de Temporada', fechaCreacion: '2024-06-10', activo: false },
        { curso: 'Cenas Rápidas y Fáciles', inscritos: 9, nivelPromedio: '2.0', ingresos: '900.00', categoria: 'Platos Rápidos', fechaCreacion: '2024-05-05', activo: true }
    ];

    // Datos ficticios para los cursos detallados (alumnos)
    const datosVentasDetalladas = [
        { alumno: 'Juan Pérez', fechaInscripcion: '12 Sep 2024', nivelAvance: '2.0', precioPagado: '500.00', formaPago: 'Tarjeta', curso: 'Nutrición Balanceada', categoria: 'Cocina Saludable', fechaCreacion: '2024-09-01', activo: true },
        { alumno: 'María López', fechaInscripcion: '14 Sep 2024', nivelAvance: '3.0', precioPagado: '250.00', formaPago: 'Efectivo', curso: 'Técnicas Básicas de Cocina', categoria: 'Platos Rápidos', fechaCreacion: '2024-04-01', activo: true },
        { alumno: 'Carlos Ruiz', fechaInscripcion: '20 Ago 2024', nivelAvance: '7.0', precioPagado: '750.00', formaPago: 'Tarjeta', curso: 'Dulces y Postres Caseros', categoria: 'Repostería y Pastelería', fechaCreacion: '2024-07-22', activo: false },
        { alumno: 'Ana González', fechaInscripcion: '05 Jul 2024', nivelAvance: '4.0', precioPagado: '500.00', formaPago: 'Efectivo', curso: 'Sabores de Temporada', categoria: 'Cocina de Temporada', fechaCreacion: '2024-06-10', activo: false }
    ];

    function filtrarDatosVentasGeneral(categoria, fechaInicio, fechaFin, activo) {
        return datosVentasGenerales.filter(venta => {
            const cumpleCategoria = categoria === 'todas' || venta.categoria === categoria;
            const cumpleFecha = (!fechaInicio || venta.fechaCreacion >= fechaInicio) && (!fechaFin || venta.fechaCreacion <= fechaFin);
            const cumpleActivo = activo === 'todos' || (activo === 'activos' && venta.activo);
            return cumpleCategoria && cumpleFecha && cumpleActivo;
        });
    }

    function filtrarDatosVentasDetallada(categoria, fechaInicio, fechaFin, activo) {
        return datosVentasDetalladas.filter(alumno => {
            const cumpleCategoria = categoria === 'todas' || alumno.categoria === categoria;
            const cumpleFecha = (!fechaInicio || alumno.fechaCreacion >= fechaInicio) && (!fechaFin || alumno.fechaCreacion <= fechaFin);
            const cumpleActivo = activo === 'todos' || (activo === 'activos' && alumno.activo);
            return cumpleCategoria && cumpleFecha && cumpleActivo;
        });
    }
});
