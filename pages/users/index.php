<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php" ?>
<?php require_once ROOT."db/select.php" ?>

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

<?php
$client_data = select("*", "users", "type != 'client'");
if(empty($client_data)) {
    redirect(URL."pages/users/addUser.php");
    die;
}
?>


<div class="content-wrapper">

  <h1 class="text-center py-5">Manage Users</h1>

  <div class="container">
      <input type="text" class="form-control" placeholder="Search For Users" id="search" onkeyup="search()">
      <table class="table text-center" id="client_table">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Image</th>
                  <th>Type</th>
                  <th>Edit</th>
                  <th>Delete</th>
              </tr>
          </thead>

          <tbody>
              <?php $i=0; foreach($client_data as $client): $i++?>
                  <tr>
                      <td><?=$i?></td>
                      <td><?=$client['name']?></td>
                      <td><?=$client['email']?></td>
                      <td><?=$client['phone']?></td>
                      <td>
                    <?php if(!empty($client['img'])): ?>
                    <?php if(file_exists(ROOT."assets/uploads/users/".$client['img'])):?>
                            <img class="w-25" src="<?=URL."assets/uploads/users/".$client['img']?>">
                    <?php endif;?>
                    <?php else: ?>
                        <img class="w-25 h-25" src="<?=URL."assets/uploads/users/profile-picture.jpg"?>" class="img-circle elevation-2" alt="User Image">
                    <?php endif; ?>
                      </td>
                      <td><?=$client['type']?></td>
                      <td><a href="<?=URL."pages/users/updateUser.php?id=".$client['id']?>" class="btn btn-success">Edit</a></td>
                      <td><a href="<?=URL."controllers/users/handleDeleteUser.php?id=".$client['id']."&img=".$client['img']?>" class="btn btn-danger">Delete</a></td>
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

        XLSX.writeFile(file, 'usersReport.xlsx');
  }
</script>

<script>
function search() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("client_table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
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
