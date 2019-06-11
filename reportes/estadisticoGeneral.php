<?php 

require_once '../vendor/autoload.php';
require_once '../app/config.php';

$mes = 6;
$diasMes = 30;

$html = '<html>';
	$html .= '<table border="1" style="border-collapse: collapse;width:100%;page-break-inside: avoid">';
	$html .= '<tr>';
			$html .= '<td colspan="16" style="text-align:center;">';
				$html .= 'UBICACIÓN';
			$html .= '</td>';
	$html .= '</tr>';

	$html .= '<tr>';
			$html .= '<td colspan="8" style="text-align:left;">';
				$html .= 'Nombre de la Biblioteca';
			$html .= '</td>';
			$html .= '<td colspan="8" style="text-align:left;">';
				$html .= 'Teléfono N°';
			$html .= '</td>';
	$html .= '</tr>';

	$html .= '<tr>';
			$html .= '<td colspan="8" style="text-align:left;">';
				$html .= 'Dirección';
			$html .= '</td>';
			$html .= '<td colspan="8" style="text-align:left;">';
				$html .= 'Departamento';
			$html .= '</td>';
	$html .= '</tr>';

	$html .= '<tr>';
			$html .= '<td colspan="16" style="text-align:left;">';
				$html .= 'Municipio';
			$html .= '</td>';
	$html .= '</tr>';

	$html .= '<tr>';
			$html .= '<td colspan="16" style="text-align:left;">';
				$html .= 'Informe correspondiente al mes de ';
			$html .= '</td>';
	$html .= '</tr>';

	$html .= '<tr>';
			$html .= '<td style="text-align:center; vertical-aling: middle;" rowspan="2">';
				$html .= 'DIA DEL MES';
			$html .= '</td>';

			$html .= '<td colspan="3" style="text-align:center; vertical-aling: middle;">';
				$html .= 'LECTORES';
			$html .= '</td>';

			$html .= '<td colspan="12" style="text-align:center; vertical-aling: middle;">';
				$html .= 'OBRAS CONSULTADAS';
			$html .= '</td>';
	$html .= '</tr>';

	$html .= '<tr>';
			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'TOTAL';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'HOMBRES';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'MUJERES';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'TOTAL';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'Obras Generales (000)';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'Filosofia (100)';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'Religión (200)';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'Ciencias Sociales (300)';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'Filología y lingüística (400)';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'Ciencias Puras (500)';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'Ciencias Aplicadas (600)';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'Bellas Artes (700)';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'Literatura (800)';
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= 'Historia y Geografía (900)';
			$html .= '</td>';

	$html .= '</tr>';


	for ($i=1; $i < $diasMes; $i++) { 

		



		$html .= '<tr>';
			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				$html .= $i;
			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';

				$sql = "SELECT count(distinct idUsuario) as totalUsuarios from prestamo where day(fechaRealizacion) = '{$i}' and month(fechaRealizacion) = '{$mes}'and estado=1;";
				$con = conectar();
				$result = $con->query($sql);
				$result = $result->fetch_assoc();
				$html .= $result['totalUsuarios'];
				mysqli_close($con);

			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				//	 HOMBRES
				$sql = "SELECT count(distinct p.idUsuario) as hombres from prestamo p
						inner join usuario u
						on p.idUsuario = u.id
						where u.genero='Masculino' and
						day(fechaRealizacion) = '{$i}' and month(fechaRealizacion) = '{$mes}' and p.estado=1;";
				$con = conectar();
				$result = $con->query($sql);
				$result = $result->fetch_assoc();
				$html .= $result['hombres'];
				mysqli_close($con);

			$html .= '</td>';

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
				//	MUJERES
				$sql = "SELECT count(distinct p.idUsuario) as mujeres from prestamo p
						inner join usuario u
						on p.idUsuario = u.id
						where u.genero='Femenino' and
						day(fechaRealizacion) = '{$i}' and month(fechaRealizacion) = '{$mes}' and p.estado=1";
				$con = conectar();
				$result = $con->query($sql);
				$result = $result->fetch_assoc();
				$html .= $result['mujeres'];
				mysqli_close($con);
			$html .= '</td>';

			$col = '';
			$acum = 0;
			//COLUMNAS POR EPIGRAFE
			for ($c=0; $c < 10; $c++) {

				$sql = "SELECT count(*) as historia from prestamo p
					inner join inventario iv
					on p.idInventario=iv.id
					inner join libro l
					on iv.idLibro=l.id
					where (l.clasificacion like 'COL.NB&{$c}%' 
				   or l.clasificacion like 'CPERLA&{$c}%' 
				   or l.clasificacion like '{$c}%' -- obras generales
				   or l.clasificacion like 'C.DPI&{$c}%' -- diplomados
				   or l.clasificacion like 'DIP&{$c}%' -- diplomados
				   or l.clasificacion like '{$c}%' -- libros
				   or l.clasificacion like 'REF.&{$c}%' -- libros
				   or l.clasificacion like 'JSA.&{$c}%')-- libros
				   and iv.estadoMaterial='Prestado' and
					day(p.fechaRealizacion) = '{$i}' and month(p.fechaRealizacion) = '{$mes}' and p.estado=1";
				$con = conectar();
				$result = $con->query($sql);
				$result = $result->fetch_assoc();

				mysqli_close($con);

				$col .= '<td style="text-align:center; vertical-aling: middle;">';
					$col .= $result['historia'];
				$col .= '</td>';
				$acum += $result['historia'];
			}

			$html .= '<td style="text-align:center; vertical-aling: middle;">';
					$html .= $acum;
			$html .= '</td>';

			$html .= $col;

			
	$html .= '</tr>';
	}

	$html .= '</table>';
$html .= '</html>';

$html = utf8_decode($html);

		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
        $html= utf8_encode($html);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
 ?>