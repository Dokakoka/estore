<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php" ?>
<?php
if(!isset($_SESSION['auth'])) {
  redirect(URL."index.php");
  die;
}

if(isset($_SESSION['auth'])) {
    if($_SESSION['auth'][1] == 'user') {
      redirect(URL."index.php");
      die;
    }
}

if(isset($_SESSION['auth'][2])) {
    unset($_SESSION['auth'][2]);
    unset($_SESSION['auth'][3]);
}
?>
<?php require_once ROOT."pages/inc/header.php" ?>
<?php require_once ROOT."pages/inc/navbar.php" ?>
<div class="content-wrapper">
    <div class="container py-5">
        <form method="POST" action="<?=URL."controllers/categories/handleAddCategory.php"?>">
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
                        <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Category</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<?php require_once ROOT."pages/inc/footer.php" ?>