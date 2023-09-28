<div class="p-5" id="app">
    <div class="row">
        <p class="px-3">Periodo:</p>
        <div class="col l3">
            <input type="date" id="start" name="trip-start" value="2018-07-22" min="2018-01-01" max="2018-12-31" />
            <label for="start">Inicio:</label>
        </div>
        <div class="col l3">
            <input type="date" id="fin" name="trip-start" value="2018-07-22" min="2018-01-01" max="2018-12-31" />
            <label for="fin">Fin:</label>
        </div>
        <div class="col l6 right-align p-5">
            <a class="modal-trigger button-blue" href="#modal-factura">Añadir Facturas</a>
        </div>
    </div>
    <div class="card esquinasRedondas">
        <div class="card-content">
            <form class="input-border" action="#" method="post" style="display: flex;">
                <h6 class="p-4">Facturas</h6>
                <input type="search" placeholder="Buscar" >
            </form>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th class="tabla-celda" >Fecha de Emisión</th>
                            <th class="tabla-celda" >Fecha de Actualización</th>
                            <th class="tabla-celda" >Total</th>
                            <th class="tabla-celda" >Impuestos</th>
                            <th class="tabla-celda" >Subtotal</th>
                            <th class="tabla-celda" >Tipo de Documento</th>
                            <th class="tabla-celda" >Estatus</th>
                            <th class="tabla-celda" >UUID</th>
                            <th class="tabla-celda" >Alias Cliente</th>
                            <th class="tabla-celda" >RFC Cliente</th>
                            <th class="tabla-celda" >Alias Proveedor</th>
                            <th class="tabla-celda" >RFC Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($facturas as $factura) : ?>
                            <tr>
                                <td class="tabla-celda"><?= $factura->FechaEmision ?></td>
                                <td class="tabla-celda"><?= $factura->FechaUpdate ?></td>
                                <td class="tabla-celda"><?= $factura->Total ?></td>
                                <td class="tabla-celda"><?= $factura->Impuestos ?></td>
                                <td class="tabla-celda"><?= $factura->Subtotal ?></td>
                                <td class="tabla-celda"><?= $factura->TipoDocumento ?></td>
                                <td class="tabla-celda"><?= $factura->Estatus?></td>
                                <td class="tabla-celda"><?= $factura->UUID ?></td>
                                <td class="tabla-celda"><?= $factura->AliasCliente ?></td>
                                <td class="tabla-celda"><?= $factura->RFCCliente ?></td>
                                <!-- <td><?= $factura->AliasProvedor ?></td>
                                <td><?= $factura->RFCProveedor ?></td> -->
                            </tr>
                        <?php endforeach; ?>
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
                    <h6 class="p-3">Carga tu factura en formato .xml o múltiples facturas en un archivo .zip</h6>
                    <form method="post" action="<?php echo base_url('xml/factura'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l9 input-border">
                                <input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName">
                                <label for="invoiceDisabled">Una factura en xml o múltiples en .zip</label>
                            </div>
                            <div class="col l3 center-align p-5"> 
                                <label for="invoiceUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                <input @change="checkFormatInvoice" name="invoiceUpload" ref="invoiceUpload" id="invoiceUpload" type="file" accept="application/xml" maxFileSize="5242880" required />
                            </div>
                            <div class="col l6">    
                                <label>
                                    <input class="filled-in" type="checkbox" />
                                    <span><p class= "text-modal">Transferir monto de la factura a mi cuenta bancaria externa predeterminada. Administrar cuentas <br><br></p></span>
                                </label>                             
                            </div>
                            <div class="col l6">    
                                <label>
                                    <input class="filled-in" type="checkbox" />
                                    <span><p class= "text-modal">Transferir monto de la factura a mi cuenta de Compensa Pay</p></span>
                                </label>                             
                            </div><br>
                            <div class="col l12 center-align">
                                <a href="#!" class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                 &nbsp;
                                <button class="button-blue" type="submit" name="action">Siguiente</button><br><br>
                                <p class="text-modal">*Al dar clic en "crear operación", el proveedor acepta que al concluir la transacción por el pago de la factura, se descontará y enviará al cliente de forma automática el monto de la nota de débito o factura del cliente, de acuerdo con lo estipulado en nuestros términos y condiciones</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a class="waves-effect waves-light btn modal-trigger" href="#modal-notas" style="display:none;">Añadir Notas de credito</a>
    <div id="modal-notas" class="modal">
        <div class="modal-content">
            <h5 >Carga tus Notas de credito</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h2 class="card-title">Nota de credito</h2>
                    <form method="post" action="<?php echo base_url('xml/notaCredito'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l9 input-border">
                                <input type="text" name="creditNoteDisabled" id="creditNoteDisabled" disabled v-model="creditNoteUploadName">
                                <label for="creditNoteDisabled">Comprobante de Nota</label>
                            </div>
                            <div class="col l3 center-align p-5">
                                <label for="creditNoteUpload" class="custom-file-upload">Agregar</label>
                                <input @change="checkFormatNote" name="creditNoteUpload" ref="creditNoteUpload" id="creditNoteUpload" type="file" accept="application/Nota" maxFileSize="5242880" required />
                            </div>
                            <div class="col l12 center-align">
                                <button class="button-white"><a href="#!" class="modal-close waves-effect button-black" style="color:#444;">Cancelar</a></button>
                                <button class="button-white" type="submit" name="action">Siguiente</button><br><br>
                                <p class="text-modal">*Al dar clic en "crear operación", el proveedor acepta que al concluir la transacción por el pago de la factura, se descontará y enviará al cliente de forma automática el monto de la nota de débito o factura del cliente, de acuerdo con lo estipulado en nuestros términos y condiciones</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<style>
    .text-modal{
        font-size: 10px;
    }
    .modal {
        max-height: 85% !important;
        width: 70% !important;
    }

    .input-border input[type=search] {
        border: 3px solid #ddd;
        border-radius: 30px !important;
        padding: 0 8px !important;
        margin: 15px 0 10px 0 !important;
        height: 35px !important;
        width: 180px !important;
    }

    .input-border input[type=search]:focus{
        border-color: #444 !important;
        border-bottom: 1px solid #444 !important;
        box-shadow: 0 1px 0 0 #444 !important;
    }

    .input-border label {
        color: black;
        top: -75px;
        position: relative;
        font-weight: bold !important;
    }

    .input-border input[type=search]:focus + label {
        color: #111 !important;
    }
    .tabla-celda {
        min-width: 100px;
        max-width: 150px; 
        padding: 5px; 
        text-align: center; 
        font-size: 13px;
        overflow: hidden;
        white-space: normal; /* Permite que el texto se divida en dos líneas si es necesario */
        text-overflow: ellipsis;
    }
</style>

<script>
    const app = Vue.createApp({
        setup() {
            const invoiceUploadName = Vue.ref('');
            const creditNoteUploadName = Vue.ref('');

            const checkFormatInvoice = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    invoiceUploadName.value = fileInput.files[0].name;
                } else {
                    invoiceUploadName.value = '';
                }
            };

            const checkFormatNote = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    creditNoteUploadName.value = fileInput.files[0].name;
                } else {
                    creditNoteUploadName.value = '';
                }
            };

            return {
                invoiceUploadName,
                creditNoteUploadName,
                checkFormatInvoice,
                checkFormatNote
            };
        }
    });
</script>
