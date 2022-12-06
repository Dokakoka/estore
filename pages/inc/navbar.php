<?php require_once "header.php"; ?>
<?php require_once ROOT."db/select.php" ?>
<?php
if(isset($_SESSION['auth'][0])) {
  $user_data = select("*", "users", "id=".$_SESSION['auth'][0]);
  if(empty($user_data)) {
      redirect(URL."pages/users/index.php");
      die;
  }
}

$order_data = select("orders.*, products.name as pro_name, products.price as pro_price, products.img as img", "orders INNER JOIN products on orders.product_id = products.id", "order_status=0");
      
?>
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?=URL."assets/img/AdminLTELogo.png"?>" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav w-100 d-flex justify-content-between">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <?php if(isset($_SESSION['auth'][2])): ?>
      <?php if($_SESSION['auth'][2] == 'client'): ?>
        
        <li class="nav-item">
        <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><i class="nav-icon fas fa-shopping-cart"></i></a>
      </li>
      <?php endif;?>
      <?php endif;?>
    </ul>

    
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Shopping Cart</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul style="list-style: none;">
    <?php if(isset($_SESSION['auth'][2])): ?>
      <?php if($_SESSION['auth'][2] == 'client'): ?>
        <?php $total = 0; ?>
        <?php foreach($order_data as $order): ?>
          <?php
            $total += $order['qty'] * $order['pro_price'];
          ?>
        <li class="d-flex justify-content-between align-items-center py-3">
          <div class="w-50">
          <?php if(!empty($order['img'])): ?>
          <?php if(file_exists(ROOT."assets/uploads/products/".$order['img'])):?>
            <img class="w-50 h-100" src="<?=URL."assets/uploads/products/".$order['img']?>" class="brand-image img-circle elevation-3" style="opacity: .8">
          <?php endif;?>
          <?php else: ?>
              <img class="w-50 h-10" src="<?=URL."assets/uploads/products/image-not-available.png"?>" class="img-circle elevation-2" alt="User Image">
          <?php endif; ?>
          </div>
          <div class="w-50">
            <span><?=$order['pro_name'] ?></span>
            <span><?=$order['qty'] ?>x <?=$order['pro_price'] ?> $</span>
          </div>
        </li>
      <?php endforeach;?>
      <div class="d-flex justify-content-between align-content-center pt-3">
        <a class="btn btn-primary"  href="<?=URL."pages/orders/client_order.php?client_id=".$_GET['client_id']?>">View Cart</a>
        <h4>Total: <?=$total?> $</h4>
      </div>
      <?php endif;?>
      <?php endif;?>
    </ul>
  </div>
</div>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php if(isset($_SESSION['auth'])):?>

      <a href="#" class="brand-link">
        <img src="<?=URL."assets/img/AdminLTELogo.png"?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Dashboard</span>
      </a>
    <?php endif; ?>

    <?php if(!isset($_SESSION['auth'])):?>

      <a href="#" class="brand-link">
        <img src="<?=URL."assets/img/AdminLTELogo.png"?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Welcome User</span>
      </a>
      <?php endif; ?>

    <!-- Sidebar -->
    <div class="sidebar">
    <?php if(isset($_SESSION['auth'])):?>

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        
        <?php if(!empty($user_data[0]['img'])): ?>
          <?php if(file_exists(ROOT."assets/uploads/users/".$user_data[0]['img'])):?>
            <img src="<?=URL."assets/uploads/users/".$user_data[0]['img']?>" class="img-circle elevation-2" alt="User Image">
          <?php endif; ?>
          
            <?php else: ?>
            <img src="<?=URL."assets/uploads/users/profile-picture.jpg"?>" class="img-circle elevation-2" alt="User Image">
          <?php endif; ?>
          
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $user_data[0]['name']; ?></a>
        </div>
      </div>
      <?php endif; ?>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php if(!isset($_SESSION['auth'])):?>
            <li class="nav-item">
                <a href="<?= URL."index.php" ?>" class="nav-link">
                  <i class="nav-icon fas fa-sign-in-alt"></i>
                  <p>
                    Login
                  </p>
                </a>
              </li>
      <?php endif; ?>

        
        <?php if(isset($_SESSION['auth'])):?>
          <?php if($_SESSION['auth'][1] == 'admin'): ?>
          <li class="nav-item ">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Users
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL."pages/users/index.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL."pages/users/addUser.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Users</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                  Clients
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL."pages/clients/index.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Clients</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL."pages/clients/addClient.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Client</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= URL."pages/orders/index.php" ?>" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                View Orders
              </p>
            </a>
          </li>

          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
                <p>
                  Categories
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL."pages/categories/index.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL."pages/categories/addCategory.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Category</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tshirt"></i>
                <p>
                  Products
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL."pages/products/index.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL."pages/products/addProduct.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Product</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Profile
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL."pages/users/updateUser.php?id=".$_SESSION['auth'][0] ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Profile</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= URL."pages/users/logout.php" ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          <?php endif; ?>
          <?php if($_SESSION['auth'][1] == 'user'): ?>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                  Clients
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL."pages/clients/index.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Clients</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL."pages/clients/addClient.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Client</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= URL."pages/orders/index.php" ?>" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                View Orders
              </p>
            </a>
          </li>

          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
                <p>
                  Categories
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL."pages/categories/index.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Categories</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tshirt"></i>
                <p>
                  Products
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL."pages/products/index.php" ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Products</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Profile
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL."pages/users/updateUser.php?id=".$_SESSION['auth'][0] ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Profile</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= URL."pages/users/logout.php" ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
            <?php endif; ?>
            <?php endif; ?>
        
          </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


  <?php require_once "footer.php"; ?>