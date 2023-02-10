<?php
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

$name 	= isset( $_POST['name'] ) ? $_POST['name'] : '';
$type_document 	= isset( $_POST['type_document'] ) ? $_POST['type_document'] : '';
$number_document 	= isset( $_POST['number_document'] ) ? $_POST['number_document'] : '';
$direction	= isset( $_POST['direction'] ) ? $_POST['direction'] : '';
$corregimiento= isset( $_POST['corregimiento'] ) ? $_POST['corregimiento'] : '';
$email_person= isset( $_POST['email'] ) ? $_POST['email'] : '';
$phone= isset( $_POST['phone'] ) ? $_POST['phone'] : '';
$ubicacion= isset( $_POST['ubicacion'] ) ? $_POST['ubicacion'] : '';
$facebook= isset( $_POST['facebook'] ) ? $_POST['facebook'] : '';
$instragram= isset( $_POST['instragram'] ) ? $_POST['instragram'] : '';
$page_web= isset( $_POST['page_web'] ) ? $_POST['page_web'] : '';
$nombre_proyecto= isset( $_POST['nombre_proyecto'] ) ? $_POST['nombre_proyecto'] : '';
$descripcion_proyecto= isset( $_POST['descripcion_proyecto'] ) ? $_POST['descripcion_proyecto'] : '';
$estado_proyecto= isset( $_POST['estado_proyecto'] ) ? $_POST['estado_proyecto'] : '';
$categoria_proyecto= isset( $_POST['categoria_proyecto'] ) ? $_POST['categoria_proyecto'] : '';
$acompanamiento_proyecto= isset( $_POST['acompanamiento_proyecto'] ) ? $_POST['acompanamiento_proyecto'] : '';
$participacion_talleres= isset( $_POST['participacion_talleres'] ) ? $_POST['participacion_talleres'] : '';
$autorizar_contacto= isset( $_POST['autorizar_contacto'] ) ? $_POST['autorizar_contacto'] : '';
$autorizacion_correo= isset( $_POST['autorizacion_correo'] ) ? $_POST['autorizacion_correo'] : '';
$desarrollo_curso= isset( $_POST['desarrollo_curso'] ) ? $_POST['desarrollo_curso'] : '';
$politica_datos= isset( $_POST['politica_datos'] ) ? $_POST['politica_datos'] : '';
$file_tmp  = $_FILES['files_products']['tmp_name'];
$file_name = $_FILES['files_products']['name'];
$checkbox = "";
if(!empty($_POST["criterios_proyecto"])){
    $checkbox = implode(', ', $_POST['criterios_proyecto']);           
}	 


$message = '
		<html>
		<head>
		<title>HTML email</title>
		</head>
		<body>
		<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		<td width="50%" align="right">&nbsp;</td>
		<td align="left">&nbsp;</td>
		</tr>
		<tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Nombre:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $name . '</td>
		</tr>
		<tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Tipo y numero de documentos:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $type_document . ' '.$number_document.'</td>
		</tr>
		<tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Dirección:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $direction . '</td>
		</tr>
		<tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Corregimiento:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $corregimiento . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Correo Electrónico:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $email_person . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Telefono:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $phone . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Ubicación:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $ubicacion . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Facebook:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $facebook . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Instragram:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $instragram . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Pagina Web:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $page_web . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Nombre de la Idea y/o proyecto:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $nombre_proyecto . '</td>
		</tr>
        <tr>
		<tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Descripción de la Idea y/o proyecto:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . nl2br( $descripcion_proyecto ) . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Fotos del Productos: archivo adjunto</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Estado del proyecto:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $estado_proyecto . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Categoría del proyecto:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $categoria_proyecto . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Criterios que cumple la idea:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $checkbox . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Acepto acompañmiento de cardique en su proyecto:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $acompanamiento_proyecto . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Acepto participar en talleres de formación en temas de emprendimiento, sostenibilidad, etc:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $participacion_talleres . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Autorizó para ponerse en contacto:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $autorizar_contacto . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Autorizó para enviar comunicaciones al correo:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $autorizacion_correo . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Ha desarrollado el curso de formación de negocios verdes:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $desarrollo_curso . '</td>
		</tr>
        <tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Acepto la política de uso de datos:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $politica_datos . '</td>
		</tr>
		</table>
		</body>
		</html>
		';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->setFrom("contacto@negociosverdes.com", 'Contacto Ventanilla Cardique');
$mail->addAddress("nefretysanchez@gmail.com", "Contacto Ventanilla Cardique");
$mail->isHTML(true);

$mail->Subject = "Formulario de Contacto";
$mail->Body = $message;
$mail->AddAttachment($file_tmp, $file_name);
if(!$mail->send()) 
{
    echo '<script>
					window.location = "como-ser-parte.html";
					alert("Error enviando mensaje, Por favor intente mas tarde")
				</script>';
} 
else 
{
    echo '<script>
						window.location = "como-ser-parte.html";
						alert("Mensaje enviado")
					</script>';
} 

?>







