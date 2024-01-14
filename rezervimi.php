<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path-to-phpmailer/src/Exception.php';
require 'path-to-phpmailer/src/PHPMailer.php';
require 'path-to-phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Për të përdorur SMTP2GO, zëvendësojeni me informacionin tuaj të furnizuar nga shërbimi
    $smtpHost = 'mail.smtp2go.com';
    $smtpPort = 2525;
    $smtpUsername = 'seasunapartament';
    $smtpPassword = 'wgnECC2cmsESkhC2';

    // Validimi i të dhënave të hyra
    $emri = validateInput($_POST['emri']);
    $mbiemri = validateInput($_POST['mbiemri']);
    $shteti = validateInput($_POST['shtet']);
    $telefoni = validateInput($_POST['telefoni']);
    $data_mberritjes = validateInput($_POST['data_mberritjes']);
    $cmimi = validateInput($_POST['cmimi']);
    $user_email = validateEmail($_POST['user_email']); // Emri i fushës për email

    // Krijimi i një instance të PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Parametrat e lidhjes SMTP
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = 'tls'; // Mund të përdorni 'ssl' nëse preferoni

        // Parametrat e email-it
        $mail->setFrom('webmaster@test.com', 'Webmaster');
        $mail->addAddress($user_email, $emri);
        $mail->Subject = 'Informacioni i rezervimit';
        $mail->Body = "Emri: $emri\nMbiemri: $mbiemri\nShteti: $shteti\nTelefoni: $telefoni\nData e mbërritjes: $data_mberritjes\nÇmimi: $cmimi";

        // Dërgimi i email-it
        $mail->send();

        // Suksesi
        echo 'Emaili u dërgua me sukses.';
    } catch (Exception $e) {
        // Gabimi gjatë dërgimit të email-it
        echo 'Gabim gjatë dërgimit të email-it: ' . $mail->ErrorInfo;
    }
}

// Funksioni për validimin e inputeve
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Funksioni për validimin e adresës së email-it
function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Adresa e email-it nuk është e vlefshme
        // Kthe një vlerë default ose bëj diçka tjetër nëse është e nevojshme
        // Për shembull, mund të shfaqni një mesazh gabimi ose ndaloni ekzekutimin
        echo "Adresa e email-it nuk është e vlefshme!";
        exit;
    }
    return $email;
}
?>


