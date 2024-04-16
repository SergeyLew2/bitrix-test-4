<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
//ini_set('error_reporting',E_ALL);
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$recaptcha_secret = SECRET_KEY_RECAPCHA; // Insert your secret key here
$recaptcha_response = $_POST['token'];

$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
$recaptcha = json_decode($recaptcha);


if($recaptcha -> success == true && $recaptcha -> score >= 0.5 && $recaptcha -> action == 'contact_1') {
   // Это человек.
   $success_output = "Your message sent successfully";
}
else{
    // Оценка меньше 0.5 означает подозрительную активность. Возвращаем ошибку
    $output = ['error' => "Не пройдена капча"];
    echo json_encode($output);
    exit();
}

if($_POST['action'] == 'add' || $_POST['action'] == 'edit'){
    if(empty($_POST['name'])){
        $output = ['error' => 'Не заполнено поле "Имя"'];
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit();
    }
    if(empty($_POST['department'])){
        $output = ['error' => 'Не заполнено поле "Департамент"'];
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit();
    }
    if(empty($_POST['phone'])){
        $output = ['error' => 'Не заполнено поле "Телефон"'];
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit();
    }
    $phone = substr(preg_replace("/[^0-9]/ui", "", $_POST['phone']), -16);
    if(strlen((string)$phone) !== 11){
        $output = ['error' => 'Не верный формат "Телефона"'];
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit();
    }
}


if(strcasecmp($_POST['action'], 'add') === 0){

    if(CModule::IncludeModule("iblock")){
        $props = [];
        $props[29] = ["VALUE" => $_POST['departmentValue']];
        $props[30] = $phone;

        $arLoadProductArray = ["IBLOCK_ID" => 5,
                               "PROPERTY_VALUES"=> $props,
                               "NAME" => $_POST['name'],
                               "ACTIVE" => "Y"];


        $el = new CIBlockElement;

        if($PRODUCT_ID = $el->Add($arLoadProductArray)){
            $output = ['success' => "Успешно"];
            $output['postData'] = ['name' => $_POST["name"],
                                   'department' => $_POST['department'],
                                   'phone' => $phone,
                                   'id' => $PRODUCT_ID];
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
        }
        else{
            $output = ['error' => $el->LAST_ERROR];
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
        }
    }
}
if(strcasecmp($_POST['action'], 'edit') === 0){

    if(CModule::IncludeModule("iblock")){
        $props = [];
        $props[29] = ["VALUE" => $_POST['departmentValue']];
        $props[30] = $phone;

        $arLoadProductArray = ["IBLOCK_ID" => 5,
                               "PROPERTY_VALUES"=> $props,
                               "NAME" => $_POST['name'],
                               "ACTIVE" => "Y"];


        $el = new CIBlockElement;

        if($PRODUCT_ID = $el->Update($_POST['idElem'], $arLoadProductArray)){
            $output = ['success' => "Успешно"];
            $output['postData'] = ['name' => $_POST["name"],
                                   'department' => $_POST['department'],
                                   'phone' => $phone,
                                   'id' => $_POST['idElem']];
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
        }
        else{
            $output = ['error' => $el->LAST_ERROR];
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
        }
    }
}
if(strcasecmp($_POST['action'], 'delete') === 0){
    if(CModule::IncludeModule("iblock")){
        if(CIBlockElement::Delete($_POST['idElem'])){
            $output = ['success' => "Успешно"];
            $output['postData'] = ["id" => $_POST['idElem']];
            echo json_encode($output, JSON_UNESCAPED_UNICODE );
        }
        else{
            $output = ['error' => 'Во время удаления произошла ошибка'];
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
        }
    }
}
?>