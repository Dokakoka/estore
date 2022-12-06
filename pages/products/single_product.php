<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php" ?>
<?php require_once ROOT."db/select.php" ?>
<?php
if(!isset($_SESSION['auth'])) {
  redirect(URL."index.php");
  die;
}
?>
<?php require_once ROOT."pages/inc/header.php" ?>
<?php require_once ROOT."pages/inc/navbar.php" ?>
<?php $product = select("*", "products", "id=".$_GET['product_id']); ?>




<div class="content-wrapper">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
            <?php if(!empty($product[0]['img'])): ?>
                    <?php if(file_exists(ROOT."assets/uploads/products/".$product[0]['img'])):?>
                <img class="w-90 h-50" src="<?=URL."assets/uploads/products/".$product[0]['img']?>">
                <?php endif;?>
                    <?php else: ?>
                        <img class="w-90 h-50" src="<?=URL."assets/uploads/products/image-not-available.png"?>">
                    <?php endif; ?>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h5><?= $product[0]['name'] ?></h5>
                    <h5><?= $product[0]['price'] ?> $</h5>
                    <form method="post" action="<?=URL."controllers/orders/handleCart.php?client_id=".$_GET['client_id']."&product_id=".$product[0]['id']?>">
                        <input class="form-control" name="qty" value="1" style="width: 28% !important;" type="number" min="1" max="<?= $product[0]['qty'] ?>" onKeyUp="if(this.value><?= $product[0]['qty'] ?>){this.value='<?= $product[0]['qty'] ?>';}else if(this.value<0){this.value='0';}" />
                        <p class="card-text pt-2"><?=$product[0]['description']?></p>
                        <input type="submit" class="btn btn-primary" value="Add To Cart">
                    </form>
                </div>
            </div>
            </div>
        </div>
        <div class="text-center">
            <a class="btn btn-primary" href="<?=URL."pages/products/client_products.php?client_id=".$_GET['client_id']?>">View Products</a>
        </div>
    </div>
</div>
<?php require_once ROOT."pages/inc/footer.php" ?>
