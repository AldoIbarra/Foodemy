document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('certificado-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío del formulario para validar y generar certificado

        const nombreEstudiante = document.getElementById('nombre-estudiante').value.trim();
        const nombreCurso = document.getElementById('nombre-curso').value.trim();
        const nombreInstructor = document.getElementById('nombre-instructor').value.trim();
        const fechaFinalizacion = document.getElementById('fecha-finalizacion').value;

        if (!nombreEstudiante || !nombreCurso || !nombreInstructor || !fechaFinalizacion) {
            alert('Por favor, completa todos los campos.');
            return;
        }

        // Formatear la fecha en formato DD/MM/AAAA
        const fechaFormateada = formatearFecha(fechaFinalizacion);

        // Generar el certificado y mostrarlo
        generarCertificado(nombreEstudiante, nombreCurso, nombreInstructor, fechaFormateada);
    });

    // Función para formatear la fecha en formato DD/MM/AAAA
    function formatearFecha(fecha) {
        const partes = fecha.split('-'); // Separar la fecha ingresada (AAAA-MM-DD)
        const dia = partes[2].padStart(2, '0'); // Asegurarse de que el día tiene dos dígitos
        const mes = partes[1].padStart(2, '0'); // Asegurarse de que el mes tiene dos dígitos
        const anio = partes[0];
        return `${dia}/${mes}/${anio}`; // Devolver en formato DD/MM/AAAA
    }

    // Función para generar el certificado en una nueva ventana
    function generarCertificado(nombreEstudiante, nombreCurso, nombreInstructor, fechaFinalizacion) {
        const certificadoHTML = `
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap');
                @import url('https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap');
                body {
                    background-color: #003054;
                    color: #fff;
                    font-family: 'Outfit', sans-serif;
                }
                h2.nombre-estudiante {
                    font-family: 'Dancing Script', cursive;
                    font-size: 60px;
                    color: #efb810;
                    margin-bottom: 5px;
                }
                .nombre-estudiante-línea {
                    border-bottom: 2px solid #E32D40;
                    width: 60%;
                    margin: 0 auto 20px auto;
                }
                .certificado-container {
                    border: 5px solid #efb810;
                    padding: 20px;
                    max-width: 800px;
                    margin: auto;
                    position: relative;
                    background: #fff;
                    font-family: 'Outfit', sans-serif;
                    border-radius: 10px;
                    text-align: center;
                    background-image: url('https://img.freepik.com/vector-premium/diseno-plantilla-degradado-onda-fondo-linea_483537-5070.jpg');
                    background-size: cover;
                    background-position: center;
                }
                .certificado-container p {
                    color: #202020;
                }
                .certificado-container h1,
                .certificado-container h2 {
                    color: #202020;
                }
                .firma-director {
                    width: 150px;
                    margin: 0 auto;
                    margin-top: -95px;
                }
                .descargar-pdf {
                    margin-top: 20px;
                }
            </style>
            <div class="certificado-container">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/214/214282.png" alt="Logo Izquierda" style="max-width: 100px; max-height: 100px; border-radius: 10px;">
                    <div style="border-bottom: 3px solid #efb810; padding-bottom: 10px; width: 100%; text-align: center;">
                        <h1 style="color: #efb810; font-size: 36px;">Certificado de Finalización</h1>
                    </div>
                    <img src="../resources/logoCurso.png" alt="Logo Derecha" style="max-width: 100px; max-height: 100px; border-radius: 10px;">
                </div>
                <p style="font-size: 20px; margin-bottom: 10px; margin-top: 80px; color: #202020;">OTORGADO A:</p>
                <h2 class="nombre-estudiante" style="color: #efb810;">${nombreEstudiante}</h2>
                <div class="nombre-estudiante-línea" style="border-bottom: 2px solid #003054;"></div>
                <p style="font-size: 20px; margin-bottom: 10px; color: #202020;">Por haber completado satisfactoriamente el curso virtual de</p>
                <h2 style="display: inline-block; margin-bottom: 20px; font-size: 24px; color: #003054;">${nombreCurso}</h2>
                <p style="font-size: 20px; margin-bottom: 10px; color: #202020;">en la fecha</p>
                <h2 style="display: inline-block; margin-bottom: 20px; font-size: 24px; color: #003054;">${fechaFinalizacion}</h2>
                <p style="font-size: 20px; margin-bottom: 10px; color: #202020;">Impartido a través de la página oficial de Foodemy</p>
                <p style="font-size: 20px; margin-bottom: 10px; margin-top: 50px; color: #202020;">Instructor:</p>
                <h2 style="display: inline-block; margin-bottom: 40px; font-size: 24px; color: #003054;">${nombreInstructor}</h2>
                <div style="border-top: 2px solid #efb810; width: 200px; margin: 20px auto; margin-top: 60px; height: 30px;"></div>
                <img class="firma-director" src="https://upload.wikimedia.org/wikipedia/commons/3/3a/Jon_Kirsch%27s_Signature.png" alt="Firma del Director">
                <p style="font-size: 18px; color: #efb810; margin-top: -35px;">Firma del Director:</p>
                <button class="descargar-pdf" onclick="descargarPDF()">Descargar PDF</button>
            </div>

        `;

        // Mostrar el certificado en una nueva ventana
        const ventanaCertificado = window.open('', '_blank');
        ventanaCertificado.document.open();
        ventanaCertificado.document.write(certificadoHTML);
        ventanaCertificado.document.close();

        ventanaCertificado.onload = function() {
            ventanaCertificado.document.querySelector('.descargar-pdf').addEventListener('click', function() {
                // Crear el PDF
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                // Añadir contenido al PDF
                doc.setFont('Outfit', 'bold');
                doc.setFontSize(22);
                doc.text('Certificado de Finalización', 105, 20, { align: 'center' });
                
                doc.setFontSize(16);
                doc.setFont('Outfit', 'regular');
                doc.text(`OTORGADO A: ${nombreEstudiante}`, 105, 40, { align: 'center' });
                doc.text(`Por haber completado satisfactoriamente el curso virtual de ${nombreCurso}`, 105, 60, { align: 'center' });
                doc.text(`en la fecha ${fechaFinalizacion}`, 105, 80, { align: 'center' });
                doc.text(`Impartido a través de la página oficial de Foodemy`, 105, 100, { align: 'center' });
                doc.text(`Instructor: ${nombreInstructor}`, 105, 120, { align: 'center' });
                
                // Añadir la firma y línea de firma
                doc.setFont('Outfit', 'bold');
                doc.text('Firma del Director:', 105, 160, { align: 'center' });
                doc.line(30, 165, 180, 165); // Línea para la firma
                
                // Guardar el PDF
                doc.save('certificado.pdf');
            });
        };
    }
});
