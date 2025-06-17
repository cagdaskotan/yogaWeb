<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';



//SERVER SETTINGS
/*
function sender($subject,$message,$email){
    $mail = new PHPMailer(true);
    $mail->CharSet = 'utf-8';    
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->SMTPAuth   = false;
    $mail->Username   = 'team@myruijie.com';
    $mail->Password   = 'Mr123654**';
    $mail->Port       = 25;
    $mail->setFrom('team@myruijie.com',$subject);
    $mail->addBCC('alptolga@gmail.com');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $message;
    if($mail->send()){
        return true;
    }else{
        return $mail->ErrorInfo;
    }
}
*/

//Local Settings

function sender($subject,$message,$email){
    $mail = new PHPMailer(true);
    $mail->CharSet = 'utf-8';    
    $mail->SMTPDebug = 0;
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    //$mail->Host = 'n1smtpout.europe.secureserver.net';
    //$mail->Host = 'localhost';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@e-tusekon.com';
    $mail->Password   = 'Zs123654*';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->setFrom('info@e-tusekon.com',$subject);
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $message;
    if($mail->send()){
        return true;
    }else{
        return $mail->ErrorInfo;
    }
}

/*
function sender($subject,$message,$email){
    $mail = new PHPMailer(true);
    $mail->CharSet = 'utf-8';    
    $mail->SMTPDebug = 0;
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    //$mail->Host       = 'smtp.office365.com';    
    //$mail->Host = 'n1smtpout.europe.secureserver.net';
    $mail->Host = 'localhost';
    $mail->SMTPAuth   = false;
    $mail->Username   = 'info@e-tusekon.com';
    $mail->Password   = 'Zs123654*';
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = 25;
    $mail->setFrom('info@e-tusekon.com',$subject);
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $message;
    if($mail->send()){
        return true;
    }else{
        return $mail->ErrorInfo;
    }

}
*/

function mailTheme($subject, $content) {
    $html = '';
    $html .= '<table class="body-wrap" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>';
    $html .= '<td class="container" width="600" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">';
    $html .= '<div class="content" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">';
    $html .= '<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-wrap" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0; padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); border-radius: 7px; background-color: #fff;" valign="top">';
    $html .= '<meta itemprop="name" content="Confirm Email" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />';
    $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; text-align: center;" valign="top">';
    $html .= '<div style="text-align: center; margin-bottom: 15px;">';
    $html .= '<img src="https://www.e-tusekon.com/assets/images/e-tusekon-dark.png" alt="" width="300">';
    $html .= '</div>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; line-height: 1.5; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px; text-align: center; font-weight: 500;" valign="top">';
    $html .= stripslashes(strip_tags($subject));
    $html .= '</td>';
    $html .= '</tr>';

    if (is_array($content)) {
        foreach ($content as $c) {
            $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
            $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; color: #878a99; line-height: 1.5; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 24px; text-align: center;" valign="top">';
            $html .= $c;
            $html .= '</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
        $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; color: #878a99; line-height: 1.5; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 24px; text-align: center;" valign="top">';
        $html .= $content;
        $html .= '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>'; // closes inner table
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>'; // closes .main table
    $html .= '</div>';
    $html .= '</td>';
    $html .= '<td style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>';
    $html .= '</tr>';
    $html .= '</table>'; // closes .body-wrap table

    return $html;
}

function basic_action($text) {
    $html = '';
    $html .= '<table class="body-wrap" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>';
    $html .= '<td class="container" width="600" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">';
    $html .= '<div class="content" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">';
    $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-wrap" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;" valign="top">';
    $html .= '<meta itemprop="name" content="Confirm Email" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />';
    $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">';
    $html .= '<div style="margin-bottom: 15px;">';
    $html .= '<img src="https://www.e-tusekon.com/assets/images/e-tusekon-dark.png" alt="" height="23">';
    $html .= '</div>';
    $html .= '</td>';
    $html .= '</tr>';
    if(is_array($text)){
        foreach($text as $t){
            $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
            $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 20px; line-height: 1.5; font-weight: 500; vertical-align: top; margin: 0; padding: 0 0 10px;" valign="top">';
            $html .= '<p>'.$t.'</p>';
            $html .= '</td>';
            $html .= '</tr>';
        }
    }else{
        $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
        $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 20px; line-height: 1.5; font-weight: 500; vertical-align: top; margin: 0; padding: 0 0 10px;" valign="top">';
        $html .= '<p>'.$text.'</p>';
        $html .= '</td>';
        $html .= '</tr>';
    }

    

    $html .= '</table>';

    $html .= '</div>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>';

    return $html;
}


function subscription($text) {
    $html = '';
    $html .= '<table class="body-wrap" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>';
    $html .= '<td class="container" width="600" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">';
    $html .= '<div class="content" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">';
    $html .= '<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-wrap" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;" valign="top">';
    $html .= '<meta itemprop="name" content="Confirm Email" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />';
    $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; text-align: center;" valign="top">';
    $html .= '<div style="text-align: center;margin-bottom: 15px;">';
    $html .= '<img src="https://www.e-tusekon.com/assets/images/e-tusekon-dark.png" alt="" height="23">';
    $html .= '</div>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; line-height: 1.5; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;text-align: center; font-weight: 500;" valign="top">';
    $html .= htmlspecialchars($text);
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; color: #878a99; line-height: 1.5; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 24px; text-align: center;" valign="top">';
    $html .= 'Since yesterday, I\'ve been receiving thousands of emails, asking me to confirm the subscription.';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 24px; text-align: center;" valign="top">';
    $html .= '<a href="#" itemprop="url" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: .8125rem;font-weight: 400; color: #FFF; text-decoration: none;text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background-color: #0ab39c; margin: 0; border-color: #0ab39c; border-style: solid; border-width: 1px; padding: .5rem .9rem;" onMouseOver="this.style.background=\'#099885\'" onMouseOut="this.style.background=\'#0ab39c\'">Yes, subscribe me</a>';
    $html .= '</td>';
    $html .= '</tr>';

    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; border-top: 1px solid #e9ebec;">';
    $html .= '<td class="content-block" style="color: #878a99; text-align: center;font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0; padding-top: 15px" valign="top">';
    $html .= 'If you received this email by mistake, simply delete it. You won\'t be subscribed if you don\'t click the confirmation link above.';
    $html .= '</td>';
    $html .= '</tr>';

    $html .= '</table>';
    $html .= '<div style="text-align: center; margin: 0px auto;">';
    $html .= '<ul style="list-style: none;display: flex; justify-content: space-evenly; padding-top: 25px;margin-bottom: 20px; padding-left: 0px; font-family: \'Roboto\', sans-serif;">';
    $html .= '<li>';
    $html .= '<a href="#" style="color: #495057;">Help Center</a>';
    $html .= '</li>';
    $html .= '<li>';
    $html .= '<a href="#" style="color: #495057;">Support 24/7</a>';
    $html .= '</li>';
    $html .= '<li>';
    $html .= '<a href="#" style="color: #495057;">Account</a>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '<p style="font-family: \'Roboto\', sans-serif; font-size: 14px;color: #98a6ad; margin: 0px;">2022 Velzon. Design & Develop by Themesbrand</p>';
    $html .= '</div>';

    $html .= '</div>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>';

    return $html;
}


function email_verify($text) {
    $html = '';
    $html .= '<table class="body-wrap" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>';
    $html .= '<td class="container" width="600" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">';
    $html .= '<div class="content" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">';
    $html .= '<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-wrap" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;" valign="top">';
    $html .= '<meta itemprop="name" content="Confirm Email" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />';
    $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
        $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; text-align: center;" valign="top">';
            $html .= '<div style="text-align: center;margin-bottom: 15px;">';
                $html .= '<img src="https://www.e-tusekon.com/assets/images/e-tusekon-dark.png" alt="" height="23">';
            $html .= '</div>';
        $html .= '</td>';
    $html .= '</tr>';
    if(is_array($text)){
        foreach($text as $t){
            $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
                $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; line-height: 1.5; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;text-align: center; font-weight: 500;" valign="top">';
                    $html .= '<p>'.$t.'</p>';
                $html .= '</td>';
            $html .= '</tr>';
        }        
    }else{
        $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
            $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; line-height: 1.5; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;text-align: center; font-weight: 500;" valign="top">';
                $html .= '<p>'.$text.'</p>';
            $html .= '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    /*
    $html .= '<div style="text-align: center; margin: 0px auto;">';
        $html .= '<ul style="list-style: none;display: flex; justify-content: space-evenly; padding-top: 25px;margin-bottom: 20px; padding-left: 0px; font-family: \'Roboto\', sans-serif;">';
            $html .= '<li>';
                $html .= '<a href="#" style="color: #495057;">Help Center</a>';
            $html .= '</li>';
            $html .= '<li>';
                $html .= '<a href="#" style="color: #495057;">Support 24/7</a>';
            $html .= '</li>';
            $html .= '<li>';
                $html .= '<a href="#" style="color: #495057;">Account</a>';
            $html .= '</li>';
        $html .= '</ul>';
        $html .= '<p style="font-family: \'Roboto\', sans-serif; font-size: 14px;color: #98a6ad; margin: 0px;">2022 Velzon. Design & Develop by Themesbrand</p>';
    $html .= '</div>';*/

    $html .= '</div>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>';

    return $html;
}

function change_pass($content) {
    $html = '';
    $html .= '<table class="body-wrap" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>';
    $html .= '<td class="container" width="600" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">';
    $html .= '<div class="content" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">';
    $html .= '<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-wrap" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;" valign="top">';
    $html .= '<meta itemprop="name" content="Change Password" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />';
    $html .= '<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
    $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; text-align: center;" valign="top">';
    $html .= '<div style="text-align: center;margin-bottom: 15px;">';
    $html .= '<img src="https://www.e-tusekon.com/assets/images/e-tusekon-dark.png" alt="" height="150">';
    $html .= '</div>';
    $html .= '</td>';
    $html .= '</tr>';


    if (is_array($content)) {
        foreach ($content as $c) {
            $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
            $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; color: #878a99; line-height: 1.5; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 24px; text-align: center;" valign="top">';
            $html .= $c;
            $html .= '</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">';
        $html .= '<td class="content-block" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; color: #878a99; line-height: 1.5; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 24px; text-align: center;" valign="top">';
        $html .= $content;
        $html .= '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    $html .= '</div>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>';

    return $html;
}

/*
$text = 'Hello, this is a test email.';
$arr = [
    "Sayın Kullanıcı,",
    '<a href="#" itemprop="url" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: .8125rem;font-weight: 400; color: #FFF; text-decoration: none;text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background-color: #0ab39c; margin: 0 10px 0 0; border-color: #0ab39c; border-style: solid; border-width: 1px; padding: .5rem .9rem;" onMouseOver="this.style.background=\'#099885\'" onMouseOut="this.style.background=\'#0ab39c\'">Yes, subscribe me</a>
    <a href="#" itemprop="url" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: .8125rem;font-weight: 400; color: #FFF; text-decoration: none;text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background-color: #f06548; margin: 0; border-color: #f06548; border-style: solid; border-width: 1px; padding: .5rem .9rem;" onMouseOver="this.style.background=\'#cc563d\'" onMouseOut="this.style.background=\'#f06548\'">Yes, subscribe me</a>',
];
$messages = [
    'Sayın Kullanıcı ',
    'Parolanızı sıfırlamak için aşağıdaki bağlantıya tıklayınız.',
    '<a href="https://www.e-tusekon.com/panel/reset-password.php?token=" itemprop="url" style="font-family: \'Roboto\', sans-serif; box-sizing: border-box; font-size: .8125rem;font-weight: 400; color: #FFF; text-decoration: none;text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background-color: #0ab39c; margin: 0 10px 0 0; border-color: #0ab39c; border-style: solid; border-width: 1px; padding: .5rem .9rem;" onMouseOver="this.style.background=\'#099885\'" onMouseOut="this.style.background=\'#0ab39c\'">Sıfırla</a>',
    'Şifre sıfırlama talebi sizin tarafınızdan yapılmadıysa veya bir sorun olduğunu düşünüyorsanız, lütfen bu e-postayı dikkate almayın.',
];
*/
//echo change_pass($messages);
//sender('TEst','e-tusekon Email','atalaygundogdu@gmail.com');


?>







