<?php
include('conexion.php');
include('funciones/fechas.php');
/** Incluir la libreria PHPExcel */
require_once 'assets/global/plugins/phpexcel/Classes/PHPExcel.php';


extract($_GET);
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
->setCategory("Informe Especialidades");


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


$objWorkSheet->mergeCells('A1:J1')
    ->setCellValue('A1','INFORME DE ESPECIALIDADES - '.strtoupper($esp_nom) ) ;
$objWorkSheet->duplicateStyleArray($estilo_clientes,'A1:J1');

//TITULOS DE LAS COLUMNAS
$titulosColumnas = array('Documento', 'Nombre', 'Dirección','Ciudad','Departamento', 'Teléfono', 'Celular', 'E-mail', 'Genero', 'Fecha Cumpleaños');

$objWorkSheet->setCellValue('A2', $titulosColumnas[0])
                ->setCellValue('B2', $titulosColumnas[1])
                ->setCellValue('C2', $titulosColumnas[2])
                ->setCellValue('D2', $titulosColumnas[3])
                ->setCellValue('E2', $titulosColumnas[4])
                ->setCellValue('F2', $titulosColumnas[5])
                ->setCellValue('G2', $titulosColumnas[6])
                ->setCellValue('H2', $titulosColumnas[7])
                ->setCellValue('I2', $titulosColumnas[8])
                ->setCellValue('J2', $titulosColumnas[9]);

$objWorkSheet->duplicateStyleArray($estilo_clientes_titulos,'A2:J2');
$j=3;


$resultado= $mysqli->query("SELECT u.documento, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS nombre, u.dir, u.tel, u.cel, u.mail, m.genero, m.mes_cum, m.dia_cum, mun.nombreMunicipio AS municipio, d.nombre_dep AS departamento FROM medicos m JOIN usuarios u ON m.usuario_id = u.id LEFT JOIN municipios mun ON u.ciudad_actual = mun.id LEFT JOIN departamentos d ON mun.departamento_id = d.id  WHERE especialidad = $especialidad");

while($row = mysqli_fetch_array($resultado)){


    $objWorkSheet->setCellValue('A'.$j, $row['documento'])
        ->setCellValue('B'.$j, $row['nombre'])
        ->setCellValue('C'.$j, $row['dir'])
        ->setCellValue('D'.$j, $row['municipio'])
        ->setCellValue('E'.$j, $row['departamento'])
        ->setCellValue('F'.$j, $row['tel'])
        ->setCellValue('G'.$j, $row['cel'])
        ->setCellValue('H'.$j, $row['mail'])
        ->setCellValue('I'.$j, $row['genero'])
        ->setCellValue('J'.$j, traducir_nombre_mes($row['mes_cum']).' '.$row['dia_cum']);
        
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
        
    if ($contador_filas%2==0){
        $objWorkSheet->duplicateStyleArray($fila_color,'A'.$j.':J'.$j);
    }
    $contador_filas++;
    $j++;

}


// Creamos las hojas
$objWorkSheet->setTitle('Datos');


$objPHPExcel->setActiveSheetIndex(0); 

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="InformeEspecialidades.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>