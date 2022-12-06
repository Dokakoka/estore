<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php" ?>
<?php require_once ROOT."db/select.php" ?>
<?php
if(!isset($_SESSION['auth'])) {
  redirect(URL."index.php");
  die;
}
$_SESSION['auth'][2] = 'client';
$_SESSION['auth'][3] = $_GET['client_id'];
?>

<?php require_once ROOT."pages/inc/header.php" ?>
<?php require_once ROOT."pages/inc/navbar.php" ?>

<?php
$product_data = select("*", "products", "qty>0");
if(empty($product_data)) {
    redirect(URL."pages/products/addProduct.php");
    die;
}
?>



<div class="content-wrapper">
    <div>
        
    </div>
    <div class="container">
      <h1 class="text-center py-5">Products</h1>
        <div class="row">
        <?php if(isset($_SESSION['db_success'])): ?>
                        <div class="alert alert-success text-center">
                            <?=$_SESSION['db_success']?>
                        </div>
                        <?php unset($_SESSION['db_success']); ?>
                    <?php endif; ?>
                
                    <?php if(isset($_SESSION['db_error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?=$_SESSION['db_error']?>
                        </div>
                        <?php unset($_SESSION['db_error']); ?>
                    <?php endif; ?>
            <?php $i=0; foreach($product_data as $product): $i++?>
                <div class="col-md-4 col-12">

                    <?php if(!empty($product['img'])): ?>
                    <?php if(file_exists(ROOT."assets/uploads/products/".$product['img'])):?>
                        <img class="w-100 h-50" src="<?=URL."assets/uploads/products/".$product['img']?>">
                    <?php endif;?>
                    <?php else: ?>
                        <img class="w-100 h-50" src="<?=URL."assets/uploads/products/image-not-available.png"?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5><?= $product['name'] ?></h5>
                        <h5><?= $product['price'] ?> $</h5>
                        <form method="post" action="<?=URL."controllers/orders/handleCart.php?client_id=".$_GET['client_id']."&product_id=".$product['id']?>">
                        <p class="card-text pt-2"><?=$product['description']?></p>
                        <div class="py-1">
                            <input name="qty" class="form-control" value="1" style="width: 28% !important;" type="number" min="1" max="<?= $product['qty'] ?>" onKeyUp="if(this.value><?= $product['qty'] ?>){this.value='<?= $product['qty'] ?>';}else if(this.value<0){this.value='0';}" />
                        </div>
                        <div class="py-3">
                            <input type="submit" class="btn btn-primary" value="Add To Cart">
                            <a href="<?=URL."pages/products/single_product.php?client_id=".$_GET['client_id']."&product_id=".$product['id']?>" class="btn btn-primary">View Product</a>
                        </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require_once ROOT."pages/inc/footer.php" ?>
