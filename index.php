<?php require_once "core/config.php" ?>
<?php require_once ROOT."pages/inc/header.php" ?>
<?php require_once ROOT."pages/inc/navbar.php" ?>

<div class="content-wrapper">
    <div class="container py-5">
        <form method="POST" action="<?=URL."controllers/users/handleLogin.php"?>">
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
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once ROOT."pages/inc/footer.php" ?>