<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."db/select.php" ?>
<?php require_once ROOT."core/functions.php" ?>
<?php
if(!isset($_SESSION['auth'])) {
  redirect(URL."index.php");
  die;
}
?>

<?php require_once ROOT."pages/inc/header.php" ?>
<?php require_once ROOT."pages/inc/navbar.php" ?>

<?php
$order_data = select("orders.*, products.name AS product_name, products.price as price, products.img as img, users.name AS user_name, users.phone AS user_phone", "orders INNER JOIN users ON users.id = orders.client_id
INNER JOIN products on products.id = orders.product_id", "order_status=1");
if(empty($order_data)) {
    redirect(URL."pages/clients/index.php");
    die;
}
?>

<div class="content-wrapper">

  <h1 class="text-center pt-5">Orders</h1>
  <div class="container py-5">
      <input type="text" class="form-control mb-3" placeholder="Search For Orders" id="search" onkeyup="search()">
      <table class="table text-center" id="orders_table">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Client Name</th>
                  <th>Client Phone</th>
                  <th>Product Name</th>
                  <th>Product Price</th>
                  <th>QTY</th>
                  <th>Total</th>
                  <th>Image</th>
              </tr>
          </thead>

          <tbody>
              <?php $i=0; foreach($order_data as $order): $i++?>
                  <tr>
                      <td><?=$i?></td>
                      <td><?=$order['user_name']?></td>
                      <td><?=$order['user_phone']?></td>
                      <td><?=$order['product_name']?></td>
                      <td><?=$order['price']?></td>
                      <td><?=$order['qty']?></td>
                      <td><?=$order['qty']*$order['price']?></td>
                      <td>
                      <?php if(!empty($order['img'])): ?>
                        <?php if(file_exists(ROOT."assets/uploads/products/".$order['img'])):?>
                          <img class="w-25 h25" src="<?=URL."assets/uploads/products/".$order['img']?>">
                        <?php endif;?>
                        <?php else: ?>
                          <img class="w-25 h-25" src="<?=URL."assets/uploads/products/image-not-available.png"?>" class="img-circle elevation-2" alt="User Image">
                          <?php endif;?>
                      </td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
      <div class="d-flex justify-content-center">
        <button class="btn btn-success" onclick="genExcel()">Generate Excel <i class="far fa-file-excel"></i></button>
      </div>
  </div>
</div>

<script>
  function genExcel() {
        var data = document.getElementById('orders_table');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: 'xlsx', bookSST: true, type: 'base64' });

        XLSX.writeFile(file, 'ordersReport.xlsx');
  }
</script>

<script>
function search() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("orders_table");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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
<?php require_once ROOT."pages/inc/footer.php" ?>
