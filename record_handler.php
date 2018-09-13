<?php
include "utils.php";
include "ZohoWrapper.php";
$config = include "config.php";
session_start();

$wrapper = new ZohoWrapper($config['auth_key']);

$required = [
    'last_name',
    'first_name',
    'phone',
    'email',
    'company',
];

// Check required fields
foreach ($required as $field) {
    if ( ! isset($_POST[$field])) {
        redirect('/', "Field {$field} required");
    }
}

// try requested insert
$response = $wrapper->insert([
    'Company' => $_POST['company'],
    'Last_Name' => $_POST['last_name'],
    'First_Name' => $_POST['first_name'],
    'Email' => $_POST['email'],
    'Phone' => $_POST['phone']
]);

$responseCode = $wrapper->getResponseCode($response);

if ($responseCode === ZohoWrapper::CODE_DUPLICATE) {
    $duplicateIdRecord = $response['data'][0]['details']['id'];
    $item = $wrapper->recordById($duplicateIdRecord);

    if ($item === false) {
        redirect('/', "Oops! Record with id {$duplicateIdRecord} not found");
    }

    $convertResponse = $wrapper->convert($item['id'], $item['Owner']['id']);
    redirect('/', 'Record convert to contract success');
} elseif ($responseCode === ZohoWrapper::CODE_SUCCESS) {
    redirect('/', 'Record created');
}
