<?php
require '../../phpmailer/Exception.php';
require '../../phpmailer/PHPMailer.php';
require '../../phpmailer/SMTP.php';

$name = $_REQUEST['name'];
$email_person = $_REQUEST['email'];
$phone = $_REQUEST['phone'];
$asunto = $_REQUEST['subject'];
$comment = $_REQUEST['message'];

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
		<td align="left" valign="top" style="border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; padding:7px 0 7px 5px;">' . nl2br($comment) . '</td>
		</tr>
		</table>
		</body>
		</html>
		';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->setFrom("contact@negociosverdes.com", 'Contacto Ventanilla Cardique');
$mail->addAddress("negociosverdes@cardique.gov.co", "Contacto Ventanilla Cardique");
$mail->isHTML(true);

$mail->Subject = "Formulario de Contacto";
$mail->Body = $message;

if (!$mail->send()) {
	echo 'Message could not be sent.';
} else {
	echo '1';
}

?>