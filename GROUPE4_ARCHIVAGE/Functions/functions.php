<?php

function loadLib($lib){
    require_once dirname(__DIR__) . '/Libs/' . $lib . '.class.php';
}
spl_autoload_register('loadLib');

function arrayLevelToSelect(array $data): array {
    $array = [];
    foreach($data as $key=>$value){
        $array[$value['id']] = $value['level'];
    }

    return $array;
}
function arrayTrailToSelect(array $data): array {
    $array = [];
    foreach($data as $value){
        $array[$value['id']] = $value['trail'];
    }

    return $array;
}
function arrayDepartmentToSelect(array $data): array {
    $array = [];
    foreach($data as $key=>$value){
        $array[$value['id']] = $value['department'];
    }

    return $array;
}
function arrayFacultyToSelect(array $data): array {
    $array = [];
    foreach($data as $key=>$value){
        $array[$value['id']] = $value['faculty'];
    }

    return $array;
}

function dump($var){
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}