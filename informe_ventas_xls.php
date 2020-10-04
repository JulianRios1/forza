<?php
include('conexion.php');
include('funciones/fechas.php');
/** Incluir la libreria PHPExcel */
require_once 'assets/global/plugins/phpexcel/Classes/PHPExcel.php';


extract($_GET);

// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Imati")
->setLastModifiedBy("Imati")
->setTitle("Documento Excel")
->setSubject("Documento Excel")
->setDescription("")
->setKeywords("")
->setCategory("Informe de Ventas x Zonas");


$json = array();
$i=0;
$sheet = $objPHPExcel->getActiveSheet();

//CREAMOS ESTILOS PARA LAS FILAS
$estilo_clientes = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 10,
        'name'  => 'Arial'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'004E82'),
    )
);

$estilo_clientes_titulos = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 10,
        'name'  => 'Arial'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'006FB9'),
    )
);

$fila_color = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 10,
        'name'  => 'Arial'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'EEEEEE'),
    )
);


$fila_campos_especiales = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 10,
        'name'  => 'Arial'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'75C8FF'),
    )
);

$color_rojo = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 10,
        'name'  => 'Arial'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'FF7575'),
    )
);
$color_amarillo = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 10,
        'name'  => 'Arial'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'FFFF00'),
    )
);
$color_verde = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 10,
        'name'  => 'Arial'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'00FF00'),
    )
);


// Add new sheet
$objWorkSheet = $objPHPExcel->createSheet(0);


$objWorkSheet->mergeCells('A1:P1')
    ->setCellValue('A1','VENTAS DEL AÑO '.$ano) ;
$objWorkSheet->duplicateStyleArray($estilo_clientes,'A1:P1');

//TITULOS DE LAS COLUMNAS
$titulosColumnas = array('Nit', 'Cliente', 'ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC', 'Promedio', 'Total');

$objWorkSheet->setCellValue('A2', $titulosColumnas[0])
                ->setCellValue('B2', $titulosColumnas[1])
                ->setCellValue('C2', $titulosColumnas[2])
                ->setCellValue('D2', $titulosColumnas[3])
                ->setCellValue('E2', $titulosColumnas[4])
                ->setCellValue('F2', $titulosColumnas[5])
                ->setCellValue('G2', $titulosColumnas[6])
                ->setCellValue('H2', $titulosColumnas[7])
                ->setCellValue('I2', $titulosColumnas[8])
                ->setCellValue('J2', $titulosColumnas[9])
                ->setCellValue('K2', $titulosColumnas[10])
                ->setCellValue('L2', $titulosColumnas[11])
                ->setCellValue('M2', $titulosColumnas[12])
                ->setCellValue('N2', $titulosColumnas[13])
                ->setCellValue('O2', $titulosColumnas[14])
                ->setCellValue('P2', $titulosColumnas[15]);
       
$objWorkSheet->duplicateStyleArray($estilo_clientes_titulos,'A2:P2');
$j=3;

// Agregar Informacion
$zonas = '';

if($zona != 0)
{
    $zonas .= "AND m.zona = ".$zona;
}

$contador_filas = 1;

$resultado = $mysqli->query("SELECT u.documento, UPPER(CONCAT_WS(' ',u.nom,u.ape1,u.ape2)) AS cliente FROM medicos m JOIN usuarios u ON m.usuario_id = u.id $zonas");

while($row = mysqli_fetch_array($resultado))
{


    $total_anio = 0;
    $array_ventas = array();
    $k=0;
    $promedio_ventas = 0;

    //Calculamos el valor de los meses
    for($i=1; $i<=12; $i++)
    {

        $resultado2 = $mysqli->query("SELECT compra FROM cartera_usuarios WHERE cliente_doc = '".$row["documento"]."' AND mes = $i AND ano = ".$ano);
        $row2 = mysqli_fetch_array($resultado2);

        $resultado2->close();

        //Lleno el array con los valores
        array_push($array_ventas,$row2['compra']);
        //Sumamos los valores
        $total_anio += $row2['compra'];
        
        if($row2['compra'] != 0)
        {
            $k++;   
        }           
    } 

	
    $objWorkSheet->setCellValue('A'.$j, $row['documento'])
            ->setCellValue('B'.$j, $row['cliente']);

    $letra = "B";

    if($total_anio != 0)
    {
        foreach($array_ventas as $indice => $valor) 
        {
            if($j > 0)
            {
                if($ano < date('Y'))
                {
                    $numPeriodos = 12;
                }
                else
                {
                    $numPeriodos = date('m');
                }
                
                $promedio_ventas = ($total_anio / $numPeriodos);    
            }
                                        
            $color = '';
            $rango_promedio = (($promedio_ventas*85)/100);
            
            if($valor >= $promedio_ventas && $promedio_ventas != 0)
            {
                $color = $color_rojo;
            }
            
            if($valor <= $rango_promedio && $promedio_ventas != 0)
            {
                $color = $color_rojo;
            }
            
            if(($valor < $promedio_ventas) && ($valor >= $rango_promedio) && ($promedio_ventas != 0))
            {
                $color = $color_rojo;
            }

            $nueva_letra = ++$letra;
            //$objWorkSheet->duplicateStyleArray($color,$nueva_letra.$j);
            $objWorkSheet->setCellValue($nueva_letra.$j, number_format($valor, 0, ",", ""));
            //$objWorkSheet->StyleArray($color,++$letra.$j);

        }   
    }
    
    $objWorkSheet->setCellValue('O'.$j, number_format($promedio_ventas,0, ",", ""))
            ->setCellValue('P'.$j, number_format($total_anio,0, ",", ""));
                                     
                                /*
                                <td><?php echo '$'.number_format($promedio_ventas, 0, ",", ".")?></td>
                                <td><?php echo '$'.number_format($total_anio, 0, ",", ".")?></td>-+*/
            
    //Dejamos que la columana se autoajuste
    $objWorkSheet->getColumnDimension('A')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('B')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('C')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('D')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('E')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('F')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('G')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('H')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('I')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('J')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('K')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('L')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('M')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('N')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('O')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('P')->setAutoSize(true);
        
    if ($contador_filas%2==0){
        $objWorkSheet->duplicateStyleArray($fila_color,'A'.$j.':P'.$j);
    }
    $contador_filas++;
    $j++;


    // Creamos las hojas
    $objWorkSheet->setTitle('Datos');

}

$objPHPExcel->setActiveSheetIndex(0); 

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="InformeVentas.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>