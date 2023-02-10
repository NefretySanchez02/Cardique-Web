<?php
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

$name 	= isset( $_POST['name'] ) ? $_POST['name'] : '';
$email_person 	= isset( $_POST['email'] ) ? $_POST['email'] : '';
$phone 	= isset( $_POST['phone'] ) ? $_POST['phone'] : '';
$asunto	= isset( $_POST['subject'] ) ? $_POST['subject'] : '';
$comment= isset( $_POST['message'] ) ? $_POST['message'] : '';

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
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Email:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $email_person . '</td>
		</tr>
		<tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Telefono:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $phone . '</td>
		</tr>
		<tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Asunto:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . $asunto . '</td>
		</tr>
		<tr>
		<td align="right" valign="top" style="border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 5px 7px 0;">Mensaje:</td>
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . nl2br( $comment ) . '</td>
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

if(!$mail->send()) 
{
    echo '<script>
					window.location = "contact.html";
					alert("Error enviando mensaje, Por favor intente mas tarde")
				</script>';
} 
else 
{
    echo '<script>
						window.location = "contact.html";
						alert("Mensaje enviado")
					</script>';
}

?>







