<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contrato de Membresía</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* margin: 20px; */
            line-height: 1.6;
        }

        h1,
        h2 {
            text-align: center;
        }

        .section {
            margin-bottom: 15px; /* Reducir el margen entre secciones */
            page-break-inside: avoid; /* Evitar cortes dentro de las secciones */
        }

        .contract-content {
            margin-left: 20px;
            page-break-inside: avoid; /* Evitar cortes dentro del contenido */
        }

        .contract-content ul {
            list-style-type: square;
            margin-left: 40px;
            margin-bottom: 10px; /* Reducir espacio después de las listas */
            page-break-inside: auto; /* Permitir saltos de página dentro de listas largas */
        }

        .contract-content li {
            margin-bottom: 5px; /* Reducir espacio entre elementos de lista */
        }

        .signature {
            /* margin-top: 40px; */
        }

        .signature p {
            text-align: center;
        }

        .row {
            display: flex;
            justify-content: space-between;
            /* Distribuye el espacio entre los elementos */
            align-items: center;
            /* Alinea verticalmente al centro */
            margin-bottom: 10px;
            /* Espaciado entre filas */
        }

        .row p {
            margin: 0;
            /* Elimina márgenes predeterminados */
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }

        body {
            background: url('{{ asset('status_images/sdrimsac.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            /* opacity: 0.5; */
            z-index: -1;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            content: '';
            padding-top: 140px;
            padding-bottom: 140px;

        }

        .content {
            width: 90%;
            max-width: 800px;
            padding: 30px;
            margin: 0 auto;
            /* margin-top: 100px !important; */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
        }

        h1,
        p {
            margin: 0 0 20px;
            line-height: 1.6;
        }

        .long-content {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <div class="content">
            <h4 style="text-align: center">CONTRATO PRIVADO DE MEMBRECÍA ANUAL DE UN APLICATIVO DE FACTURACIÓN
                ELECTRÓNICA
                CONTROL INTERNO</h4>
            <h5 style="text-align: center">Nro. 0001-000825</h5>

            <div class="section">
                <p>El presente contrato privado corresponde a Membresía de un Aplicativo de Control Interno y de
                    Facturación
                    Electrónica 100% en la NUBE (WEB) con VPS (Servidor Privado Virtual), que se celebra entre la
                    Empresa:
                </p>
                <p><strong>SYSTEMS DRIVE MASTER SAC</strong>,<sttrong>RUC: 20443618687</sttrong>, representado por el
                    Gerente
                    General, el <strong>Sr. Hugo Harold Luna Requena</strong>, identificado con <strong>DNI
                        20568798</strong>,
                    con domicilio en Jr. Miguel Grau Nº 222, Pichanaqui, Chanchamayo, Junín; a quien se le denominará en
                    adelante <strong>EL FACTURADOR</strong>.</p>
                <p>Y de la otra parte la empresa: <strong>{{ $record->name }}</strong>, de nombre Comercial
                    <strong>{{ $record->direccion_secondary }}</strong> con <strong>RUC: {{ $record->ruc }}</strong> representado por el <strong>Sr.
                        {{ $record->name }}</strong>, identificado con <strong>DNI Nº {{ $record->number }}</strong>, ubicado en {{ $record->direccion }} a quien en adelante se le denominará <strong>EL
                        CONTRATANTE</strong>.
                </p>
            </div>
            <div class="section contract-content">
                <h5>I. ANTECEDENTES</h5>
                <p>El <strong>APLICATIVO DE FACTURACIÓN ELECTRÓNICA</strong>, con integración directa a la API de SUNAT,
                    RENIEC
                    y WhatsApp,
                    está desarrollado en Laravel PHP, HTML, CSS, JS, con tecnologías PWA, Socket; con desempeño en la
                    NUBE
                    (WEB);
                    cuenta con un Servidor VPS alojado en Seattle- USA activo 24/7 con SO Ubuntu 20.04, está basado en
                    la
                    experiencia de 25 años de implementación en Empresas e Instituciones públicas y privadas,
                    totalmente funcional multiplataforma (Windows, MAC OS, Linux, Android, Harmony OS).</p>
                <p><strong>Contenido Membresía Full 12 meses:</strong></p>
                <ul>
                    <li><strong>Módulo Caja Administrador:</strong>
                        <ul>
                            <li>
                                - Realiza Créditos Efectivo / Hogar con tasa de porcentaje variante, abonos, generando
                                pagos
                                diarios / semanal / quincenal / mensual / pago único;
                                con tiempo de pago desde 1 mes en adelante.
                            </li>
                            <li>
                                - Al generar un crédito, puede asignar a un analista para que haga seguimiento al
                                prestatario.
                            </li>
                            <li>
                                - Al generar un crédito se genera un contrato de préstamo con acuerdos estipulados con
                                el
                                prestatario.
                            </li>
                            <li>
                                - Puede visualizar Cronograma de Pagos del prestatario.
                            </li>
                            <li>
                                - Puede ingresar pago de cuotas y/o cancelación completa del prestatario.
                            </li>
                            <li>
                                - Acepta o rechaza créditos que generen los usuarios Analista / Cajero.
                            </li>
                            <li>
                                - Puede filtrar créditos por Nombre o DNI de clientes, total de créditos por mes, por
                                créditos
                                aceptados, rechazados, pendientes, crédito hogar /
                                efectivo, filtro por usuario, por tipo de pago diario / semanal / quincenal / mensual.
                            </li>
                            <li>
                                - Puede exportar en documento Excel filtro de créditos Nombre o DNI de clientes, total
                                de
                                créditos por mes, por créditos aceptados, rechazados,
                                pendientes, crédito hogar / efectivo, filtro por usuario, por tipo de pago diario /
                                semanal
                                /
                                quincenal / mensual.
                            </li>
                            <li>
                                - Puede exportar Reporte de Créditos Diario por cobrar y atrasados.
                            </li>
                            <li>
                                - Puede generar gastos / ingreso de efectivo.
                            </li>
                            <li>
                                - Puede visualizar y generar comprobantes de pago emitidos Factura – Boleta a partir de
                                la
                                Nota
                                de Venta generada por el crédito.
                            </li>
                            <li>
                                - Puede visualizar monto de Cobros del día.
                            </li>
                            <li>
                                - Historial de Cierres de Caja.
                            </li>
                            <li>
                                - Visualizar saldo disponible para realizar créditos de efectivo.
                            </li>
                            <li>
                                - Recepciona traslado de efectivo por parte de Usuario Arca.
                            </li>
                        </ul>
                    </li>
                    <li><strong>Usuario Analista:</strong>
                        <ul>
                            <li>
                                - Realiza Créditos Efectivo / Hogar con tasa de porcentaje variante, abonos, generando
                                pagos
                                diarios / semanal / quincenal / mensual /
                                pago único; con tiempo de pago desde 1 mes en adelante.
                            </li>
                            <li>
                                - Al generar un crédito se genera un contrato de préstamo con acuerdos estipulados con
                                el
                                prestatario.
                            </li>
                            <li>
                                - Puede visualizar Cronograma de Pagos del prestatario.
                            </li>
                            <li>
                                - Puede ingresar pago de cuotas y/o cancelación completa del prestatario.
                            </li>
                            <li>
                                - Puede filtrar créditos por Nombre o DNI de clientes, total de créditos por mes, por
                                créditos
                                aceptados, rechazados, pendientes, crédito hogar / efectivo, filtro por usuario, por
                                tipo de
                                pago diario / semanal / quincenal / mensual.
                            </li>
                            <li>
                                - Puede exportar en documento Excel filtro de créditos Nombre o DNI de clientes, total
                                de
                                créditos por mes, por créditos aceptados, rechazados, pendientes, crédito hogar /
                                efectivo,
                                filtro por usuario, por tipo de pago diario / semanal / quincenal / mensual.
                            </li>
                            <li>
                                - Puede exportar Reporte de Créditos Diario por cobrar y atrasados.
                            </li>
                            <li>
                                - Puede generar gastos / ingreso de efectivo
                            </li>
                            <li>
                                - Puede visualizar y generar comprobantes de pago emitidos Factura – Boleta a partir de
                                la
                                Nota
                                de Venta generada por el crédito
                            </li>
                            <li>
                                - Puede visualizar monto de Cobros del día
                            </li>
                            <li>
                                - Historial de Cierres de Caja
                            </li>
                            <li>
                                - Visualizar saldo disponible para realizar créditos de efectivo
                            </li>
                            <li>
                                - Recepciona (Recibe) traslado de efectivo por parte de Usuario Arca.
                            </li>

                        </ul>
                    </li>
                    <li><strong>Usuario Cajero:</strong>
                        <ul>
                            <li>
                                - Puede visualizar Cronograma de Pagos del prestatario.
                            </li>
                            <li>
                                - Puede ingresar pago de cuotas y/o cancelación completa del prestatario.
                            </li>
                            <li>
                                - Puede filtrar créditos por Nombre o DNI de clientes, total de créditos por mes, por
                                créditos
                                aceptados, rechazados, pendientes, crédito hogar / efectivo, filtro por usuario, por
                                tipo de
                                pago diario / semanal / quincenal / mensual.
                            </li>
                            <li>
                                - Puede exportar en documento Excel filtro de créditos Nombre o DNI de clientes, total
                                de
                                créditos por mes, por créditos aceptados, rechazados, pendientes, crédito hogar /
                                efectivo,
                                filtro por usuario, por tipo de pago diario / semanal / quincenal / mensual.
                            </li>
                            <li>
                                - Puede exportar Reporte de Créditos Diario por cobrar y atrasados.
                            </li>
                            <li>
                                - Puede visualizar y generar comprobantes de pago emitidos Factura – Boleta a partir de
                                la
                                Nota
                                de Venta generada por el crédito
                            </li>
                            <li>
                                - Puede visualizar monto de Cobros del día.
                            </li>
                            <li>
                                - Historial de Cierres de Caja.
                            </li>
                            <li>
                                - Visualizar saldo disponible para realizar créditos de efectivo.
                            </li>
                        </ul>
                    </li>
                    <li><strong>Módulo Administrador:</strong>
                        <ul>
                            <li>
                                - Mantenimiento de Usuarios, Clientes, Categorías, Marcas, Registro de número de Cuentas
                                de
                                Banco.
                            </li>
                            <li>
                                - Compras de Productos Hogar (se descuenta automático de Cartera Presupuestaria) –
                                Listado
                                de
                                Compras.
                            </li>
                            <li>
                                - Creación de Productos con y sin serie, así como de Servicios.
                            </li>
                            <li>
                                - Ventas Administrativas (Factura, Boletas y Notas de Venta) Envíos de Factura, Boleta
                                directos
                                a SUNAT.
                            </li>
                            <li>
                                - Anulación de comprobantes (Interno y Externo) – Nota de Crédito.
                            </li>
                            <li>
                                - Ingresos y Gastos de Efectivo.
                            </li>
                            <li>
                                - Reporte de Caja.
                            </li>
                            <li>
                                - Reporte de Cierre de Caja por Establecimiento y Turnos.
                            </li>
                            <li>
                                - Arca (Recepciona y/o rechaza los cierres de Caja de todos los usuarios ANALISTA/CAJA
                                –.
                            </li>
                            <li>
                                - Transferencia de efectivo de Cartera Presupuestaria a usuarios Caja/Analista.
                            </li>
                            <li>
                                - Reporte de Créditos.
                            </li>
                            <li>
                                - Reporte de Ganancia Hogar /Efectivo.
                            </li>
                            <li>
                                - Reporte de Stock de Productos.
                            </li>
                            <li>
                                - Reporte Productos Vendidos.
                            </li>
                            <li>
                                - Reporte Valorizado.
                            </li>
                            <li>
                                - Reporte de Stock Mínimo.
                            </li>
                            <li>
                                - Reporte de Métodos de Pago.
                            </li>
                            <li>
                                - Reporte de Kardex.
                            </li>
                            <li>
                                - Contabilidad (Compras y Ventas).
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="section contract-content">
                <h3>II. PROPUESTA</h3>
                <p>En esta propuesta el método del contrato será de la siguiente manera: Costo de Membresía Anual (12
                    meses)
                    S/3000 (tres mil soles).</p>
                <p>Pasado el año el pago será de S/80 mensual bajo contrato firmado de compromiso, a ser pagado cada
                    inicio
                    de
                    mes con fecha 1; cronograma que se estará recordando con días de anterioridad (5 días, 3 días) y el
                    día
                    propio del vencimiento de servicio que deben ser pagados a través de la plataforma Yape con número
                    995764963
                    a nombre de Hugo Luna, Gerente General de EL FACTURADOR.</p>
                <P>De la misma manera se establece, que si se genera retraso en el pago mensual se procede al corte
                    automático y
                    programado del servicio, mismo que genera un cobro adicional a la cuota mensual con cargo por
                    reconexión
                    de
                    S/20.</P>
                <P>Es importante mencionar que la base de datos generada en el periodo de la membresía, tendrá un
                    respaldo
                    que
                    podrá ser solicitada por el CONTRATANTE, cuando lo requiera (01 vez por año) mientras se mantenga el
                    contrato de membresía, en previa coordinación con el representante legal de EL FACTURADOR;
                    documentos
                    que se
                    otorgarán a través de un correo electrónico que se derivará de gerencia@sdrimsac.com

                </P>
                <P>
                    Cabe resaltar, que toda la información procesada en el Facturador de SYSTEMS DRIVE MASTER SAC es de
                    total
                    CONFIDENCIALIDAD, por lo que El Facturador está obligado a no compartir ni parcial, ni totalmente
                    datos
                    o
                    data que nuestro convenio comercial genere.
                </P>
            </div>

            <div class="section contract-content">
                <h3>III. CAPACITACIÓN E INDUCCIÓN</h3>
                <p>Referente a la Capacitación e implementación, se dará en una fecha previa coordinación entre EL
                    FACTURADOR Y
                    EL CONTRATANTE, el cual tendrá un periodo de duración de 02 horas en los Módulos Administrativo/Arca
                    –
                    Caja
                    administrador – Caja analista y Caja (cobranza)</p>
                <P>Así mismo, se le otorgará un manual de uso con las funciones del sistema en video vía nuestra página
                    Web
                    o en
                    PDF según su elección.</P>
            </div>

            <div class="section contract-content">
                <h3>IV. RESPONSABILIDADES</h3>
                <ul>
                    <li><strong>EL FACTURADOR</strong> EL FACTURADOR se compromete en brindar soporte técnico en el
                        siguiente
                        horario: Lunes a Sábado de 8:00am a 12:30pm y 3:00pm a 6:30pm </li>
                    <li>Cualquier corrección o modificación al sistema BASE que no esté contemplado en su desarrollo,
                        tendrá
                        un
                        costo adicional dependiendo de la complejidad de lo solicitado (previa coordinación) y en un
                        periodo
                        mínimo de 15 días</li>
                    <li>Si el sistema presenta algún error o falla, deberá ser comunicado de inmediato a través de la
                        plataforma
                        WhatsApp en el grupo chat laboral creado con el nombre de la empresa como “App CREDIHOGAR”</li>
                    <li>Cabe resaltar que El Facturador sólo otorga la Membresía del Aplicativo de Facturación
                        Electrónica y
                        Control Interno, más no los equipos, costo que deberán ser asumidos por EL CONTRATANTE en caso
                        de no
                        contar con ello. </li>
                    <li> Importante mencionar que la responsabilidad de EL FACTURADOR implica estrictamente velar por el
                        funcionamiento del Aplicativo; desligándose así de programas externos a ello, como Word, Excel,
                        antivirus, el servicio de internet y el funcionamiento de sus equipos periféricos (PC, Monitor,
                        Impresoras, Estabilizador,
                        UPS, etc).
                    </li>
                    <li>
                        También se especifica que una vez iniciado el contrato y la creación del aplicativo, se
                        contabiliza
                        la
                        membresía no habiendo motivo de pausa o descuento de días por el NO uso de la misma
                        (Responsabilidad
                        de
                        EL CONTRATANTE).
                    </li>
                </ul>
            </div>

            <div class="section contract-content">
                <h3>V. USUARIOS</h3>
                <p>Inicialmente, se otorgan 04 usuarios con los privilegios determinados por EL CONTRATANTE, que se
                    mostrará
                    de
                    la siguiente manera:</p>
                <ul>
                    <li>
                        - Módulos Administrativo/Arca – Caja administrador – Caja analista y Caja (cobranza).
                    </li>
                </ul>
                <p>Requerimientos para la creación del usuario:</p>
                <ul>
                    <li>
                        Nombre completo del usuario, número de DNI del usuario, correo electrónico, teléfono, cargo.
                    </li>
                </ul>
            </div>

            <div class="section contract-content">
                <h3>VI. REQUERIMIENTOS PARA LA INSTALACIÓN Y PUESTA EN MARCHA</h3>
                <ul>
                    <li>PC o Laptop con procesador Procesador Core I3 Memoria 4GB Disco Solido de 120GB monitor de 19
                    </li>
                    <li>Celular o Tablet Android 6 - Espacio 200MB - RAM 4 GB</li>
                </ul>
            </div>

            <div class="section contract-content">
                <h3>VII. REQUISITOS PARA EL CONTRATO</h3>
                <p>Para el inicio de la Implementación EL CONTRATANTE debe otorgar la siguiente información:</p>
                <ul>
                    <li>
                        • LOGO - RUC - CLAVE SOL - DESCRIPCION DEL NEGOCIO - CORREO ELECTRÓNICO - PRODUCTOS (Excel).
                        Es importante resaltar, que en caso de que EL CONTRATANTE no cuente con la información de su
                        inventario
                        y requiera los servicios de EL FACTURADOR para tal fin, tendrá un costo de S/200 por día
                        trabajado.
                    </li>
                    <li>
                        Fecha de Implementacion: 15 días calendario a partir de la firma del contrato.
                    </li>
                </ul>
            </div>

            <div class="signature">
                <p>En señal de conformidad, ambas partes firman en total acuerdo, a los --- días del mes de enero del
                    año
                    2025.
                </p>
            </div>
            
            <div style="text-align: center; margin-top: 150px;">
                <div style="display: flex; justify-content: space-between;">
                    <div style="width: 45%; text-align: center;">
                        <p><strong>SDRIMSAC SOLUTIONS</strong></p>
                        <p><strong>EL FACTURADOR</strong></p>
                    </div>
                    <div style="width: 45%; text-align: center; margin-left: 400px;">
                        <p><strong>EL CONTRATANTE</strong></p>
                        <p>DNI 71689135</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
