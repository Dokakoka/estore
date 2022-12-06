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
$client_data = select("*", "users", "type='client'");
if(empty($client_data)) {
    redirect(URL."pages/clients/addClient.php");
    die;
}
?>


<div class="content-wrapper">
  <h1 class="text-center py-5">Manage Clients</h1>

  <div class="container">
      <input type="text" class="form-control mb-3" placeholder="Search For Clients" id="search" onkeyup="search()">
      <table class="table text-center" id="client_table">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Client Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Buy Products</th>
                  <th>Edit</th>
                  <?php if($_SESSION['auth'][1] == 'admin'): ?>
                    <th>Delete</th>
                  <?php endif; ?>
              </tr>
          </thead>

          <tbody>
              <?php $i=0; foreach($client_data as $client): $i++?>
                  <tr>
                      <td><?=$i?></td>
                      <td><?=$client['name']?></td>
                      <td><?=$client['email']?></td>
                      <td><?=$client['phone']?></td>
                      <td><a href="<?=URL."pages/products/client_products.php?client_id=".$client['id']?>" class="btn btn-success">Buy Products</a></td>
                      <td><a href="<?=URL."pages/clients/updateClient.php?id=".$client['id']?>" class="btn btn-success">Edit</a></td>
                      <?php if($_SESSION['auth'][1] == 'admin'): ?>
                        <td><a href="<?=URL."controllers/clients/handleDeleteClient.php?id=".$client['id']?>" class="btn btn-danger">Delete</a></td>
                      <?php endif; ?>
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
        var data = document.getElementById('client_table');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: 'xlsx', bookSST: true, type: 'base64' });

        XLSX.writeFile(file, 'clientsReport.xlsx');
  }
</script>

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
<?php require_once ROOT."pages/inc/footer.php" ?>
