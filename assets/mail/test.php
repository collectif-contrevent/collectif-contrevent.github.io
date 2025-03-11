<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
require_once 'mail.php';

//Test de l'envoi d'email via Mailcatcher
sendMail("localhost", 1025, "", "", "Avenged Sevenfold", "a7x@bestband.com", "0688956235", "Nous sommes le meilleur groupe.", "programmation@collectif-contrevent.fr");

    ?>