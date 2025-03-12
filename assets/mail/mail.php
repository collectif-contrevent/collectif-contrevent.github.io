<?php declare(strict_types=1);

//importation des éléments requis pour l'envoi d'email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

// Send Message
function sendMail($smtpHost, $smtpPort, $smtpUsername, $smptPass, $name, $emailContact, $phone, $message, $mailTo)
{

    $fp = fopen("emailTemplate.html", 'rb');

    $emailTemplate = fread($fp, 100024);

    fclose($fp);

    $emailTemplate = str_replace("__NAME__", $name, $emailTemplate);
    $emailTemplate = str_replace("__EMAIL_CONTACT__", $emailContact, $emailTemplate);
    $emailTemplate = str_replace("__MESSAGE__", $message, $emailTemplate);
    $emailTemplate = str_replace("__PHONE__", $phone, $emailTemplate);

    try {
        // Tentative de création d’une nouvelle instance de la classe PHPMailer, avec les exceptions activées
        $mail = new PHPMailer(true);

        $mail->isSMTP();

        if (!empty($smtpUsername) and !empty($smptPass)) {
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } else {
            $mail->SMTPAuth = false;
        }

        // // Informations personnelles
        $mail->Host = $smtpHost;
        $mail->Port = $smtpPort;
        $mail->Username = $smtpUsername;
        $mail->Password = $smptPass;

        // Expéditeur
        $mail->setFrom('noreply@collectif-contrevent.fr', 'Contact site');
        // Destinataire dont le nom peut également être indiqué en option
        $mail->addAddress($mailTo, 'nom');
        // Copie
        //$mail->addCC('info@exemple.fr');
        // Copie cachée
        //$mail->addBCC('info@exemple.fr', 'nom');
        // (…)
        $mail->isHTML(true);
        // Objet
        $mail->Subject = 'Contact ' . $name;
        // HTML-Content
        $mail->Body = $emailTemplate;
        //$mail->AltBody = 'Le texte comme simple élément textuel';
        // Ajouter une pièce jointe
        $mail->addAttachment("../../assets/images/logo/logo-02.jpg", "logo.jpg");
        $mail->addAttachment("../../assets/images/logo/collectif.png", "collectif.png");

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->send();

    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
    }
}

// Get Data 
if (!empty($_POST)) {
    $name = strip_tags($_POST['name']);
    $emailContact = strip_tags($_POST['emailContact']);
    $phone = strip_tags($_POST['phone']);
    $message = strip_tags($_POST['message']);
    $mailTo = strip_tags($_POST['mailTo']);
}

sendMail("localhost", 1025, "", "", $name, $emailContact, $phone, $message, $mailTo);
header("Location: emailSent.html");

?>