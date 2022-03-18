<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate blog post object
    $category = new Category($db);

    //Get ID from URL
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Call read_single method from POST.php
    $category->read_single();

    //json data, create array
    $cat_arr = array(
        'id'=> $category->id,
    'category' => $category->category,
    
);

    //convert to JSON data
    print_r(json_encode($cat_arr));