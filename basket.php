<?php 
$pageConfig = [
    'title'=>'Корзина',
    'cssFiles'=>[
        '/css/style.css',
        '/css/basket.css'
    ],
    'jsFiles'=>[
        '/js/script.js'
    ],
];
include($_SERVER['DOCUMENT_ROOT'].'/parts/header.php');
session_start();

$template = [
    'products'=>[]
];

echo "<pre>";
print_r($_SESSION);
echo "</pre>";

foreach( $_SESSION['basket'] as $basketItem ){
    $sql = "SELECT * FROM products WHERE id = {$basketItem['product_id']}";
    $result = mysqli_query( $db, $sql );

    $product = mysqli_fetch_assoc($result);
    $product['count'] = $basketItem['count'];
    $product['final_price'] = $basketItem['count'] * $product['price'];
    $template['products'][] = $product;

    // echo "<pre>";
    // print_r($product);
    // echo "</pre>";  
}
?>

<div class='basket-box'>
    <?php if( !empty( $template['products'] ) ): ?>
        <?php foreach( $template['products'] as $productItem ): ?>
            <div class="basket-box-item">
                <div class="basket-box-item-name"><?=$productItem['name']?></div>
            </div>
        <?php endforeach;?>
    <?php else: ?>
        <h3>Корзина пуста</h3>
    <?php endif; ?>
</div>

<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/parts/footer.php');
?>
