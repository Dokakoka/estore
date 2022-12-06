<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php" ?>
<?php require_once ROOT."db/select.php" ?>

<?php
if(!isset($_SESSION['auth'])) {
  redirect(URL."index.php");
  die;
}

if(!isset($_GET['id'])) {
  redirect(URL."pages/products/index.php");
  die;
}

if(isset($_SESSION['auth'][2])) {
    unset($_SESSION['auth'][2]);
    unset($_SESSION['auth'][3]);
}
?>
<?php require_once ROOT."pages/inc/header.php" ?>
<?php require_once ROOT."pages/inc/navbar.php" ?>

<?php
$product_data = select("*", "products", "id=".$_GET['id']);
if(empty($product_data)) {
    redirect(URL."pages/products/index.php");
    die;
}
?>
<?php 
$category_data = select("*", "categories", 1);
?>

<div class="content-wrapper">
    <div class="container py-5">
        <form method="POST" action="<?=URL."controllers/products/handleUpdateProduct.php?id=".$_GET['id']?>" enctype="multipart/form-data">
            <div class="row d-flex justify-content-center">
                <div class="col-6">
                        <?php if(isset($_SESSION['errors'])): ?>
                        <?php foreach($_SESSION['errors'] as $error): ?>
                            <div class="alert alert-danger text-center">
                                <?=$error?>
                            </div>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['errors']); ?>
                    <?php endif; ?>
                
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

                    <?php if(isset($_SESSION['file_errors'])): ?>
                        <div class="alert alert-danger text-center">
                            <?=$_SESSION['file_errors']?>
                        </div>
                        <?php unset($_SESSION['file_errors']); ?>
                    <?php endif; ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?=$product_data[0]['name']?>">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Product Price</label>
                            <input type="number" class="form-control" id="name" name="price" value="<?=$product_data[0]['price']?>">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Product QTY</label>
                            <input type="number" class="form-control" id="name" name="qty" value="<?=$product_data[0]['qty']?>">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Product Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" rows="5" style="resize:none;"><?=$product_data[0]['description']?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Category</label>
                            <select class="form-control" name="category" >
                                <?php foreach($category_data as $category): ?>
                                    <option value="<?=$category['id']?>"><?=$category['name']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        
                        <?php if(!empty($product_data[0]['img'])): ?>
                        <?php if(file_exists(ROOT."assets/uploads/products/".$product_data[0]['img'])): ?>
                            <div class="mb-3">
                                <img class="w-25" src="<?=URL."assets/uploads/products/".$product_data[0]['img']?>" alt="Not Found">
                            </div>
                        <?php endif;?>
                        <?php else: ?>
                            <img class="w-25" src="<?=URL."assets/uploads/products/image-not-available.png"?>" alt="Not Found">
                        <?php endif;?>
                        <button type="submit" class="btn btn-primary w-100">Update Product</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<?php require_once ROOT."pages/inc/footer.php" ?>