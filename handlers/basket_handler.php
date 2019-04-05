<?php
    session_start();

    $response = [
        'basket'=>[
            'count'=> 0,
        ]
    ];

    //Добавление товара в корзину
    if( isset( $_GET['product_id'] ) ){
        if( !isset( $_SESSION['basket'] ) ){
            $_SESSION['basket'] = [];
        }

        $is_find = false;
        foreach( $_SESSION['basket'] as $key => $basketItem ){
            if( $basketItem['product_id'] == $_GET['product_id'] ){
                $_SESSION['basket'][$key]['count']++; 
                $is_find = true;   
            }
        }

        if( !$is_find ){
            $_SESSION['basket'][] = [
                'product_id' => $_GET['product_id'],
                'count'=> 1
            ];
        }
    }


    //Подстчет кол-во товаров в корзине
    if( isset( $_SESSION['basket'] ) ){
        foreach( $_SESSION['basket'] as $basketItem ){
            $response['basket']['count'] +=  $basketItem['count'];   
        }
    }

    echo json_encode( $response );
    // $_SESSION

    // unset( $_SESSION['count'] );

    // if( isset( $_SESSION['count'] ) ){
    //     $_SESSION['count']++;
    // }else{
    //     $_SESSION['count'] = 1;
    // }

    // echo $_SESSION['count'];