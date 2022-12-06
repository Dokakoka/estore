<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php" ?>
<?php require_once ROOT."db/select.php" ?>
<?php
if(!isset($_SESSION['auth'])) {
  redirect(URL."index.php");
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
if(!isset($_GET['id'])) {
    redirect(URL."pages/categories/index.php");
}
if(isset($_GET['id'])) {
  $cateogry_data = select("*", "categories", "id=".$_GET['id']);
    if(empty($cateogry_data)) {
      redirect(URL."pages/categories/index.php");
      die;
    }
}
?>

<div class="content-wrapper">
  <div class="container py-5">
          
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
                    <div class="alert alert-error text-center">
                        <?=$_SESSION['db_error']?>
                    </div>
                  <?php unset($_SESSION['db_error']); ?>
              <?php endif; ?>

              <form method="post" action="<?=URL."controllers/categories/handleUpdateCategory.php?id=".$_GET['id']?>" enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="email" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name" value="<?=$cateogry_data[0]['name'];?>">
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Category</button>
              </form>
          </div>
      </div>
  </div>
</div>
<?php require_once ROOT."pages/inc/footer.php" ?>
