<?php
// Inclure la connexion à la base de données
require('../db.php'); 

// Requête SQL pour obtenir les informations avec les totaux de qtt et sac
$sql = "
SELECT nom_poisson, 
       SUM(retourhiere) as retourhiere, 
       SUM(PEnter) as PEnter, 
       SUM(qtt) as qtt, 
       SUM(retour) as retour, 
       SUM(sortie) as sortie, 
       type, 
       SUM(sac) as sac,
       (SELECT SUM(dfs.qtt) + SUM(dfs.qttTranche) + SUM(dfs.QttMelange) + SUM(dfs.QttVente)
        FROM detailfilaosortie dfs 
        WHERE dfs.id_poisson = ts.nom_poisson) as total_qtt_sortie,
       (SELECT SUM(dfs.sac) 
        FROM detailfilaosortie dfs 
        WHERE dfs.id_poisson = ts.nom_poisson) as total_sac_sortie
FROM testStock ts
GROUP BY nom_poisson, type";

$stmt = $db->prepare($sql);

$stmt->execute();
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
// session_start();
// if ($_SESSION['username']!='Anthony') {
//   ?>
//     <script>
//       alert("Merci de contacter l'admin pour y accéder.")
//     </script>
//   <?php
//     header('location:index.php');
// }
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

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

<div class="container"><br>
    <table>
        <tr>
            <th>
                <button id='openModalBtn' class='btn btn-success'>
                    Sortie Melange
                </button>
            </th>
            <th>
                
            </th>
             <th>
                <p>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</p>
            </th>
             <th>
                <p>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</p>
            </th>

            <th>
                <a href='sortie/operationMelange.php?date=<?= $_GET['date']?>' class='btn btn-primary'>
                    Operation Melange
                </a>
            </th>
             <th>
                <p>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</p>
            </th>
             <th>
                <p>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</p>
            </th>
            <form method='POST' action='sortie/dateMelange.php'>
            <th>
                
                    <input type='date' name='date' class='form-control'>
               
            </th>
             <th>
                <p>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</p>
            </th>
            <th>
                <input type='submit' value='ok' class='btn btn-primary'>
                </form>
            </th>
                
        </tr>
    </table>

    

    
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Articles</th>
                <th>Poids Stock (kg)</th>
                <th>Colis type</th>
                <th>Nbr colis</th>
                <th>P. charger</th>
                <th>Nbr C. Sortie</th>
                <th>Qtt Sortie</th>
                <th>Colis Sortie</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($stocks)): ?>
                <?php foreach ($stocks as $stock): ?>
                    <tr>
                        <form action="sortie/addMelange.php" method="POST">
                            <td>
                                <?= htmlspecialchars($stock['nom_poisson']) ?>
                                <input type="hidden" class="form-control w-50" value="<?= htmlspecialchars($stock['nom_poisson']) ?>" name="poisson">
                                <input type="hidden" name="date" value="<?= htmlspecialchars($_GET["date"]) ?>">
                            </td>
                            
                           <td>
                                <?= number_format(
                                    (float)$stock['qtt'] + (float)$stock['retourhiere'] - (float)$stock['total_qtt_sortie'], 
                                    2
                                ); ?>
                            </td>

                            <td>
                                <select name="typ" class="form-control">
                                    <option value="1" <?= $stock['type'] == 1 ? 'selected' : '' ?>>en Sac</option>
                                    <option value="2" <?= $stock['type'] == 2 ? 'selected' : '' ?>>en Carton</option>
                                </select>
                            </td>
                            <td><?= number_format((float)$stock['sac'], 2) - number_format((float)$stock['total_sac_sortie'], 2) ?></td>
                            <td><input type="text" class="form-control w-100" name="qtt"></td>
                            <td><input type="text" class="form-control w-100" name="sac"></td>
                            <td><?= number_format((float)$stock['total_qtt_sortie'], 2) ?></td>
                            <td><?= number_format((float)$stock['total_sac_sortie'], 2) ?></td>
                            <td>
                                <input type="submit" value="OK" class="form-control d-none btn-success">
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">Aucun enregistrement trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Tranche</h2>
        <?php
        $date = $_GET["date"];
        
        // Prepared statement with placeholder
        $selection = $db->prepare("SELECT * FROM detailfilaosortie WHERE DateMelange = :date");
        
        // Binding the date parameter securely
        $selection->bindParam(':date', $date, PDO::PARAM_STR);
        
        // Executing the query
        $selection->execute();
        $fetchAll = $selection->fetchAll();
        
        ?>
        
        <!-- Start the table -->
        <table>
            <thead>
                <tr>
                    <th>Poisson</th>
                    <th>Quantité</th>
                    <th>Sac</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the results
                foreach ($fetchAll as $fetch) {
                    $id_poisson = $fetch['id_poisson'];
                    $qtt_poisson = $fetch['Qttmelange'];
                    $sac_poisson = $fetch['sac'];
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($id_poisson) ?></td>
                        <td><?= htmlspecialchars($qtt_poisson) ?></td>
                        <td><?= htmlspecialchars($sac_poisson) ?></td>
                        <td>
                            <form action="sortie/deleteMelange.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce poisson ?');">
                                <input type="hidden" name="id_poisson" value="<?= htmlspecialchars($id_poisson) ?>">
                                <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">
                                <button type="submit" class="btn btn-danger">X</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

    </div>
</div>

<style>
    /* Style de base pour masquer le modal */
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    background-color: rgba(0, 0, 0, 0.4);
}

/* Contenu du modal */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
    max-width: 800px; /* Largeur maximum */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    animation-name: animatetop;
    animation-duration: 0.4s;
    border-radius: 10px;
}

/* Animation */
@keyframes animatetop {
    from { top: -50px; opacity: 0; }
    to { top: 0; opacity: 1; }
}

/* Bouton de fermeture */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Responsiveness pour petits écrans */
@media screen and (max-width: 768px) {
    .modal-content {
        width: 95%; /* Réduit la largeur sur les petits écrans */
    }
}

</style>

  <!-- / Layout wrapper -->
    <script>
        // Ouvre le modal
        let modal = document.getElementById("myModal");
        let btn = document.getElementById("openModalBtn");
        let span = document.getElementsByClassName("close")[0];
        
        btn.onclick = function() {
            modal.style.display = "block";
        }
        
        // Ferme le modal quand on clique sur "x"
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        // Ferme le modal si l'utilisateur clique en dehors
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    </script>
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
