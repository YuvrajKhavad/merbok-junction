<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once "PHPMailer/OAuth.php";
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";


if (!empty($_POST)) {
    $data['success'] = true;
    $website_name = "Merbok Junction";
    $color_code = "#99CC44";

    // Sanitize and validate inputs
    $f_name = $_POST['f_name'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $country_code = $_POST['country_code'];
    $know_about = $_POST['know_about'];
    $other = $_POST['other'];
    $date_of_register = date('m-d-Y');

    // PHPMailer Configuration
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->Host = "smtp.dreamhost.com";
    $mail->Port = "587";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = "contact@drcoders.com";
    $mail->Password = '^qTTONt8FUW*4tqO';
    $mail->From = "merbokjunction.com";
    $mail->FromName = "Enquiry In - Merbok Junction";

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail->AddReplyTo($email);
    }

    $mail->AddAddress("lilikoay.1@gmail.com", "Support Merbok Junction");
    $mail->isHTML(true);
    $mail->Subject = "Enquiry In " . $website_name . " Website by " . $f_name;

    // Generate the email body
    $message = '<div style="max-width: 700px; font-size:small;">
        <h3>Hi ' . $website_name . ' Family!</h3>
        <table style="max-width: 700px; font-size:small; font-family: arial,sans-serif; border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th colspan="2">
                        <p style="border: 2px solid ' . $color_code . '; color: ' . $color_code . '; text-align: center; padding: 5px 0;">Details</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: ' . $color_code . '; color: #fff;">
                    <td style="width:150px; border-right: 1px solid #fff; padding: 8px;"><b>Customer Name</b></td>
                    <td style="padding: 8px;">' . $f_name . '</td>
                </tr>
                <tr style="background-color: #ffffff; color: ' . $color_code . ';">
                    <td style="width:150px; border-right: 1px solid ' . $color_code . '; padding: 8px;"><b>Mobile Number</b></td>
                    <td style="padding: 8px;">(' . $country_code . ') ' . $mobile_number . '</td>
                </tr>
                <tr style="background-color: ' . $color_code . '; color: #fff;">
                    <td style="width:150px; border-right: 1px solid #fff; padding: 8px;"><b>Email Address</b></td>
                    <td style="padding: 8px;">' . $email . '</td>
                </tr>
                <tr style="background-color: #ffffff; color: ' . $color_code . ';">
                    <td style="width:150px; border-right: 1px solid ' . $color_code . '; padding: 8px;"><b>Know About</b></td>
                    <td style="padding: 8px;">' . $know_about . '</td>
                </tr>';

    // Append "Others" row if provided
    if (!empty($other)) {
        $message .= '<tr style="background-color: ' . $color_code . '; color: #fff;">
                        <td style="width:150px; border-right: 1px solid #fff; padding: 8px;"><b>Others</b></td>
                        <td style="padding: 8px;">' . $other . '</td>
                    </tr>';
    }

    $message .= '</tbody>
        </table>
    </div>';

    $mail->Body = $message;

    if (!$mail->Send()) {
        $data['success'] = false;
        $data['message'] = "Error: Unable to send email. Please try again later.";
    } else {
        $data['success'] = true;
        $data['message'] = "Success, Your information was received successfully. Thank you!";
    }
} else {
    $data['success'] = false;
    $data['message'] = "Error: Please try again later.";
}

// Code for save form data in google sheet.
$google_keys = "AKfycbxwh5_Q5oif9bgCsy6eSGQRa-6jfeNvkajp2XaHXW90Q2VcrH5-8ZKECnzDKswHMduHiA";

$google_data = "Date=" . $date_of_register . "&Name=" . $f_name . "&Email=" . $email . "&Mobile=" . $mobile_number . "&Know=" . $know_about . "";

$new_sheet = str_replace(' ', '%20', $google_data);
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://script.google.com/macros/s/' . $google_keys . '/exec?' . $new_sheet,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$sheet_response = curl_exec($curl);
curl_close($curl);
$data['google_sheet'] = $sheet_response;


echo json_encode($data);