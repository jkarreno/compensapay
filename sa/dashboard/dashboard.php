<?php
    include ('../config/conexion.php');
    include ('../empresas/f_empresas.php');
    include ('../usuarios/f_usuarios.php');

    $fechai = $_POST["fechai"];
    $fechaf = $_POST["fechaf"];
?>
<div class="container">    
    <div class="row">
        <div class="col s3">
            <h5><strong>Periodo</strong></h5>
            <input type="date" id="fechai" name="fechai" value="<?php echo $fechai;?>" style="margin-bottom: 0px;" onchange="dashboard(this.value, document.getElementById('fechaf').value)">
            <h6>Desde</h6>
        </div>
        <div class="col s3">
            <h5>&nbsp;</h5>
            <input type="date" id="fechaf" name="fechaf" value="<?php echo $fechaf;?>" style="margin-bottom: 0px;" onchange="dashboard(document.getElementById('fechai').value, this.value)">
            <h6>Hasta</h6>
        </div>
        <div class="col s6"></div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s4">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Alertas</strong><i class="material-icons right">warning</i></span>
                    <p>23 Urgentes</p>
                    <p>12 Medias</p>
                    <p>1 Bjas</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;">Administrar</h6>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Costos de operación</strong><i class="material-icons right">monetization_on</i></span>
                    <p>$ - 169,831.42</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;">Administrar</h6>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Ingresos suscripción</strong><i class="fa-solid fa-cash-register right"></i></span>
                    <p>$ 221,324.52</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;">Administrar</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row section">
        <div class="col s4">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Soporte</strong><i class="material-icons right">headset_mic</i></span>
                    <p>19 Tkts Abiertos</p>
                    <p>12 Tkts En Proceso</p>
                    <p>10 Tkts Cerrados</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;">Administrar</h6>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Cuentas Empresas</strong><i class="material-icons right">business</i></span>
                    <p><?php echo empresas($fechai, $fechaf, 'T');?> Total</p>
                    <p><?php echo empresas($fechai, $fechaf, 'A');?> Activas</p>
                    <p><?php echo empresas($fechai, $fechaf, 'N');?> Nuevas</p>
                    <p><?php echo empresas($fechai, $fechaf, 'C');?> Cancelada</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;"><a href="#" onclick="empresas(document.getElementById('fechai').value, document.getElementById('fechaf').value)">Administrar</a></h6>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Cuentas Usuarios</strong><i class="material-icons right">people</i></span>
                    <p><?php echo usuarios($fechai, $fechaf, 'T');?> Total</p>
                    <p><?php echo usuarios($fechai, $fechaf, 'A');?> Activos</p>
                    <p><?php echo usuarios($fechai, $fechaf, 'N');?> Nuevos</p>
                    <p><?php echo usuarios($fechai, $fechaf, 'C');?> Cancelados</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;"><a href="#" onclick="usuarios(document.getElementById('fechai').value, document.getElementById('fechaf').value)">Administrar</a></h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row section">
        <div class="col s4">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Operaciones</strong><i class="material-icons right">swap_horiz</i></span>
                    <p>19 Tkts Abiertos</p>
                    <p>12 Tkts En Proceso</p>
                    <p>10 Tkts Cerrados</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;">Administrar</h6>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Logs</strong><i class="fa-solid fa-clipboard-list right"></i></span>
                    <p>23 Activass</p>
                    <p>12 Nuevas</p>
                    <p>1 Cancelada</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;">Administrar</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s12">
            <h5><strong>Alertas recientes</strong></h5>
            <table class="striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Prioridad</th>
                        <th>Empresa</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>