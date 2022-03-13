<?php
/*
Template Name: flexible content form
*/
//error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");

if($_SERVER['REQUEST_METHOD'] == 'GET'){
  echo json_encode(['content'=> get_field('contenido_pagina'), 'form'=> get_field('form'), 'form_config'=>['form_name'=> get_field('formID'), 'form_addresses'=> get_field('addresses')]]);
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  
  $secret="6LcKldQUAAAAAFBSLGlbCCbp4xpNxKBqQkLjGlli";
  $response=$_REQUEST["g-recaptcha-response"];
  $verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");

  $captcha_success = json_decode($verify);
  
  if ($captcha_success->success) {
    require $_SERVER['DOCUMENT_ROOT'].'frm/vendor/autoload.php';
    $message = "";
    foreach($_REQUEST as $key => $val){
      if($key !== 'g-recaptcha-response' and $key !== 'ref_page' and $key !== 'form_name' and $key !== 'form_addresses'){
        if(is_array($val) and array_key_exists('label', $val)){
          $label = explode("||",$key);
          $message .= "<strong>". str_replace("_"," ",$label[0]) .": </strong>". $val['label'] ."<br/>";
        }else{
          $label = explode("||",$key);
          $message .= "<strong>". str_replace("_"," ",$label[0]) .": </strong>". $val."<br/>";          
        }

      }
    }
    
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("formularios@prepagolosheroes.cl", "Formularios");
    $email->setSubject($_REQUEST['ref_page'].' utilizando '. $_REQUEST['form_name']);
    
    $dest = $_REQUEST['form_addresses'];
    try {
      if(is_array($dest)){
        for($i=0;$i<count($dest);$i++){
          $email->addTo($dest[$i]);
        }
      }
    
      $email->addCategory("contact_form");

      $email->addContent(
        "text/html", $message
      );
      $sendgrid = new \SendGrid(getenv('CT_API_KEY'));
    
      $response = $sendgrid->send($email);
      echo json_encode(array('status'=>'200'));
    } catch (Exception $e) {
      json_encode(array('status'=>$e->getMessage()));
    }
    
    
  }else{
    echo json_encode(array('status'=>'failed_captcha'));
  }
}
?>
