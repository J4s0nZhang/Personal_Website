<?php

/* setup variables and status messages */

$from = 'contact form <info@mywebsite.com';

$sendTO = 'contact form <contact.jason.zh@gmail.com';

$subject = 'New message from contact form';

$fields = array('name' => 'Name', 'email' => 'Email', 'message' => 'Message'); 

$okMessage = 'Contact form successfuly submitted. Thank you for your time, I will get back to you soon!'; 

$errorMessage = 'There was an error while submitting the form. Please try again later.';


/* the logic behind sending the email */ 

//turn this off with error_reporting(0)
error_reporting(E_ALL & ~E_NOTICE);

try{
    if(count($_POST) == 0) throw new \Exception('Form is empty');

    $emailText = "New message from your Resume site contact form\n=============================\n";

    //if key is found from fields array from $_POST (field exists), concatenate it to email message
    foreach ($_POST as $key => $value){
        if(isset($fields[$key])){
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    //email header information 
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
        ); 
    
    //send email 
    mail($sendTo, $subject, $emailText, implode("\n", $headers));
    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch(\Exception $e){
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

//if requested by AJAX request, return JSON reponse

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUEST_WITH']) == 'xmlhttprequest')){

    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;

}

//otherwise just echo response message
else {
    echo $responseArrary['message']; 
}