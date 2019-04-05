<?php 
$pageConfig = [
    'title'=>'Карточка товара',
    'cssFiles'=>[
        '/css/style.css'
    ],
    'jsFiles'=>[
        '/js/script.js',
        '/js/product.js'
    ],
];
include($_SERVER['DOCUMENT_ROOT'].'/parts/header.php');

$template = [
    'product'=>[],
    'catalog'=>[]
];

if( isset( $_GET['id'] ) ){
    // логика хождения в БД за данными
    $sql = "SELECT * FROM products WHERE id = {$_GET['id']}";
    $result = mysqli_query($db, $sql);

    $sql_product_catalog = "SELECT * FROM product_catalog WHERE product_id = {$_GET['id']}";
    $result_product_catalog = mysqli_query($db, $sql_product_catalog);
    $catalog_id = mysqli_fetch_assoc($result_product_catalog)['catalog_id'];

    $sql_catalog = "SELECT * FROM catalogs WHERE id = {$catalog_id}";
    $result_catalog = mysqli_query($db, $sql_catalog);

    $template['catalog'] = mysqli_fetch_assoc($result_catalog);

    $template['product'] = mysqli_fetch_assoc($result);
    d($template);
}else{
    header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: /catalog.php"); 
}

//Нужно сходить в БД, получить данные о карточке товара
//Заполнить $template['product']
?>

<?php if( !empty( $template['product'] ) ): ?>
    <!-- Вывод информации о товаре -->
    <div><?=$template['catalog']['name']?></div>
    <div class="product">
        <div class="product-photo">
            <img src="<?=$template['product']['img_src']?>">
        </div>
        <div class="product-name"><?=$template['product']['name']?></div>
        <button data-product-id='<?=$template['product']['id']?>' class='add-to-basket'>Добавить в корзину</button>
    </div>
<?php else: ?>
    <h2>Такого товара нет</h2>
<?php endif;?>

<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/parts/footer.php');
?>
