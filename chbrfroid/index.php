
         <?php
require ('../db.php');
require ('../facture/prix_one_facture.php');
require ('../facture/poid_one_facture.php');

function get_name($id_to_get)
{
    require ('../db.php');
    $new_sql = "SELECT * FROM fournisseur WHERE id = :id";
    $new_st = $db->prepare($new_sql);
    $new_st->bindParam(':id', $id_to_get, PDO::PARAM_INT);
    $new_st->execute();
    $fetch_name = $new_st->fetch();
    return $fetch_name["nomfournisseur"];
}

function is_facture_in_chbr($facture_id)
{
    require ('../db.php');
    $sql = "SELECT COUNT(*) FROM chbr WHERE numeroFacture = :facture_id";
    $st = $db->prepare($sql);
    $st->bindParam(':facture_id', $facture_id, PDO::PARAM_INT);
    $st->execute();
    return $st->fetchColumn() > 0;
}

// Get the date range from the form submission
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Adjust the query based on the provided date range
$sql = "SELECT * FROM facture";
if ($start_date && $end_date) {
    $sql .= " WHERE date BETWEEN :start_date AND :end_date";
}
$sql .= " ORDER BY date DESC";

$stmt = $db->prepare($sql);

if ($start_date && $end_date) {
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
}

$stmt->execute();
$all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

<head>
   <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Logiciel de Gestion</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../assets/js/config.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <?php require('../nav/menu.php')?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <?php $title='Facture'?>
        <?php require('../nav/header.php')?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-fluid flex-grow-1 container-p-y">
            <div class="card">
              <div class="table-responsive text-nowrap">
                <div class="container mt-5">
                  <h2 class="mb-4">Liste Entrer par Factures</h2>
                  <form method="post" action="" class="">
                    <table>
                      <th>
                        <div class="form-group mr-2 ">
                          <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
                        </div>
                      </th>
                      <th>
                        <div class="form-group mr-8">
                          <input type="date" class="form-control" id="end_date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
                        </div>
                      </th>
                      <th>
                        <div class="form-group mr-2">
                          <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                      </th>
                    </table>
                  </form>

                  <!-- Table -->
                  <br>
                  <table class="table table-bordered">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom Fournisseur</th>
                        <th scope="col">Poids Total</th>
                        <th scope="col">Date</th>
                        <!--<th scope="col">Nombre Total</th>-->
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($all_facture as $get_fact):
                          if (poid_total($get_fact['id']) > 0) {
                              $row_class = is_facture_in_chbr($get_fact['id']) ? 'class="table-primary"' : ''; 
                      ?>
                        <tr <?= $row_class ?>>
                          <th scope="row"><?= $get_fact['id'] ?></th>
                          <td><?= get_name($get_fact['id_fou']) ?></td>
                          <td><?= poid_total($get_fact['id']) ?> KG</td>
                          <td><?= $get_fact['date'] ?></td>
                          <td>
                            <a class="btn btn-success" href="entercbr.php?num=<?= $get_fact['id']?>&date=<?= $get_fact['date'] ?>">
                              Ajouter
                            </a>
                          </td>
                        </tr>
                      <?php } endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- / Content -->
      </div>
      <!-- / Layout page -->
    </div>
  </div>

        
              </div>
            </div>
            <!--/ Layout Demo -->
          </div>
          <!-- / Content -->

          <!-- Footer -->


          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->



  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="../assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="../assets/js/main.js"></script>

  <!-- Page JS -->

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
