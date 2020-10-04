<?php
include('conexion.php');
/** Incluir lap libreria PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';
include('includes/parametros.php');

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
->setCategory("Listado de Usuarios");

// Agregar Informacion
$resultado = $mysqli->query('SELECT * FROM roles r');
$num_reg = mysqli_num_rows($resultado);

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

//TITULOS DE LAS COLUMNAS
$titulosColumnas = array('DOCUMENTO', 'NOMBRE', 'APELLIDOS', 'TELÉFONO', 'DIRECCIÓN', 'EMAIL', 'USUARIO', 'ESTADO USUARIO', 'ESTADO ITINERARIO', 'ZONA');


while($row = mysqli_fetch_array($resultado)){

    // Add new sheet
    $objWorkSheet = $objPHPExcel->createSheet($i);
    
    //INICIAMOS EL CONTADOR DE CELDAS
    $j=1;
    
    $objWorkSheet->setCellValue('A'.$j, $titulosColumnas[0])
            ->setCellValue('B'.$j, $titulosColumnas[1])
            ->setCellValue('C'.$j, $titulosColumnas[2])
            ->setCellValue('D'.$j, $titulosColumnas[3])
            ->setCellValue('E'.$j, $titulosColumnas[4])
            ->setCellValue('F'.$j, $titulosColumnas[5])
            ->setCellValue('G'.$j, $titulosColumnas[6])
            ->setCellValue('H'.$j, $titulosColumnas[7])
            ->setCellValue('I'.$j, $titulosColumnas[8]) 
            ->setCellValue('J'.$j, $titulosColumnas[9]);

    $objWorkSheet->duplicateStyleArray($estilo_clientes_titulos,'A'.$j.':J'.$j);


    //CONSULTAMOS LOS EXPOSITORES DE CADA TIPO
	$resultado2 = $mysqli->query("SELECT u.*, z.des AS zona, m.habilitado FROM usuarios u LEFT JOIN medicos m ON m.usuario_id = u.id LEFT JOIN zonas z ON m.zona = z.id WHERE u.idrol = ".$row['id']." AND u.id != 1 ORDER BY u.nom ASC");
    while($row2 = mysqli_fetch_array($resultado2)){
    
        /*$objWorkSheet->mergeCells('A'.$j.':F'.$j)
                ->setCellValue('A'.$j,'EXPOSITOR: '.strtoupper($row2['nom']));
        $objWorkSheet->duplicateStyleArray($estilo_clientes,'A'.$j.':F'.$j);
        */
                
        //sumamos una posicion
       $j++;
        
        $objWorkSheet->setCellValue('A'.$j, $row2['documento'])
            ->setCellValue('B'.$j, strtoupper($row2['nom']))
            ->setCellValue('C'.$j, strtoupper($row2['ape1'].' '.$row2['ape2']))
            ->setCellValue('D'.$j, $row2['tel'])
            ->setCellValue('E'.$j, $row2['dir'])
            ->setCellValue('F'.$j, $row2['mail'])
            ->setCellValue('G'.$j, $row2['usu'])
            ->setCellValue('H'.$j, estado($row2['estado']))
            ->setCellValue('I'.$j, habilitado($row2['habilitado']))
            ->setCellValue('J'.$j, $row2['zona']);
            
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


        //sumamos una posicion
        //$j++;
        $contador_filas = 1;
                        

        }
        
            
        //Creamos unas fila en blanco para separar
        //$objWorkSheet->setCellValue('A'.$j, '');
        $j++;
          
            
    // Creamos las hojas
    $objWorkSheet->setTitle($row['nomrol']);

    $i++;

} 

$objPHPExcel->setActiveSheetIndex(0); 

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="InformedeUsuarios.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>