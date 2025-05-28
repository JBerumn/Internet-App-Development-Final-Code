<?php
$db_name = "mysql:host=localhost;dbname=shoppingcart";
$db_user_name = "root";
$db_password = "root";

//Create connection
$conn = new pdo($db_name, $db_user_name, $db_password);

function create_unique_id(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $random = '';
    for($i = 0; $i < 20; $i++) {
        $random .= $characters[rand(0, $charactersLength - 1)];
    }
    return $random;

}