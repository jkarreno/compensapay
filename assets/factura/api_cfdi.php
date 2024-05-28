<?php
	require ( 'fpdf/fpdf.php' );
	require ( 'xml2array.php' );
	require ( 'apiConnection.php' );
	//LIBRERIA QR
	include ( "phpqrcode/qrlib.php" );
	$PNG_TEMP_DIR = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
	$PNG_WEB_DIR = 'temp/';
	if ( isset( $_POST[ "uuid" ] ) || isset( $_POST[ "environment" ] ) || isset( $_POST[ "category" ] ) ) {
		$uuid = $_POST[ "uuid" ];
		$env = $_POST[ "environment" ];
		$cat = $_POST[ "category" ];
	} else if ( isset( $_GET[ "uuid" ] ) || isset( $_GET[ "environment" ] ) || isset( $_GET[ "category" ] ) ) {
		$uuid = $_GET[ "uuid" ];
		$env = $_GET[ "environment" ];
		$cat = $_GET[ "category" ];
	}
	$data = [
		'environment' => $env,
		'uuid' => $uuid,
		'category' => $cat, ];
	$ResFactura = json_decode ( getRequest ( $data, 'getCfdiInfo?', $env ), TRUE );
//	var_dump ($res);
	$xml = xml2array ( $ResFactura[ "xml_document" ] );
	$filename = $PNG_TEMP_DIR . $ResFactura[ "uuid" ] . '.png';
	QRcode::png ( '?re=' . $xml[ "cfdi:Comprobante" ][ "cfdi:Emisor_attr" ][ "Rfc" ] . '&rr=' . $xml[ "cfdi:Comprobante" ][ "cfdi:Receptor_attr" ][ "Rfc" ] . '&tt=' .
		$ResFactura[ "total" ] . '0000&id=' . $xml[ "cfdi:Comprobante" ][ "cfdi:Complemento" ][ "tfd:TimbreFiscalDigital_attr" ][ "UUID" ], $filename, 'H', '4', 2 );
	$pdf = new FPDF();
	$pdf->SetAutoPageBreak ( FALSE );
	$pdf->AddPage ();
	$y_axis_initial = 25;
	//nombre de la empresa
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', 'B', 9 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 4 );
	$pdf->SetX ( 55 );
	$pdf->Cell ( 120, 4, utf8_decode ( strtoupper ( $xml[ "cfdi:Comprobante" ][ "cfdi:Emisor_attr" ][ "Nombre" ] ) ), 0, 0, 'L', 1 );
	//RFC del emisor
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 9 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 8 );
	$pdf->SetX ( 55 );
	$pdf->Cell ( 120, 4, 'RFC.: ' . $xml[ "cfdi:Comprobante" ][ "cfdi:Emisor_attr" ][ "Rfc" ], 0, 0, 'L', 1 );
	//DATOS DE LA FACTURA
	$pdf->SetFillColor ( 204, 204, 204 );
	$pdf->SetFont ( 'Arial', 'B', 10 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 6 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, 'Tipo de Comprobante: I Ingreso', 1, 0, 'C', 1 );
	$pdf->SetFillColor ( 204, 204, 204 );
	$pdf->SetFont ( 'Arial', 'B', 10 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 14 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, 'Folio Fiscal', 1, 0, 'C', 1 );
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 18 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, strtoupper ( $xml[ "cfdi:Comprobante" ][ "cfdi:Complemento" ][ "tfd:TimbreFiscalDigital_attr" ][ "UUID" ] ), 1, 0, 'C', 1 );
	//certificado
	$pdf->SetFillColor ( 204, 204, 204 );
	$pdf->SetFont ( 'Arial', 'B', 10 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 22 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, 'Certificado del Emisor', 1, 0, 'C', 1 );
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 26 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, $xml[ "cfdi:Comprobante_attr" ][ "NoCertificado" ], 1, 0, 'C', 1 );
	//certificado SAT
	$pdf->SetFillColor ( 204, 204, 204 );
	$pdf->SetFont ( 'Arial', 'B', 10 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 30 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, 'Certificado del SAT', 1, 0, 'C', 1 );
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 34 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, $xml[ "cfdi:Comprobante" ][ "cfdi:Complemento" ][ "tfd:TimbreFiscalDigital_attr" ][ "NoCertificadoSAT" ], 1, 0, 'C', 1 );
	//Fecha y Hora de Certificación
	$pdf->SetFillColor ( 204, 204, 204 );
	$pdf->SetFont ( 'Arial', 'B', 10 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 38 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, utf8_decode ( 'Fecha y Hora de Certificación' ), 1, 0, 'C', 1 );
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 42 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, $xml[ "cfdi:Comprobante" ][ "cfdi:Complemento" ][ "tfd:TimbreFiscalDigital_attr" ][ "FechaTimbrado" ], 1, 0, 'C', 1 );
	//Lugar de Elaboración
	$pdf->SetFillColor ( 204, 204, 204 );
	$pdf->SetFont ( 'Arial', 'B', 10 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 46 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, utf8_decode ( 'Lugar de Expedición' ), 1, 0, 'C', 1 );
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 50 );
	$pdf->SetX ( 140 );
	$cpData = [
		'cp' => $xml[ "cfdi:Comprobante_attr" ][ "LugarExpedicion" ], 'limit' => 1, 'environment' => $env ];
	$ResLugar = json_decode ( getRequest ( $cpData, 'getCPInfo?', $env ) , true);
//	var_dump ( $ResLugar);
	$pdf->Cell ( 60, 4, $xml[ "cfdi:Comprobante_attr" ][ "LugarExpedicion" ] . ' ' . $ResLugar[ "zip_town" ], 'LTR', 0, 'C', 1 );
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 54 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 0 ] . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 1 ] .
		$xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 2 ] . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 3 ] . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 4 ] .
		$xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 5 ] . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 6 ] . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 7 ] .
		$xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 8 ] . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 9 ] . 'T' . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 11 ] .
		$xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 12 ] . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 13 ] . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 14 ] .
		$xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 15 ] . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 16 ] . $xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 17 ] .
		$xml[ "cfdi:Comprobante_attr" ][ "Fecha" ][ 18 ], 'LRB', 0, 'C', 1 );
	//Regimen Fiscal
	$pdf->SetFillColor ( 204, 204, 204 );
	$pdf->SetFont ( 'Arial', 'B', 10 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 58 );
	$pdf->SetX ( 140 );
	$pdf->Cell ( 60, 4, utf8_decode ( 'Régimen Fiscal' ), 1, 0, 'C', 1 );
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 62 );
	$pdf->SetX ( 140 );
	$rData = [
		'clave' => $xml[ "cfdi:Comprobante" ][ "cfdi:Emisor_attr" ][ "RegimenFiscal" ], 'limit' => 1, 'environment' => $env ];
	$Regimen = json_decode ( getRequest ( $rData, 'getRegimen?', $env ) , true);
	$pdf->MultiCell ( 60, 4, $xml[ "cfdi:Comprobante" ][ "cfdi:Emisor_attr" ][ "RegimenFiscal" ] . ' ' .
		utf8_decode ( $Regimen[ "rg_regimen" ] ), 1, 'C', 1 );
	//separador
	$pdf->Line ( 8, 42, 200, 42 );
	//DATOS DEL RECEPTOR
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', 'B', 10 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 40 );
	$pdf->SetX ( 8 );
	$pdf->Cell ( 16, 4, 'Receptor: ', 0, 0, 'L', 1 );
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 44 );
	$pdf->SetX ( 8 );
	$pdf->Cell ( 8, 4, 'RFC.: ' . $xml[ "cfdi:Comprobante" ][ "cfdi:Receptor_attr" ][ "Rfc" ] . ' Domicilio Fiscal: ' .
		$xml[ "cfdi:Comprobante" ][ "cfdi:Receptor_attr" ][ "DomicilioFiscalReceptor" ], 0, 0, 'L', 1 );
	//Nombre
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 48 );
	$pdf->SetX ( 8 );
	$pdf->Cell ( 8, 4, $xml[ "cfdi:Comprobante" ][ "cfdi:Receptor_attr" ][ "Nombre" ], 0, 0, 'L', 1 );
	//Uso CFDI
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 52 );
	$pdf->SetX ( 8 );
	$pdf->Cell ( 8, 4, 'Uso CFDI: ' . $xml[ "cfdi:Comprobante" ][ "cfdi:Receptor_attr" ][ "UsoCFDI" ], 0, 0, 'L', 1 );
	//regimen fiscal
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( 56 );
	$pdf->SetX ( 8 );
	$pdf->Cell ( 8, 4, 'Regimen Fiscal: ' . $xml[ "cfdi:Comprobante" ][ "cfdi:Receptor_attr" ][ "RegimenFiscalReceptor" ], 0, 0, 'L', 1 );
	//separador
	$pdf->Line ( 8, 70, 200, 70 );
	//posicion inicial y por pagina
	$y_axis_initial = 72;
	$y_axis = 77;
	//titulos de las columnas
	$pdf->SetFillColor ( 000, 000, 000 );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->SetTextColor ( 255, 255, 255 );
	$pdf->SetY ( $y_axis_initial );
	$pdf->SetX ( 5 );
	$pdf->Cell ( 25, 4, 'CPS', 1, 0, 'C', 1 );
	$pdf->Cell ( 25, 4, utf8_decode ( 'No Identificación' ), 1, 0, 'C', 1 );
	$pdf->Cell ( 20, 4, 'Cantidad', 1, 0, 'C', 1 );
	$pdf->Cell ( 20, 4, 'Clave Unidad', 1, 0, 'C', 1 );
	$pdf->Cell ( 70, 4, 'Descripcion', 1, 0, 'C', 1 );
	$pdf->Cell ( 20, 4, 'Valor Unitario', 1, 0, 'C', 1 );
	$pdf->Cell ( 20, 4, 'Importe', 1, 0, 'C', 1 );
	//
	$partidas = 1;
	$pdf->SetY ( $y_axis );
	foreach ( $xml[ "cfdi:Comprobante" ][ "cfdi:Conceptos" ] as $concepto ) {
		$claveprodserv = '';
		$cantidad = '';
		$unidad = '';
		$descripcion = '';
		$importe = '';
		$valorunitario = '';
		foreach ( $concepto as $clave => $valor ) {
			// Si el valor es otro arreglo, iterar sobre él
			//if (is_array($valor)) {
			//    //echo "[$clave] => \n";
			//    //foreach ($valor as $clave2 => $valor2) {
			//    //    // Si hay otro nivel de arreglo, iterar sobre él
			//    //    if (is_array($valor2)) {
			//    //        echo "  [$clave2] => \n";
			//    //        foreach ($valor2 as $clave3 => $valor3) {
			//    //            // Si hay otro nivel de arreglo, iterar sobre él
			//    //            if (is_array($valor3)) {
			//    //                echo "    [$clave3] => \n";
			//    //                foreach ($valor3 as $clave4 => $valor4) {
			//    //                    echo "      [$clave4] => " . json_encode($valor4) . "\n";
			//    //                }
			//    //            } else {
			//    //                echo "    [$clave3] => " . json_encode($valor3) . "\n";
			//    //            }
			//    //        }
			//    //    } else {
			//    //        echo "  [$clave2] => " . json_encode($valor2) . "\n";
			//    //    }
			//    //}
			//} else {
			if ( !is_array ( $valor ) ) {
				if ( $clave == 'ClaveProdServ' ) {
					$claveprodserv = $valor;
				}
				if ( $clave == 'Cantidad' ) {
					$cantidad = $valor;
				}
				if ( $clave == 'Unidad' ) {
					$unidad = $valor;
				}
				if ( $clave == 'Descripcion' ) {
					$descripcion = $valor;
				}
				if ( $clave == 'Importe' ) {
					$importe = '$ ' . number_format ( $valor, 2 );
				}
				if ( $clave == 'ValorUnitario' ) {
					$valorunitario = '$ ' . number_format ( $valor, 2 );
				}
			}
		}
		if ( $claveprodserv != '' and $cantidad != '' and $unidad != '' and $descripcion != '' and $importe != '' and $valorunitario != '' ) {
			$pdf->SetFillColor ( 255, 255, 255 );
			$pdf->SetFont ( 'Arial', '', 8 );
			$pdf->SetTextColor ( 000, 000, 000 );
			$pdf->SetX ( 5 );
			$pdf->Cell ( 25, 4, $claveprodserv, 0, 0, 'C', 1 );
			$pdf->SetX ( 55 );
			$pdf->Cell ( 20, 4, $cantidad, 0, 0, 'C', 1 );
			$pdf->SetX ( 165 );
			$pdf->Cell ( 20, 4, $valorunitario, 0, 0, 'R', 1 );
			$pdf->Cell ( 20, 4, $importe, 0, 0, 'R', 1 );
			$pdf->SetX ( 75 );
			$pdf->MultiCell ( 20, 4, $unidad, 0, 'C', 1 );
			$pdf->SetY ( $y_axis );
			$pdf->SetX ( 95 );
			$pdf->MultiCell ( 70, 4, $descripcion, 0, 'C', 1 );
			$y_axis = $pdf->GetY () + 5;
		}
	}
	//separador
	$pdf->Line ( 8, $y_axis, 200, $y_axis );
	$y_axis++;
	if ( $y_axis >= 230 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	//desplegar subtotal, descuento, Iva y total
	//desplegar subtotal
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( $y_axis );
	$pdf->SetX ( 165 );
	$pdf->Cell ( 20, 4, 'Subtotal: ', 0, 0, 'R', 1 );
	$pdf->SetFont ( 'Arial', '', 7 );
	$pdf->Cell ( 20, 4, '$ ' . number_format ( $xml[ "cfdi:Comprobante_attr" ][ "SubTotal" ], 2 ), 0, 0, 'R', 1 );
	$y_axis = $y_axis + 4;
	//desplegar numero en letra
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->Ln ();
	$pdf->SetX ( 8 );
	$numero = explode ( '.', $ResFactura[ "total" ] );
	$pdf->Cell ( 100, 4, strtoupper ( num2letras ( $numero[ 0 ] ) . ' pesos ' . $numero[ 1 ] . '/100 M. N.' ), 0, 0, 'L', 1 );
	//despliega Iva
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetX ( 125 );
	$pdf->Cell ( 60, 4, 'Tasa Iva Traslado 16%: ', 0, 0, 'R', 1 );
	$pdf->SetFont ( 'Arial', '', 7 );
	$pdf->Cell ( 20, 4, '$ ' . number_format ( $xml[ "cfdi:Comprobante" ][ "cfdi:Impuestos_attr" ][ "TotalImpuestosTrasladados" ], 2 ), 0, 0, 'R', 1 );
	$y_axis = $y_axis + 4;
	//despliega total
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->Ln ();
	$pdf->SetX ( 165 );
	$pdf->Cell ( 20, 4, 'Total: ', 0, 0, 'R', 0 );
	$pdf->SetFont ( 'Arial', '', 7 );
	$pdf->Cell ( 20, 4, '$ ' . number_format ( $ResFactura[ "total" ], 2 ), 0, 0, 'R', 1 );
	$y_axis = $y_axis + 8;
	//forma de pago
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	//separador
	$pdf->Line ( 5, $y_axis, 205, $y_axis );
	$y_axis = $y_axis + 4;
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 7 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetY ( $y_axis );
	$pdf->SetX ( 5 );
	if ( isset( $xml[ "cfdi:Comprobante_attr" ][ "NumCtaPago" ] ) ) {
		$cta = 'Num. Cuenta: ' . $xml[ "cfdi:Comprobante_attr" ][ "NumCtaPago" ] . ' ';
	} else {
		$cta = '';
	}
	if ( $xml[ "cfdi:Comprobante_attr" ][ "MetodoPago" ] == 'PUE' ) {
		$mpago = 'Pago en una sola exhibición';
	}
	if ( $xml[ "cfdi:Comprobante_attr" ][ "MetodoPago" ] == 'PPD' ) {
		$mpago = 'Pago en parcialidades o diferido';
	}
	//$ResFP=mysql_fetch_array(mysql_query("SELECT Descripcion FROM c_formadepago WHERE c_FormaPago='".$xml["cfdi:Comprobante_attr"]["FormaPago"]."' LIMIT 1"));
	$pdf->Cell ( 205, 4, 'Metodo de Pago: ' . $xml[ "cfdi:Comprobante_attr" ][ "MetodoPago" ] . ' ' . utf8_decode ( $mpago ) . ' | Forma de Pago: ' .
		$xml[ "cfdi:Comprobante_attr" ][ "FormaPago" ] . ' ' . utf8_decode ( '' ) . ' ' . $cta . '| Moneda: ' . $xml[ "cfdi:Comprobante_attr" ][ "Moneda" ] .
		' | Tipo de Cambio: 1', 0, 0, 'L', 1 );
	$y_axis = $y_axis + 8;
	//separador
	$pdf->Line ( 5, $y_axis, 205, $y_axis );
	//Codigo QR
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	//titulos de la columna
	if ( $y_axis >= 230 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 000, 000, 000 );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->SetTextColor ( 255, 255, 255 );
	$pdf->Ln ();
	$pdf->SetX ( 5 );
	$pdf->Cell ( 150, 4, 'Cadena Original del Complemento', 1, 0, 'C', 1 );
	$y_axis = $y_axis + 8;
	//
	//Codigo QR
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->SetX ( 160 );
	$pdf->Cell ( 40, 4, 'Codigo QR', 1, 0, 'C', 1 );
	$y = $pdf->GetY ();
	$pdf->Image ( $PNG_WEB_DIR . basename ( $filename ), 160, ( $y + 6 ), 40 );
	$y_axis = $y_axis + 5;
	//
	//muestra cadena original
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$cadenao = '||1.0|' . $xml[ "cfdi:Comprobante" ][ "cfdi:Complemento" ][ "tfd:TimbreFiscalDigital_attr" ][ "UUID" ] . '|' .
		$xml[ "cfdi:Comprobante" ][ "cfdi:Complemento" ][ "tfd:TimbreFiscalDigital_attr" ][ "FechaTimbrado" ] . '|' .
		$xml[ "cfdi:Comprobante" ][ "cfdi:Complemento" ][ "tfd:TimbreFiscalDigital_attr" ][ "RfcProvCertif" ] . '|' .
		$xml[ "cfdi:Comprobante_attr" ][ "Sello" ] . '|' . $xml[ "cfdi:Comprobante" ][ "cfdi:Complemento" ][ "tfd:TimbreFiscalDigital_attr" ][ "NoCertificadoSAT" ] .
		'||';
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 5 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->Ln ();
	$pdf->SetX ( 5 );
	$pdf->MultiCell ( 150, 2, $cadenao, 0, 'L' );
	$y_axis = $y_axis + 4;
	//
	//sello digital
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 000, 000, 000 );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->SetTextColor ( 255, 255, 255 );
	$pdf->Ln ();
	$pdf->SetX ( 5 );
	$pdf->Cell ( 150, 4, 'Sello Digital', 1, 0, 'C', 1 );
	$y_axis = $y_axis + 4;
	//
	//despliega el sello emisor
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 7 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->Ln ();
	$pdf->SetX ( 5 );
	$pdf->MultiCell ( 150, 4, $xml[ "cfdi:Comprobante_attr" ][ "Sello" ], 0, 'J' );
	//
	//sello sat
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 000, 000, 000 );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->SetTextColor ( 255, 255, 255 );
	$pdf->Ln ();
	$pdf->SetX ( 5 );
	$pdf->Cell ( 150, 4, 'Sello Digital SAT', 1, 0, 'C', 1 );
	$y_axis = $y_axis + 4;
	//
	//despliega el sello sat
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 7 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->Ln ();
	$pdf->SetX ( 5 );
	$pdf->MultiCell ( 150, 4, $xml[ "cfdi:Comprobante" ][ "cfdi:Complemento" ][ "tfd:TimbreFiscalDigital_attr" ][ "SelloSAT" ], 0, 'J' );
	$y_axis = $y_axis + 4;
	//
	//provedor certificado
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 000, 000, 000 );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->SetTextColor ( 255, 255, 255 );
	$pdf->Ln ();
	$pdf->SetX ( 5 );
	$pdf->Cell ( 150, 4, 'RFC Provedor Certificado', 1, 0, 'C', 1 );
	$y_axis = $y_axis + 4;
	//
	//despliega el sello sat
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 7 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->Ln ();
	$pdf->SetX ( 5 );
	$pdf->MultiCell ( 150, 4, $xml[ "cfdi:Comprobante" ][ "cfdi:Complemento" ][ "tfd:TimbreFiscalDigital_attr" ][ "RfcProvCertif" ], 0, 'J' );
	$y_axis = $y_axis + 4;
	//
	//representacion impresa
	if ( $y_axis >= 240 ) {
		$pdf->AddPage ();
		$y_axis = 10;
	}
	$pdf->SetFillColor ( 255, 255, 255 );
	$pdf->SetFont ( 'Arial', '', 8 );
	$pdf->SetTextColor ( 000, 000, 000 );
	$pdf->Ln ();
	$pdf->SetX ( 5 );
	$pagare = utf8_decode ( 'Este documento es una representación impresa de un CFDI.' );
	$pdf->MultiCell ( 205, 4, $pagare, 0, 'C' );
	$y_axis = $y_axis + 4;
	//Envio Archivo
	$pdf->Output ();
	// FUNCIONES DE CONVERSION DE NUMEROS A LETRAS.
	function num2letras ( $num, $fem = TRUE, $dec = TRUE ) {
		//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande");
		$matuni[ 2 ] = "dos";
		$matuni[ 3 ] = "tres";
		$matuni[ 4 ] = "cuatro";
		$matuni[ 5 ] = "cinco";
		$matuni[ 6 ] = "seis";
		$matuni[ 7 ] = "siete";
		$matuni[ 8 ] = "ocho";
		$matuni[ 9 ] = "nueve";
		$matuni[ 10 ] = "diez";
		$matuni[ 11 ] = "once";
		$matuni[ 12 ] = "doce";
		$matuni[ 13 ] = "trece";
		$matuni[ 14 ] = "catorce";
		$matuni[ 15 ] = "quince";
		$matuni[ 16 ] = "dieciseis";
		$matuni[ 17 ] = "diecisiete";
		$matuni[ 18 ] = "dieciocho";
		$matuni[ 19 ] = "diecinueve";
		$matuni[ 20 ] = "veinte";
		$matunisub[ 2 ] = "dos";
		$matunisub[ 3 ] = "tres";
		$matunisub[ 4 ] = "cuatro";
		$matunisub[ 5 ] = "quin";
		$matunisub[ 6 ] = "seis";
		$matunisub[ 7 ] = "sete";
		$matunisub[ 8 ] = "ocho";
		$matunisub[ 9 ] = "nove";
		$matdec[ 2 ] = "veint";
		$matdec[ 3 ] = "treinta";
		$matdec[ 4 ] = "cuarenta";
		$matdec[ 5 ] = "cincuenta";
		$matdec[ 6 ] = "sesenta";
		$matdec[ 7 ] = "setenta";
		$matdec[ 8 ] = "ochenta";
		$matdec[ 9 ] = "noventa";
		$matsub[ 3 ] = 'mill';
		$matsub[ 5 ] = 'bill';
		$matsub[ 7 ] = 'mill';
		$matsub[ 9 ] = 'trill';
		$matsub[ 11 ] = 'mill';
		$matsub[ 13 ] = 'bill';
		$matsub[ 15 ] = 'mill';
		$matmil[ 4 ] = 'millones';
		$matmil[ 6 ] = 'billones';
		$matmil[ 7 ] = 'de billones';
		$matmil[ 8 ] = 'millones de billones';
		$matmil[ 10 ] = 'trillones';
		$matmil[ 11 ] = 'de trillones';
		$matmil[ 12 ] = 'millones de trillones';
		$matmil[ 13 ] = 'de trillones';
		$matmil[ 14 ] = 'billones de trillones';
		$matmil[ 15 ] = 'de billones de trillones';
		$matmil[ 16 ] = 'millones de billones de trillones';
		$num = trim ( (string)@$num );
		if ( $num[ 0 ] == '-' ) {
			$neg = 'menos ';
			$num = substr ( $num, 1 );
		} else
			$neg = '';
		while ( $num[ 0 ] == '0' ) $num = substr ( $num, 1 );
		if ( $num[ 0 ] <= '1' or $num[ 0 ] >= '9' ) $num = '0' . $num;
		$zeros = TRUE;
		$punt = FALSE;
		$ent = '';
		$fra = '';
		for ( $c = 0; $c < strlen ( $num ); $c++ ) {
			$n = $num[ $c ];
			if ( !( strpos ( ".,'''", $n ) === FALSE ) ) {
				if ( $punt ) break;
				else {
					$punt = TRUE;
					continue;
				}
			} else if ( !( strpos ( '0123456789', $n ) === FALSE ) ) {
				if ( $punt ) {
					if ( $n != '0' ) $zeros = FALSE;
					$fra .= $n;
				} else
					$ent .= $n;
			} else
				break;
		}
		$ent = '     ' . $ent;
		if ( $dec and $fra and !$zeros ) {
			$fin = ' coma';
			for ( $n = 0; $n < strlen ( $fra ); $n++ ) {
				if ( ( $s = $fra[ $n ] ) == '0' )
					$fin .= ' cero';
				else if ( $s == '1' )
					$fin .= $fem ? ' uno' : ' un';
				else
					$fin .= ' ' . $matuni[ $s ];
			}
		} else
			$fin = '';
		if ( (int)$ent === 0 ) return 'Cero ' . $fin;
		$tex = '';
		$sub = 0;
		$mils = 0;
		$neutro = FALSE;
		while ( ( $num = substr ( $ent, -3 ) ) != '   ' ) {
			$ent = substr ( $ent, 0, -3 );
			if ( ++$sub < 3 and $fem ) {
				$matuni[ 1 ] = 'un';
				$subcent = 'os';
			} else {
				$matuni[ 1 ] = $neutro ? 'un' : 'un';
				$subcent = 'os';
			}
			$t = '';
			$n2 = substr ( $num, 1 );
			if ( $n2 == '00' ) {
			} else if ( $n2 < 21 )
				$t = ' ' . $matuni[ (int)$n2 ];
			else if ( $n2 < 30 ) {
				$n3 = $num[ 2 ];
				if ( $n3 != 0 ) $t = 'i' . $matuni[ $n3 ];
				$n2 = $num[ 1 ];
				$t = ' ' . $matdec[ $n2 ] . $t;
			} else {
				$n3 = $num[ 2 ];
				if ( $n3 != 0 ) $t = ' y ' . $matuni[ $n3 ];
				$n2 = $num[ 1 ];
				$t = ' ' . $matdec[ $n2 ] . $t;
			}
			$n = $num[ 0 ];
			if ( $n != 0 ) {
				if ( $n == 1 ) {
					$t = ' ciento' . $t;
				} else if ( $n == 5 ) {
					$t = ' ' . $matunisub[ $n ] . 'ient' . $subcent . $t;
				} else if ( $n > 0 ) {
					$t = ' ' . $matunisub[ $n ] . 'cient' . $subcent . $t;
				}
			}
			//$t= $num[0].'|';
			if ( $sub == 1 ) {
			} else if ( !isset( $matsub[ $sub ] ) ) {
				if ( $num == 1 ) {
					$t = ' mil';
				} else if ( $num > 1 ) {
					$t .= ' mil';
				}
			} else if ( $num == 1 ) {
				$t .= ' ' . $matsub[ $sub ] . 'on';
			} else if ( $num > 1 ) {
				$t .= ' ' . $matsub[ $sub ] . 'ones';
			}
			if ( $num == '000' ) $mils++;
			else if ( $mils != 0 ) {
				if ( isset( $matmil[ $sub ] ) ) $t .= ' ' . $matmil[ $sub ];
				$mils = 0;
				
			}
			$neutro = TRUE;
			$tex = $t . $tex;
		}
		$tex = $neg . substr ( $tex, 1 ) . $fin;
		return ucfirst ( $tex );
	}
