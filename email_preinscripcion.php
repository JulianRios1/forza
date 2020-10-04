<?php
include('conexion.php');
extract($_POST);
    

$resultado = $mysqli->query("SELECT c.id, cl.nom, cl.email, cl.email, c.acreditaciones, e.evento, e.logo, e.fecha_final FROM cliente_evento c 
JOIN clientes cl ON c.cliente_id = cl.id
JOIN eventos e ON c.evento_id = e.id
WHERE c.id = $id_cliente");
$row = mysqli_fetch_array($resultado);


$to = 'sauloandres@gmail.com';
$subject = "INSTRUCTIVO PARA REALIZAR EL PROCESO DE ACREDITACIONES CENFER (EVENTO - ".$row["evento"].")";

$htmlContent = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>[SUBJECT]</title>
      <style type="text/css">
      body {
       padding-top: 0 !important;
       padding-bottom: 0 !important;
       padding-top: 0 !important;
       padding-bottom: 0 !important;
       margin:0 !important;
       width: 100% !important;
       -webkit-text-size-adjust: 100% !important;
       -ms-text-size-adjust: 100% !important;
       -webkit-font-smoothing: antialiased !important;
     }
     .tableContent img {
       border: 0 !important;
       display: block !important;
       outline: none !important;
     }
     a{
      color:#382F2E;
    }

    p, h1{
      color:#382F2E;
      margin:0;
    }
 p{
      text-align:left;
      color:#999999;
      font-size:14px;
      font-weight:normal;
      line-height:19px;
    }

    a.link1{
      color:#382F2E;
    }
    a.link2{
      font-size:16px;
      text-decoration:none;
      color:#ffffff;
    }

    h2{
      text-align:left;
       color:#222222; 
       font-size:19px;
      font-weight:normal;
    }
    div,p,ul,h1{
      margin:0;
    }

    .bgBody{
      background: #ffffff;
    }
    .bgItem{
      background: #ffffff;
    }
    
@media only screen and (max-width:480px)
        
{
        
table[class="MainContainer"], td[class="cell"] 
    {
        width: 100% !important;
        height:auto !important; 
    }
td[class="specbundle"] 
    {
        width:100% !important;
        float:left !important;
        font-size:13px !important;
        line-height:17px !important;
        display:block !important;
        padding-bottom:15px !important;
    }
        
td[class="spechide"] 
    {
        display:none !important;
    }
        img[class="banner"] 
    {
              width: 100% !important;
              height: auto !important;
    }
        td[class="left_pad"] 
    {
            padding-left:15px !important;
            padding-right:15px !important;
    }
         
}
    
@media only screen and (max-width:540px) 

{
        
table[class="MainContainer"], td[class="cell"] 
    {
        width: 100% !important;
        height:auto !important; 
    }
td[class="specbundle"] 
    {
        width:100% !important;
        float:left !important;
        font-size:13px !important;
        line-height:17px !important;
        display:block !important;
        padding-bottom:15px !important;
    }
        
td[class="spechide"] 
    {
        display:none !important;
    }
        img[class="banner"] 
    {
              width: 100% !important;
              height: auto !important;
    }
    .font {
        font-size:18px !important;
        line-height:22px !important;
        
        }
        .font1 {
        font-size:18px !important;
        line-height:22px !important;
        
        }
}

    </style>
<script type="colorScheme" class="swatch active">
{
    "name":"Default",
    "bgBody":"ffffff",
    "link":"382F2E",
    "color":"999999",
    "bgItem":"ffffff",
    "title":"222222"
}
</script>
  </head>
  <body paddingwidth="0" paddingheight="0"   style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">
    <table bgcolor="#ffffff" width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent" align="center"  style="font-family:Helvetica, Arial,serif;">
  <tbody>
    <tr>
      <td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#F3F3F3" class="MainContainer">
  <tbody>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td valign="top" width="40">&nbsp;</td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <!-- =============================== Header ====================================== -->   
    <tr>
        <td height="75" class="spechide"></td>
        
        <!-- =============================== Body ====================================== -->
    </tr>
    <tr>
      <td class="movableContentContainer " valign="top">
        <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td height="35"></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td valign="top" align="center" class="specbundle"><div class="contentEditableContainer contentTextEditable">
                                <div class="contentEditable">
                                  <p style="text-align:center;margin:0;font-family:Georgia,Time,sans-serif;font-size:26px;color:#222222;"><span class="specbundle2"><span class="font1">Bienvenido &nbsp;</span></span></p>
                                </div>
                              </div></td>
      <td valign="top" class="specbundle"><div class="contentEditableContainer contentTextEditable">
                                <div class="contentEditable">
                                  <p style="text-align:center;margin:0;font-family:Georgia,Time,sans-serif;font-size:26px;color:#69C374;"><span class="font">'.$row["nom"].'</span> </p>
                                </div>
                              </div></td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
        </div>
        <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                          <tr>
                            <td valign="top" align="center">
                              <div class="contentEditableContainer contentImageEditable">
                                <div class="contentEditable">
                                  <!--<img src="images/line.png" width="251" height="43" alt="" data-default="placeholder" data-max-width="560">-->
                                </div>
                              </div>
                            </td>
                          </tr>
                        </table>
        </div>
        <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                          <tr><td height="55"></td></tr>
                          <tr>
                            <td align="left">
                              <div class="contentEditableContainer contentTextEditable">
                                <div class="contentEditable" align="left">
                                  <h2 >Proceso de Acreditación '.$row["evento"].'</h2>
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr><td height="15"> </td></tr>

                          <tr>
                            <td align="left">
                              <div class="contentEditableContainer contentTextEditable">
                                <div class="contentEditable" align="left">
                                  <p >
                                    Con el ánimo de mejorar y fortalecer la seguridad y control de todos nuestros expositores, Cenfer cambia su proceso de acreditaciones mediante un pre-registro vía Web a nuestra plataforma de acreditaciones donde el expositor podrá hacer la inscripción de los participantes al evento. Esto agilizará el proceso y entrega de sus acreditaciones. 
                                    <br>
                                    <br>
                                    <h2 >Pasos a seguir</h2>
                                    <ol>
                                      <li style="padding-bottom:10px"><p>Ingreso a la plataforma de registro:<br>
Para ingresar de click en el botón "Inscripción Online" </p>
 </li>
                                      <li><p>Llene el formulario con el nombre de las personas que van a participar en el evento y guarde la información.</p></li>
                                    </ol>
                                    <br>
                                    <br>
                                    <p><b>NOTA IMPORTANTE:</b> La entrega de la acreditación es <b>personal</b>, y debe reclamarse en los puntos de acreditación asignados por Cenfer , que se encuentran ubicados al ingreso de cada portería, allí debe activarse la acreditación y tomarse una fotografía.</p>
                                    <br>
                                    

                                  </p>
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr><td height="35"></td></tr>

                          <tr>
                            <td align="center">
                              <table>
                                <tr>
                                  <td align="center" bgcolor="#1A54BA" style="background:#69C374; padding:15px 18px;-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;">
                                    <div class="contentEditableContainer contentTextEditable">
                                      <div class="contentEditable" align="center">
                                        <a target="_blank" href="imatiml.com/logistic/preinscripcion.php?cli='.sha1($id_cliente).'&ff='.sha1($row['fecha_final']).'" class="link2" style="color:#ffffff;">Inscripción Online</a>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td><p><b>IMPORTANTE:</b> Si no visualiza el botón y/o tiene problemas para ingresar al sistema, copie este link http://imatiml.com/logistic/preinscripcion.php?cli='.sha1($id_cliente).'&ff='.sha1($row["fecha_final"]).' y péguelo  el la barra de dirección de su navegador.</p>
                                    <br></td>
                          </tr>
                          <tr><td height="20"></td></tr>

                          <tr>
                            <td align="left">
                              <div class="contentEditableContainer contentTextEditable">
                                <div class="contentEditable" align="left">
                                  <!--<h2 >Fecha y horarios de atención al expositor</h2>
                                  <p >
                                    Los puntos de atención para acreditaciones se abrirán los días 10, 11 y 12 de Agosto de 8:00 a.m. a 8:00 p.m. 
                                    <br>
                                  </p>
                                  <br>-->
                                  <h2 >Personal de montaje</h2>
                                  <p>El personal de montaje de la feria que va ingresar a CENFER por parte de los expositores, debe acreditarse, lo podrán hacer el día de montaje, directamente en los puntos de acreditaciones asignados por Cenfer, no necesita pre-inscribirse solo debe presentarse en el punto de inscripción y sera entregada su escarapela de montaje.</p>
                                </div>
                              </div>
                            </td>
                          </tr>


                        </table>
        </div>
        <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td height="65">
    </tr>
    <tr>
      <td  style="border-bottom:1px solid #DDDDDD;"></td>
    </tr>
    <tr><td height="25"></td></tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td valign="top" class="specbundle"><div class="contentEditableContainer contentTextEditable">
                                      <div class="contentEditable" align="center">
                                        <p  style="text-align:left;color:#DDDDDD;font-size:12px;font-weight:normal;line-height:20px;">
                                          <span style="font-weight:bold;">CENFER S.A</span>
                                          <br>
                                          Motor Show 2016
                                          <br>
                                          <a target="_blank" href="www.cenfer.com">www.cenfer.com</a><br>
                                        </p>
                                      </div>
                                    </div></td>
      <td valign="top" width="30" class="specbundle">&nbsp;</td>
      <td valign="top" class="specbundle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

</table>
</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
    <tr><td height="88"></td></tr>
  </tbody>
</table>

        </div>
        
        <!-- =============================== footer ====================================== -->
      
      </td>
    </tr>
  </tbody>
</table>
</td>
      <td valign="top" width="40">&nbsp;</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>


      </body>
      </html>';

// Set content-type header for sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Additional headers
$headers .= 'From: Cenfer S.A<sistemas@cenfer.com>' . "\r\n";
$headers .= 'Cc: desarollo@imatiml.com' . "\r\n";


// Send email
if(mail($to,$subject,$htmlContent,$headers)){
  echo "0";
}else{
  echo "1";  
}
    
?>