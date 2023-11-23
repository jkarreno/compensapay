<div class="container section">
    <div class="row section black" style="border-radius: 15px">
        <div class="col s3 white-text">
            <h5><strong>Oper. Totales</strong></h5>
            <h6><?php echo $dashboard["TotalOperaciones"][0]["TotOper"];?></h6>
        </div>
        <div class="col s3 white-text">
            <h5 style="margin: 1.0933333333rem 0 -1rem 0;"><strong>Total por Cobrar</strong></h5>
            <p style="font-size: 12px">(Monto Facturas)</p>
            <h6>$ <?php 
                    $Stpoc = $dashboard["TotalPorCobrar"]["facturas"][0]["TTotal"] + $dashboard["TotalPorCobrar"]["notas"][0]["TTotal"];
                    echo number_format($Stpoc,2);
            ?></h6>
        </div>
        <div class="col s3 white-text">
        <h5 style="margin: 1.0933333333rem 0 -1rem 0;"><strong>Total por pagar</strong></h5>
        <p style="font-size: 12px">(Monto Facturas)</p>
            <h6>$ <?php 
            $Stpp = $dashboard["TotalPorPagar"]["facturas"][0]["TTotal"] + $dashboard["TotalPorPagar"]["notas"][0]["TTotal"];
            echo number_format($Stpp, 2);?></h6>
        </div>
        <div class="col s3 white-text">
            <h5><strong>Diferencia Total</strong></h5>
            <h6>$ <?php echo number_format(($Stpoc - $Stpp), 2);?></h6>
        </div>
    </div>
</div>
<div class="container">    
    <div class="row">
        <div class="col s3">
            <h5><strong>Periodo</strong></h5>
            <input type="date" value="<?php echo date("Y-m").'-01';?>">
            <h6>Desde</h6>
        </div>
        <div class="col s3">
            <h5>&nbsp;</h5>
            <input type="date" value="<?php echo date("Y-m-d");?>">
            <h6>Hasta</h6>
        </div>
        <div class="col s6">
            <h5>&nbsp;</h5>
            <select>
                <option value="0">Todos los proveedores</option>
                <?php
                if(is_array($dashboard["Proveedores"]))
                {
                    foreach ($dashboard["Proveedores"] as $proveedor){
                        echo '<option value="'.$proveedor["Id"].'">'.$proveedor["Proveedor"].'</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Operaciones</strong><i class="material-icons right" style="rotate: 90deg;">import_export</i></span>
                    <p><?php echo $dashboard["OperacionesMes"];?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">-1.22%</h6>-->
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Ingresos</strong><i class="material-icons right">arrow_downward</i></span>
                    <p>$ <?php echo number_format($dashboard["IngresosMes"], 2);?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">+2.031</h6>-->
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Egresos</strong><i class="material-icons right">arrow_upward</i></span>
                    <p>$ <?php echo number_format($dashboard["EgresosMes"], 2);?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">+$2.201</h6>-->
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Diferencia</strong><i class="material-icons right">attach_money</i></span>
                    <p>$ <?php echo number_format(($dashboard["IngresosMes"] - $dashboard["EgresosMes"]), 2);?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">+3.392</h6>-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s8">
            <div class="card" style="border-radius: 15px; height:600px;">
                <div class="card-content">
                    <span class="card-title"><strong>Ingresos vs. Egresos</strong></span>
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card" style="border-radius: 15px; height:600px;">
                <div class="card-content">
                    <span class="card-title"><strong>Proveedores Principales</strong></span>
                    <div>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s12">
         <h5><strong>Operaciones recientes</strong></h5>
            <table class="striped">
            <thead>
      <tr>
        <th>Id Operación</th>
        <th>Proveedor</th>
        <th>Fecha</th>
        <th>Factura</th>
        <th>Nota de Débito</th>
        <th>Estatus</th>
        <th class="right-align">Monto Ingreso</th>
        <th class="right-align">Monto Egreso</th>
      </tr>
    </thead>
    <tbody>
      <!-- Fila 1 -->
      <tr>
        <td>01864921</td>
        <td>Proveedor A (Acero)</td>
        <td>2023-09-01</td>
        <td>Factura001</td>
        <td>Debito001</td>
        <td>Aprobado</td>
        <td class="right-align"> $1,500.50</td>
        <td class="right-align"> $1,200.25</td>
      </tr>
      <!-- Fila 2 -->
      <tr>
        <td>1682372</td>
        <td>Proveedor B (Otro)</td>
        <td>2023-09-02</td>
        <td>Factura002</td>
        <td>Debito002</td>
        <td>Pendiente</td>
        <td class="right-align"> $800.75</td>
        <td class="right-align"> $500.25</td>
      </tr>
      <!-- Filas 3 a 10 (datos aleatorios) -->
      <!-- Puedes generar datos aleatorios con un lenguaje de programación como Python o JavaScript -->
      <!-- En este ejemplo, los datos son completamente ficticios -->
      <!-- Puedes copiar y pegar estas filas según sea necesario -->

      <!-- Fila 3 -->
      <tr>
        <td>4656836484</td>
        <td>Proveedor C (Acero)</td>
        <td>2023-09-03</td>
        <td>Factura003</td>
        <td>Debito003</td>
        <td>Aprobado</td>
        <td class="right-align"> $2,300.25</td>
        <td class="right-align"> $1,800.50</td>
      </tr>

      <!-- Fila 4 -->
      <tr>
        <td>45647527</td>
        <td>Proveedor D (Otro)</td>
        <td>2023-09-04</td>
        <td>Factura004</td>
        <td>Debito004</td>
        <td>Pendiente</td>
        <td class="right-align"> $1,200.50</td>
        <td class="right-align"> $900.75</td>
      </tr>

      <!-- Fila 5 -->
      <tr>
        <td>54867915</td>
        <td>Proveedor E (Acero)</td>
        <td>2023-09-05</td>
        <td>Factura005</td>
        <td>Debito005</td>
        <td>Aprobado</td>
        <td class="right-align"> $900.25</td>
        <td class="right-align"> $600.50</td>
      </tr>

      <!-- Fila 6 -->
      <tr>
        <td>48967913</td>
        <td>Proveedor F (Otro)</td>
        <td>2023-09-06</td>
        <td>Factura006</td>
        <td>Debito006</td>
        <td>Pendiente</td>
        <td class="right-align"> $1,600.75</td>
        <td class="right-align"> $1,200.25</td>
      </tr>

      <!-- Fila 7 -->
      <tr>
        <td>718734861</td>
        <td>Proveedor G (Acero)</td>
        <td>2023-09-07</td>
        <td>Factura007</td>
        <td>Debito007</td>
        <td>Aprobado</td>
        <td class="right-align"> $2,100.50</td>
        <td class="right-align"> $1,600.75</td>
      </tr>

      <!-- Fila 8 -->
      <tr>
        <td>1568368</td>
        <td>Proveedor H (Otro)</td>
        <td>2023-09-08</td>
        <td>Factura008</td>
        <td>Debito008</td>
        <td>Pendiente</td>
        <td class="right-align"> $700.25</td>
        <td class="right-align"> $400.50</td>
      </tr>

      <!-- Fila 9 -->
      <tr>
        <td>91837213</td>
        <td>Proveedor I (Acero)</td>
        <td>2023-09-09</td>
        <td>Factura009</td>
        <td>Debito009</td>
        <td>Aprobado</td>
        <td class="right-align"> $1,400.50</td>
        <td class="right-align"> $1,100.75</td>
      </tr>

      <!-- Fila 10 -->
      <tr>
        <td>14837690</td>
        <td>Proveedor J (Otro)</td>
        <td>2023-09-10</td>
        <td>Factura010</td>
        <td>Debito010</td>
        <td>Pendiente</td>
        <td class="right-align"> $1,900.75</td>
        <td class="right-align"> $1,400.25</td>
      </tr>

    </tbody>
  </table>
        </div>
    </div>
</div>

<style>
    
    .container {
  width: 90%;
  max-width:initial;
}


</style>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');
  const ctx2 = document.getElementById('myChart2');

  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $dashboard["GraficoMovimientos"]["meses"];?>],
            datasets: [{
            label: 'Ingresos',
            data: [<?php echo $dashboard["GraficoMovimientos"]["Ingresos"];?>],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgb(75, 192, 192)',
            tension: 0.1
            }, 
            {
            label: 'Egresos',
            data: [<?php echo $dashboard["GraficoMovimientos"]["Egresos"];?>],
            fill: false,
            borderColor: 'rgb(194, 0, 5)',
            backgroundColor: 'rgb(194, 0, 5)',
            tension: 0.1
            }
        ]}
});

  var myLineChart2 = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Aceros Plus', 'Disilex', 'Acerux'],
            datasets: [{
            label: 'Ingresos',
            data: [65, 59, 80],
            fill: false,
            borderColor: ['rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
            ],
            backgroundColor: ['rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
            }
        ]}
});

</script>