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

<?
$order_data = select("orders.*, products.name as pro_name, products.price as pro_price, products.img as img", "orders INNER JOIN products on orders.product_id = products.id", "client_id=".$_GET['client_id']." and order_status=0");
?>


<div class="content-wrapper">
  <div class="container py-5">
  <input type="text" class="form-control" placeholder="Search For Item" id="search" onkeyup="search()">
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
  
  <table class="table text-center" id="client_table">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Product Name</th>
                  <th>Price</th>
                  <th>QTY</th>
                  <th>Image</th>
                  <th>Total</th>
                  <th>Remove</th>
              </tr>
          </thead>

          <tbody>
              <?php $i=0; foreach($order_data as $order): $i++?>
                  <tr>
                      <td><?=$i?></td>
                      <td><?=$order['pro_name']?></td>
                      <td><?=$order['pro_price']?></td>
                      <td><?=$order['qty']?></td>
                      <td>
                      <?php if(!empty($order['img'])): ?>
                        <?php if(file_exists(ROOT."assets/uploads/products/".$order['img'])):?>
                            <img class="w-25 h-25" src="<?=URL."assets/uploads/products/".$order['img']?>">
                        <?php endif;?>
                        <?php else: ?>
                            <img class="w-25 h-25" src="<?=URL."assets/uploads/products/image-not-available.png"?>" class="img-circle elevation-2" alt="User Image">
                        <?php endif; ?>
                      </td>
                      <td><?=$order['qty']*$order['pro_price']?></td>
                      <td><a href="<?=URL."controllers/orders/handleDeleteOrder.php?order_id=".$order['id']."&client_id=".$_SESSION['auth'][3]?>" class="btn btn-danger">Remove</a></td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
      <div class="d-flex justify-content-center">
      <a class="btn btn-primary" href="<?=URL."pages/products/client_products.php?client_id=".$_SESSION['auth'][3]?>">Back</a>
        <a class="btn btn-primary" href="<?=URL."controllers/orders/handleUpdateOrder.php?client_id=".$_SESSION['auth'][3]?>">Checkout</a>
      </div>
  </div>
</div>
<script>
function search() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("client_table");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
</div>

<?php require_once ROOT."pages/inc/footer.php" ?>