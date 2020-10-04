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
->setCategory("Informe de Medicos no visitados");


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


$objWorkSheet->mergeCells('A1:F1')
    ->setCellValue('A1','LISTADO DE CLIENTES NO VISITADOS EN '.strtoupper(traducir_nombre_mes($mes)).' - '.$ano ) ;
$objWorkSheet->duplicateStyleArray($estilo_clientes,'A1:F1');

//TITULOS DE LAS COLUMNAS
$titulosColumnas = array('Nit', 'Nombre', 'Fecha Ultima Visita', 'Zona', 'Compras ('.$ano.')', 'Compras ('.($ano-1).')');

$objWorkSheet->setCellValue('A2', $titulosColumnas[0])
                ->setCellValue('B2', $titulosColumnas[1])
                ->setCellValue('C2', $titulosColumnas[2])
                ->setCellValue('D2', $titulosColumnas[3])
                ->setCellValue('E2', $titulosColumnas[4])
                ->setCellValue('F2', $titulosColumnas[5]);
       
$objWorkSheet->duplicateStyleArray($estilo_clientes_titulos,'A2:F2');
$j=3;

// Agregar Informacion
$zona_consulta = '';

if($zona != 0)
{
    $zona_consulta .= "AND m.zona = ".$zona;
}
$fecha_busqueda = date($ano.'-'.$mes.'-01');
$contador_filas = 1;

$resultado= $mysqli->query("SELECT u.id, u.documento, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS nombre, m.fecha_ult_vis, z.des FROM medicos m JOIN usuarios u ON m.usuario_id = u.id JOIN zonas z ON m.zona = z.id WHERE m.fechaCreacion < '$fecha_busqueda' $zona_consulta AND m.habilitado = 1 ORDER BY m.fecha_ult_vis DESC");

while($row = mysqli_fetch_array($resultado)){

    //CONSULTAMOS SI LO VISITARON EN EL MES
    //echo "SELECT COUNT(v.id) AS n_visitas FROM visitas v WHERE v.usuario_id = ".$row['id']." AND MONTH(v.fecha) = $mes AND YEAR(v.fecha) = $ano GROUP BY v.usuario_id";
    $resultado2= $mysqli->query("SELECT COUNT(v.id) AS n_visitas FROM visitas v WHERE v.usuario_id = ".$row['id']." AND MONTH(v.fecha) = $mes AND YEAR(v.fecha) = $ano GROUP BY v.usuario_id");
    $num_reg = mysqli_num_rows($resultado2);
    $row2 = mysqli_fetch_array($resultado2);
	


    if ($num_reg == 0) 
    {

           
        //Consultamos las compras hechas por cada cliente del año seleccionado
        $resultado3= $mysqli->query("SELECT SUM(c.compra) AS compras FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND c.ano = $ano AND c.mes <= $mes");
        $row3 = mysqli_fetch_array($resultado3);

        $resultado4= $mysqli->query("SELECT SUM(c.compra) AS compras FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND c.ano = ".($ano-1));
        $row4 = mysqli_fetch_array($resultado4);
    
            
        $objWorkSheet->setCellValue('A'.$j, $row['documento'])
            ->setCellValue('B'.$j, $row['nombre'])
            ->setCellValue('C'.$j, $row['fecha_ult_vis'])
            ->setCellValue('D'.$j, $row['des'])
            ->setCellValue('E'.$j, $row3['compras'])
            ->setCellValue('F'.$j, $row4['compras']);
            
        //Dejamos que la columana se autoajuste
        $objWorkSheet->getColumnDimension('A')->setAutoSize(true);
        $objWorkSheet->getColumnDimension('B')->setAutoSize(true);
        $objWorkSheet->getColumnDimension('C')->setAutoSize(true);
        $objWorkSheet->getColumnDimension('D')->setAutoSize(true);
        $objWorkSheet->getColumnDimension('E')->setAutoSize(true);
        $objWorkSheet->getColumnDimension('F')->setAutoSize(true);
            
        if ($contador_filas%2==0){
            $objWorkSheet->duplicateStyleArray($fila_color,'A'.$j.':F'.$j);
        }
        $contador_filas++;
        $j++;
    
        //Creamos unas fila en blanco para separar
        //$objWorkSheet->setCellValue('A'.$j, '');
        //$j++;
    }       
            
    // Creamos las hojas
    $objWorkSheet->setTitle('Datos');

}

$objPHPExcel->setActiveSheetIndex(0); 

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="InformeMedicosNoVisitados.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>