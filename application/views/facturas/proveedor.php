<?php
$conn=mysqli_connect("localhost", "root", "") OR DIE ('Unable to connect to database! Please try again later.');
mysqli_select_db($conn,"compensapay");

?>
<div class="p-5" id="app">


    <div class="row">
        <p class="px-3">Periodo:</p>
        <div class="col l3">
            <input type="date" id="start" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
            <label for="start">Inicio:</label>
        </div>
        <div class="col l3">
            <input type="date" id="fin" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
            <label for="fin">Fin:</label>
        </div>
        <div class="col l3 p-3">
                    <!-- <button class="button-indicador <?= $this->session->userdata('vista') == 2 ? 'selected' : '' ?>" >
                        Clientes
                    </button>
                    &nbsp;
                    <button class="button-indicador <?= $this->session->userdata('vista') == 1 ? 'selected' : '' ?>" >
                        Provedores
                    </button> -->
                </div>
        <div class="col l3 right-align p-5">
            <a class="modal-trigger button-blue" href="#modal-factura" v-if="selectedButton === 'Facturas'">
                Añadir Facturas
            </a>
            <a class="modal-trigger button-blue" href="#modal-operacion" v-if="selectedButton === 'Operaciones'">
                Crear Operaciones
            </a>
        </div>
    </div>



    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div class="col l3 p-3">
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Operaciones' }" @click="selectButton('Operaciones')">
                        Operaciones
                    </button>
                    &nbsp;
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Facturas' }" @click="selectButton('Facturas')">
                        Facturas
                    </button>
                </div>
                <div class="col 9">
                    <form class="input-border" action="#" method="post" style="display: flex;">
                        <input type="search" placeholder="Buscar">
                    </form>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table v-if="selectedButton === 'Facturas'" class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Operación</th>
                            <th>Estatus Factura</th>
                            <th>Proveedor</th>
                            <th>Factura</th>
                            <th>Fecha Factura</th>
                            <th>Fecha Alta</th>
                            <th>Fecha Transacción</th>
                            <th style="text-align: right">Subtotal</th>
                            <th style="text-align: right">IVA</th>
                            <th style="text-align: right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM operacion ORDER BY o_idoperacion DESC";

                            $ResFacturas=mysqli_query($conn, $query);

                            while($RResF=mysqli_fetch_array($ResFacturas))
                            {
                                echo '<tr>
                                        <td class="tabla-celda center-align">';
                                        if($RResF["o_Activo"]==1)
                                        {
                                            echo '<i class="small material-icons" style="color: green;">check_circle</i>';
                                        }
                                        else if($RResF["o_Activo"]==0)
                                        {
                                            echo '<a class="modal-trigger " href="#modal-operacion-unico">Crear Operación</a>';
                                        }
                                echo '  </td>';
                                        if($RResF["o_Activo"]==1)
                                        {
                                            echo '<td>Pagada</td>';
                                        }
                                        else if($RResF["o_Activo"]==0)
                                        {
                                            echo '<td>Pendiente</td>';
                                        }
                                echo '  <td><a href="#">Frontier</a></td>
                                        <td>'.$RResF["o_NumOperacion"].'</td>
                                        <td>'.$RResF["o_FechaEmision"].'</td>
                                        <td>'.$RResF["o_FechaUpload"].'</td>';
                                        if($RResF["o_Activo"]==1)
                                        {
                                            echo '<td>Pagada</td>';
                                        }
                                        else if($RResF["o_Activo"]==0)
                                        {
                                            echo '<td>Por Definir</td>';
                                        }
                                echo '  <td style="text-align: right">$ '.number_format($RResF["o_SubTotal"], 2).'</td>
                                        <td style="text-align: right">$ '.number_format($RResF["o_Impuesto"], 2).'</td>
                                        <td style="text-align: right">$ '.number_format($RResF["o_Total"], 2).'</td>
                                    </tr>';
                            }

                            
                        ?>
                        <!--<tr v-for="factura in facturas" :key="facturas.o_idPersona">

                            <td class="tabla-celda center-align">
                                <i v-if="factura.o_Activo == 1"  class="small material-icons" style="color: green;">check_circle</i>
                                <a v-if="factura.o_Activo == 0" class="modal-trigger " href="#modal-operacion-unico">Crear Operación</a>
                            </td>             
                            <td><a href="#">Frontier</a></td>
                            <td>{{factura.o_NumOperacion}}</td>
                            <td>{{modificarFecha(factura.o_FechaEmision)}}</td>
                            <td>{{modificarFecha(factura.o_FechaUpload)}}</td>
                            <td>{{modificarFecha(factura.o_FechaEmision)}}</td>
                            <td>
                                <p v-if="factura.o_Activo == 1" >Pendiente</p>
                                <p v-if="factura.o_Activo == 0" >Cargada</p>
                            </td>   
                            <td >${{factura.o_SubTotal}}</td>
                            <td >${{factura.o_Impuesto}}</td>
                            <td >${{factura.o_Total}}</td>
                        </tr>-->
                    </tbody>
                </table>
                <table v-if="selectedButton === 'Operaciones'" class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Aprobacion</th>
                            <th>Estatus</th>
                            <th>ID Operacion</th>
                            <th>Proveedor</th>
                            <th>Fecha Factura</th>
                            <th>Fecha Alta</th>
                            <th>Factura</th>
                            <th>Nota</th>
                            <th>Fecha Nota</th>
                            <th>Fecha Transacción</th>
                            <th style="text-align: right">Monto Ingreso</th>
                            <th style="text-align: right">Monto Egreso</th>
                            <!-- <th >Adelanta tu pago</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM tabla_ejemplo ORDER BY ID DESC";

                            $ResOperaciones=mysqli_query($conn, $query);

                            while($RResO=mysqli_fetch_array($ResOperaciones))
                            {
                                echo '<tr>
                                        <td class="tabla-celda center-align">';
                                        if($RResO["Aprobacion"]==1)
                                        {
                                            echo '<i class="small material-icons" style="color: green;">check_circle</i>';
                                        }
                                        else if($RResO["Aprobacion"]==0)
                                        {
                                            echo '<i class="small material-icons" style="color: black;">radio_button_unchecked</i>';
                                        }
                                echo '  </td>';
                                        if($RResO["Aprobacion"]==1)
                                        {
                                            echo '<td>Aprobada</td>';
                                        }
                                        else if($RResO["Aprobacion"]==0)
                                        {
                                            echo '<td>Pendiente</td>';
                                        }
                                echo '  <td>'.$RResO["ID_Operacion"].'</td>
                                        <td><a href="#">Frontier</a></td>
                                        <td>'.$RResO["Fecha_Factura"].'</td>
                                        <td>'.$RResO["Fecha_Alta"].'</td>
                                        <td>'.$RResO["Factura"].'</td>
                                        <td>';if($RResO["Nota_Debito_Factura_Proveedor"] == NULL){echo 'N/A';}else{echo $RResO["Nota_Debito_Factura_Proveedor"];} echo '</td>
                                        <td>';if($RResO["Fecha_Nota_Debito_Fact_Proveedor"] == NULL){echo 'N/A';}else{echo $RResO["Fecha_Nota_Debito_Fact_Proveedor"];} echo '</td>
                                        <td>'.$RResO["Fecha_Transaccion"].'</td>
                                        <td style="text-align: right">$ '.number_format($RResO["Monto_Ingreso"], 2).'</td>
                                        <td style="text-align: right">$ '.number_format($RResO["Monto_Egreso"], 2).'</td>
                                    </tr>';
                            }

                            
                        ?>
                        <!--<tr v-for="operacion in operaciones" :key="operacion.ID_Operacion">
                            <td class="tabla-celda center-align">
                                <i v-if="operacion.Aprobacion == 1" class="small material-icons" style="color: green;">check_circle</i>
                                <a v-if="operacion.Aprobacion == 0" class="modal-trigger " href="#modal-cargar-factura"></a>
                            </td>
                            <td>{{ operacion.ID_Operacion }}</td>
                            <td>{{ operacion.Proveedor }}</td>
                            <td>{{ operacion.Fecha_Factura }}</td>
                            <td>{{ operacion.Fecha_Alta }}</td>
                            <td>{{ operacion.Factura }}</td>
                            <td>{{ operacion.Nota_Debito_Factura_Proveedor !== null ? operacion.Nota_Debito_Factura_Proveedor : 'N/A' }}</td>
                            <td>{{ operacion.Nota_Debito_Factura_Proveedor !== null ? operacion.Nota_Debito_Factura_Proveedor : 'N/A' }}</td>
                            <td>{{ operacion.Fecha_Transaccion }}</td>
                            <td>{{ operacion.Estatus }}</td>
                            <td>$ {{ operacion.Monto_Ingreso }}</td>
                            <td>$ {{ operacion.Monto_Egreso }}</td>
                        </tr>-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div id="modal-factura" class="modal">
        <div class="modal-content">
            <h5>Carga tus facturas</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6 class="p-3">Carga tu CFDI (factura) en formato .xml o un archivo .zip con multiples CFDI's</h6>
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="row">

                            <div class="row">
                                <div class="col l9 input-border">
                                    <input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName" />
                                    <label for="invoiceDisabled">Un archivo en xml o múltiples en .zip</label>
                                </div>
                                <div class="col l3 center-align p-5">
                                    <label for="invoiceUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                    <input @change="checkFormatInvoice" name="invoiceUpload" ref="invoiceUpload" id="invoiceUpload" type="file" accept="application/xml" maxFileSize="5242880" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l12 d-flex">
                                    <div class="p-5">
                                        <input class="p-5" type="checkbox" v-model="checkboxChecked" required>
                                    </div>
                                    <p class="text-modal">
                                        El Proveedor acepta y otorga su consentimiento en este momento para que una vez recibido el pago por la presente factura, Solve descuente y transfiere de manera automática a nombre y cuenta del Proveedor, el monto debido por el Proveedor en relación con dicha factura en favor del Cliente.
                                        Los términos utilizados en mayúscula tendrán el significado que se le atribuye dicho término en los <a href="terminosycondiciones">Términos y Condiciones</a>.
                                    </p><br>
                                </div>
                            </div>
                            <div class="col l12 center-align">
                                <a class="modal-close button-gray" style="color: #fff; color:hover: #">Cancelar</a>
                                &nbsp;
                                <button class="button-blue modal-close" type="button" name="action" @click="uploadFile">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div id="modal-operacion" class="modal">
        <div class="modal-content" v-if='solicitud == 0'>
            <h5>Crear Operación</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6 class="p-3">Carga tu CFDI (Nota) relacionada a una factura o selecciona una factura</h6>
                    <form method="post" action="<?php echo base_url('facturas/carga'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l3 input-border">
                                <input type="text" name="operationDisabled" id="operationDisabled" disabled v-model="operationUploadName">
                                <label for="operationDisabled">Tu CFDI (Nota), archivo XML</label>
                            </div>
                            <div class="col l4 left-align p-5">
                                <label for="operationUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                <input @change="checkFormatOperation" name="operationUpload" ref="operationUpload" id="operationUpload" type="file" accept="application/xml" maxFileSize="5242880" />
                            </div>
                            <div class="col l5 input-border select-white">
                                <input type="text" name="providerDisabled" id="providerDisabled" disabled v-model="providerUploadName">
                                <label for="providerDisabled">Cliente</label>
                            </div>
                            <div>
                                <table class="striped">
                                    <thead>
                                        <tr>
                                            <!-- <th>Crear Operación</th> -->
                                            <th>Proveedor</th>
                                            <th>Factura</th>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Alta</th>
                                            <th>Fecha Transacción</th>
                                            <th>Estatus</th>
                                            <th>Subtotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="providerUploadName == 'Frontier'" class="visible-table striped">
                                        <tr v-if="facturas.length > 0" :key="facturas[0].o_idPersona">
                                            <!-- <td class="tabla-celda center-align">
                                                <i v-if="facturas[0].o_Activo == 1" class="small material-icons" style="color: green;">check_circle</i>
                                                <a v-if="facturas[0].o_Activo == 0" class="modal-trigger" href="#modal-operacion-unico">Crear Operación</a>
                                            </td> -->
                                            <td><a href="#">Frontier</a></td>
                                            <td>{{facturas[0].o_NumOperacion}}</td>
                                            <td>{{modificarFecha(facturas[0].o_FechaEmision)}}</td>
                                            <td>{{modificarFecha(facturas[0].o_FechaUpload)}}</td>
                                            <td>{{modificarFecha(facturas[0].o_FechaEmision)}}</td>
                                            <td>
                                                <p v-if="facturas[0].o_Activo == 1">Pendiente</p>
                                                <p v-if="facturas[0].o_Activo == 0">Cargada</p>
                                            </td>
                                            <td>${{facturas[0].o_SubTotal}}</td>
                                            <td>${{facturas[0].o_Impuesto}}</td>
                                            <td>${{facturas[0].o_Total}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><br>
                            <div class="col l8">
                                <!-- <a @click="cambiarSolicitud(1)" class="button-blue" v-if="providerUploadName == 'Frontier'">Cargar Factura</a> -->
                            </div>
                            <div class="col l4 center-align">
                                <a class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                &nbsp;
                                <button onclick="M.toast({html: 'Operacion creada con exito'})" class="button-blue" type="submit" name="action">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-content" v-if='solicitud == 1'>
            <h5>Solicitar Factura</h5>
            <div class="card esquinasRedondas">
                <form @submit.prevent='cambiarSolicitud(2)' action="" method="post">
                    <div class="card-content ">
                        <div class="row">
                            <div class="col l12">
                                <label style="top: 0!important;" for="descripcion">Mensaje para Solicitar</label>
                                <textarea style="min-height: 30vh;" id="descripcion" name="descripcion" class="materialize-textarea validate" required></textarea>

                            </div>
                            <div class="col l12 d-flex justify-content-flex-end">
                                <a @click='cambiarSolicitud(0)' class="button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                &nbsp;
                                <button class="button-blue" type="submit">Solicitar</button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </div>
        <div class="modal-content" v-if='solicitud == 2'>
            <h5>&nbsp;</h5>
            <div class="card esquinasRedondas   center-align">
                <div class="row">
                    <div class="col l12 ">

                        <h5 style="margin: 120px auto;">Solicitud hecha correctamente</h5>

                        <a @click='cambiarSolicitud(0)' class="modal-close button-gray" style="position:relative; top:-30px; color:#fff; color:hover:#">Salir</a>
                    </div>
                </div>

            </div>
        </div>
    </div>






    <div id="modal-operacion-unico" class="modal">
        <div class="modal-content">
            <h5>Crear Operación</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6 class="p-3">Carga tu CFDI (Nota) y selecciona una factura del cliente</h6>
                    <form method="post" action="<?php echo base_url('facturas/carga'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l3 input-border">
                                <input type="text" placeholder="92387278.xml">
                                <label for="invoiceDisabled">Tu archivo (Nota) .xml</label>
                            </div>
                            <div class="col l4 left-align p-5">
                            </div>
                            <div class="col l5 input-border select-white">
                                <input type="text" placeholder="Frontier">
                                <label for="providerDisabled">Cliente</label>
                            </div>
                            <div>
                                <table class="striped">
                                    <thead>
                                        <tr>
                                            <!-- <th>Crear Operación</th> -->
                                            <th>Proveedor</th>
                                            <th>Factura</th>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Alta</th>
                                            <th>Fecha Transacción</th>
                                            <th>Estatus</th>
                                            <th>Subtotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="striped">
                                        <!--<tr v-if="facturas.length > 0" :key="facturas[0].o_idPersona">
                                            <td class="tabla-celda center-align">
                                                <i v-if="facturas[0].o_Activo == 1" class="small material-icons" style="color: green;">check_circle</i>
                                                <a v-if="facturas[0].o_Activo == 0" class="modal-trigger" href="#modal-operacion-unico">Crear Operación</a>
                                            </td>
                                            <td><a href="#">Frontier</a></td>
                                            <td>{{facturas[0].o_NumOperacion}}</td>
                                            <td>{{modificarFecha(facturas[0].o_FechaEmision)}}</td>
                                            <td>{{modificarFecha(facturas[0].o_FechaUpload)}}</td>
                                            <td>{{modificarFecha(facturas[0].o_FechaEmision)}}</td>
                                            <td>
                                                <p v-if="facturas[0].o_Activo == 1">Pendiente</p>
                                                <p v-if="facturas[0].o_Activo == 0">Cargada</p>
                                            </td>
                                            <td>${{facturas[0].o_SubTotal}}</td>
                                            <td>${{facturas[0].o_Impuesto}}</td>
                                            <td>${{facturas[0].o_Total}}</td>
                                        </tr>-->
                                    </tbody>
                                </table>
                            </div><br>
                            <div class="col l8">
                                <a onclick="M.toast({html: 'Se ha solicitado la factura'})" class="button-blue modal-close" v-if="providerUploadName != ''">Canceler</a>
                            </div>
                            <div class="col l4 center-align">
                                <a class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                &nbsp;
                                <button class="button-blue" type="submit" name="action">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div id="modal-cargar-factura" class="modal">
        <div class="modal-content">
            <h5>Porfavor, autoriza la transacción</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="row">

                            <div class="row">
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="Frontier" disabled/>
                                    <label for="invoiceDisabled">Provedor</label>
                                </div>
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="XYZ832HS" disabled/>
                                    <label for="invoiceDisabled">Factura</label>
                                </div>
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="XYZ832HS" disabled/>
                                    <label for="invoiceDisabled">Nota de debito</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="TRA10035904" disabled/>
                                    <label for="invoiceDisabled">ID Transaccion</label>
                                </div>
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="$ 21,576.00" disabled/>
                                    <label for="invoiceDisabled">Monto Factura</label>
                                </div>
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="$10,501.00" disabled/>
                                    <label for="invoiceDisabled">Monto Nota de Débito (ingreso):</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l4 input-border">
                                <input type="date" id="start" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
                                <label for="start">Inicio:</label>
                                </div>
                                <div class="col l4 input-border P-5">
                                    <input type="text" placeholder="123456789098745612" disabled/>
                                    <label for="invoiceDisabled">Cuenta CLABE del proveedor</label>
                                </div>
                            </div>
                            <div class="col l12">
                                <div class="col l8">
                                    <a class="button-gray modal-close">Cancelar</a>
                                </div>
                                <div class="col l4 center-align">
                                    <a onclick="M.toast({html: 'Se ha cancelado'})" class="button-white modal-close">Rechazar</a>
                                    &nbsp;
                                    <button onclick="M.toast({html: 'Se ha autorizado'})" class="button-blue modal-close">Siguiente</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<style>
    /* main styles */

    .text-modal {
        font-size: 13px;
    }

    .modal {
        max-height: 83% !important;
        width: 80% !important;
    }

    .input-border label {
        color: black;
        top: -75px;
        position: relative;
        font-weight: bold !important;
    }

    /* Fix show checkbox and radio buttons*/

    [type="checkbox"]:not(:checked),
    [type="checkbox"]:checked {
        opacity: 1;
        position: relative;
        pointer-events: auto;
    }

    [type="radio"]:not(:checked),
    [type="radio"]:checked {
        opacity: 1;
        position: relative;
        pointer-events: auto;
    }

    /* Fix button selected but all class selected afect */

    .selected {
        background-color: black !important;
        color: white !important;
        height: 50px;
        border: 2px solid black !important;
        border-radius: 10px;
    }
</style>

<script>
    const app = Vue.createApp({
        setup() {
            const invoiceUploadName = Vue.ref('');
            const operationUploadName = Vue.ref('');
            const providerUploadName = Vue.ref('');
            const selectedButton = Vue.ref('Operaciones');
            const checkboxChecked = Vue.ref(false);
            const operaciones = Vue.ref([]);
            const facturas = Vue.ref([]); 
            const solicitud = Vue.ref(0);


            const checkFormatInvoice = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    invoiceUploadName.value = fileInput.files[0].name;
                } else {
                    invoiceUploadName.value = '';
                }
            };

            const uploadFile = async () => {
                if (selectedButton.value === 'Facturas' && checkboxChecked.value) {
                    const fileInput = document.getElementById('invoiceUpload');
                    const formData = new FormData();
                    formData.append('user', 6);
                    formData.append('invoiceUpload', fileInput.files[0]);

                    const response = await fetch("<?= base_url('facturas/subida') ?>", {
                        method: 'POST',
                        body: formData,
                        redirect: 'follow'
                    });

                    if (response.ok) {
                        getFacturas();
                        M.toast({html: 'Se ha subido la factura'});
                    } 
                } else {
                    alert('Ingresa una factura y acepta los terminos');
                }
            };

            const checkFormatOperation = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    operationUploadName.value = fileInput.files[0].name;
                    providerUploadName.value = 'Frontier';
                } else {
                    operationUploadName.value = '';
                    providerUploadName.value = '';
                }
            };

            const uploadOperation = async () => {
                if (selectedButton.value === 'operation') {
                    const fileInput = document.getElementById('operationUpload');
                    const formData = new FormData();
                    formData.append('user', 6);
                    formData.append('operationUpload', fileInput.files[0]);

                    const response = await fetch("<?= base_url('facturas/subida') ?>", {
                        method: 'POST',
                        body: formData,
                        redirect: 'follow'
                    });

                    if (response.ok) {
                        // console.log('se subió');
                        getOperations();
                    } else {
                        console.error('Error');
                    }
                } else {
                    alert('Ingresa una factura y acepta los terminos')
                }
            };

            const getOperations = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?= base_url("facturas/tablaOperaciones") ?>", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        operaciones.value = result.operaciones;
                        operaciones.value.reverse();
                        // console.log(operaciones.value);
                    })
                    .catch(error => {
                        //console.log('error', error)
                    });
            };

            const getFacturas = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?= base_url("facturas/tablaFacturas")?>", requestOptions)
                .then(response => response.json())
                .then(result => { facturas.value = result.facturas; facturas.value.reverse();;})
                .catch(error => console.log('error', error));
            };

            const modificarFecha = (fecha) => {
                fecha = fecha.split(' ');

                fecha[1] = '';
                fecha = fecha.join(' ');
                return fecha;
            };

            const selectButton = (buttonName) => {
                if (selectedButton.value == buttonName) {
                    selectedButton.value = null;
                } else {
                    selectedButton.value = buttonName;
                }
            };

            Vue.onMounted(
                () => {
                    getOperations();
                    getFacturas();
                }
            )
            const cambiarSolicitud = (valor) => {
                solicitud.value = valor;
                // console.log(solicitud);
            };
            return {
                invoiceUploadName,
                operationUploadName,
                providerUploadName,
                selectedButton,
                checkFormatInvoice,
                checkFormatOperation,
                checkboxChecked,
                uploadFile,
                modificarFecha,
                selectButton,
                operaciones,
                solicitud,
                facturas,
                cambiarSolicitud
            };
        }
    });
</script>