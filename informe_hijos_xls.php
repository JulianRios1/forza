<?php
include('conexion.php');
include('funciones/fechas.php');
/** Incluir la libreria PHPExcel */
require_once 'assets/global/plugins/phpexcel/Classes/PHPExcel.php';


extract($_GET);
$hombres = $mujeres = $sin_genero = 0;
$ano= date('Y');
$contador_filas = 1;

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
->setCategory("Informe de Hijos");


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


// Add new sheet
$objWorkSheet = $objPHPExcel->createSheet(0);


$objWorkSheet->mergeCells('A1:E1')
    ->setCellValue('A1','INFORME DE HIJOS' ) ;
$objWorkSheet->duplicateStyleArray($estilo_clientes,'A1:E1');

//TITULOS DE LAS COLUMNAS
$titulosColumnas = array('Documento', 'Nombre', 'Genero', 'Fecha Cumpleaños', 'Compras');

$objWorkSheet->setCellValue('A2', $titulosColumnas[0])
                ->setCellValue('B2', $titulosColumnas[1])
                ->setCellValue('C2', $titulosColumnas[2])
                ->setCellValue('D2', $titulosColumnas[3])
                ->setCellValue('E2', $titulosColumnas[4]);
       
$objWorkSheet->duplicateStyleArray($estilo_clientes_titulos,'A2:E2');
$j=3;

// Agregar Informacion
$zona_consulta = '';

if($zona != 0)
{
    $zona_consulta .= "AND m.zona = ".$zona;
}


$resultado= $mysqli->query("SELECT u.documento, UPPER(CONCAT_WS(' ', u.nom,u.ape1,u.ape2)) AS nombre, m.genero, m.mes_cum, m.dia_cum FROM medicos m JOIN usuarios u ON m.usuario_id = u.id JOIN zonas z ON m.zona = z.id WHERE m.hijos = 1 $zona_consulta");

while($row = mysqli_fetch_array($resultado)){

    if($row['genero'] == 'M'){ $hombres += 1;}                    
    if($row['genero'] == 'F'){ $mujeres += 1;}
    if($row['genero'] == ''){ $sin_genero += 1;}


    $resultado2= $mysqli->query("SELECT SUM(c.compra) AS compras FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND c.ano = ".$ano);
    $row2 = mysqli_fetch_array($resultado2);

        
    $objWorkSheet->setCellValue('A'.$j, $row['documento'])
        ->setCellValue('B'.$j, $row['nombre'])
        ->setCellValue('C'.$j, $row['genero'])
        ->setCellValue('D'.$j, traducir_nombre_mes($row['mes_cum']).' '.$row['dia_cum'])
        ->setCellValue('E'.$j, $row2['compras']);
        
    //Dejamos que la columana se autoajuste
    $objWorkSheet->getColumnDimension('A')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('B')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('C')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('D')->setAutoSize(true);
    $objWorkSheet->getColumnDimension('E')->setAutoSize(true);

    $sheet->getStyle('E'.$j)->getNumberFormat()->setFormatCode('#,##0.00');
        
    if ($contador_filas%2==0){
        $objWorkSheet->duplicateStyleArray($fila_color,'A'.$j.':E'.$j);
    }
    $contador_filas++;
    $j++;

}


//Creamos unas fila en blanco para separar
$objWorkSheet->setCellValue('A'.$j, '');
$j++;

$objWorkSheet->mergeCells('A'.$j.':B'.$j)
    ->setCellValue('A'.$j,'CONSOLIDADO' ) ;
$objWorkSheet->duplicateStyleArray($estilo_clientes_titulos,'A'.$j.':B'.$j);
$j++;

/////////////////////////////////////////////////////////////////////
$objWorkSheet->setCellValue('A'.$j, 'HOMBRES')->setCellValue('B'.$j, $hombres);
$j++;

$objWorkSheet->setCellValue('A'.$j, 'MUJERES')->setCellValue('B'.$j, $mujeres)->duplicateStyleArray($fila_color,'A'.$j.':B'.$j);
$j++;

$objWorkSheet->setCellValue('A'.$j, 'SIN ESPECIFICAR')->setCellValue('B'.$j, $sin_genero);
$j++;

$objWorkSheet->setCellValue('A'.$j, 'TOTAL')->setCellValue('B'.$j, ($hombres+$mujeres+$sin_genero))->duplicateStyleArray($fila_color,'A'.$j.':B'.$j);
$j++;

// Creamos las hojas
$objWorkSheet->setTitle('Datos');


$objPHPExcel->setActiveSheetIndex(0); 

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="InformeHijos.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>