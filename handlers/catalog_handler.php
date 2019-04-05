<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/config/configuration.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/config/functions.php');
    
    $page = (int) $_GET['page'];
    $section = ( isset( $_GET['section'] ) )  ? $_GET['section'] : 'man';

    $filter_price = ( isset( $_GET['filter_price'] ) ) ? explode('-', $_GET['filter_price']) : [];
    
    $sql_count_rows = "
        SELECT COUNT(id) as len FROM products 
        WHERE id IN 
        (
            SELECT pc.product_id FROM catalogs as p
            JOIN product_catalog as pc ON p.id=pc.catalog_id
            WHERE code = '{$section}'
        )
    ";

    if( !empty( $filter_price ) ){
        $sql_count_rows .= "AND price >={$filter_price[0]} AND  price <={$filter_price[1]}";  
    }

    $result_count_rows = mysqli_query($db, $sql_count_rows);
    $result_count_rows_arr = mysqli_fetch_assoc($result_count_rows);
    $count_rows = $result_count_rows_arr['len'];

    $count_products_on_page = 5;

    // ceil() - округление в большую сторону
    $count_page = ceil($count_rows / $count_products_on_page);

    $response = [
        'products'=>[],
        'pagination'=>[
            'countPage'=> $count_page,
            'nowPage'=>$page
        ]
    ];

    $from_row = $count_products_on_page * ($page - 1);
    /*
        1 - 0
        2 - 5
        3 - 10
    */
    $sql_products = "
        SELECT * FROM products 
        WHERE id IN 
        (
            SELECT pc.product_id FROM catalogs as p
            JOIN product_catalog as pc ON p.id=pc.catalog_id
            WHERE code = '{$section}'
        )";

    if( !empty( $filter_price ) ){
        $sql_products  .= " AND price >={$filter_price[0]} AND  price <={$filter_price[1]}";  
    }

    $sql_products .= " LIMIT {$from_row}, {$count_products_on_page}";
    $result_products = mysqli_query($db, $sql_products);

    while( $row = mysqli_fetch_assoc($result_products) ){
        // d($row);
        $response['products'][] = $row;
    }


    echo json_encode( $response );