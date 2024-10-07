<?php
// Inclure la connexion à la base de données
require('../../db.php'); 

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
// Uncomment if session management is required
// session_start();
// if ($_SESSION['username'] != 'Anthony') {
//     echo "<script>alert('Merci de contacter l\'admin pour y accéder.');</script>";
//     header('location:index.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Logiciel de Gestion</title>
  <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
  <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../../assets/vendor/css/core.css" />
  <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" />
  <link rel="stylesheet" href="../../assets/css/demo.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
  <script src="../../assets/vendor/js/helpers.js"></script>
  <script src="../../assets/js/config.js"></script>
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?php require('../../nav/menu2.php') ?>
      <div class="layout-page">
        <?php $title = 'Facture'; require('../../nav/header.php') ?>

        <div class="content-wrapper">
          <div class="container-fluid flex-grow-1 container-p-y">
            <div class="card">
              <div class="table-responsive text-nowrap">
                             <button type="button" class="col-4 col-sm-2  btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                  <i class="">+</i>
                                </button>
                <div class="container"><br>
                  <?php
                  $date = htmlspecialchars($_GET["date"]); // Sanitizing user input
                  
                  // Prepared statement with placeholder
                  $selection = $db->prepare("SELECT * FROM detailfilaosortie WHERE dateTranche = :date");
                  $selection->bindParam(':date', $date, PDO::PARAM_STR);
                  $selection->execute();
                  $fetchAll = $selection->fetchAll();
                   
                  ?>
                  <!-- Start the table -->
                  <table class="table table-bordered mt-3">
                    <thead>
                      <tr>
                        <th>classe</th>
                        
                        <th>Quantité</th>
                       
                        <th>Sac</th>
                        <th>Poisson</th>
                        <th>Qtt Tranchee</th>
                        <th>Colis</th>
                        <th>Emballages</th>

                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= htmlspecialchars($id_poisson)?></td>
                            <td><?= htmlspecialchars($qtt_poisson)?></td>
                            <td><?= htmlspecialchars($sac_poisson)?></td>
                            <td>
                                <form action="addstockM.php" method="POST">
                                    <input type="hidden" name="id_poisson" value="<?= htmlspecialchars($id_poisson) ?>">
                                    <input type="hidden" name="EnterDate" value="<?= htmlspecialchars($date) ?>">
                                    <input type="hidden" name="traitType" value="Tranche">
                                                               
                                <select name='nom_poisson' class='form-control'>
                                       <?php 
                                        $sql = "SELECT id, nomfilao FROM poisson ORDER BY nomfilao";
                                        $stmt = $db->prepare($sql);
                                        $stmt->execute();
                                    
                                        $filaos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                        foreach ($filaos as $filao) : ?>
                                            <option value="<?= $filao['nomfilao'] ?> TR"><?= $filao['nomfilao'] ?></option>
                                          <?php endforeach; 
                                          
                                         ?>
                                    </select>
                            
                                    
                            </td>
                            <td>
                                <input type="text" class='form-control' name="qtt" value="">
                            </td>
                            <td>
                                <input type="text" class='form-control'name="sac" value="">
                            </td>
                            <td>
                                <select class='form-control' name='type'>
                                    <option value='2' <?= $trancheData && $trancheData['emballage'] == 'carton' ? 'selected' : '' ?>>
                                        En carton
                                    </option>
                                    <option value='1' <?= $trancheData && $trancheData['emballage'] == 'sac' ? 'selected' : '' ?>>
                                        En sac
                                    </option>
                                </select>
                                <input type="hidden"class='form-control' name="TeteTranche" value="0">
                                <button type="submit" class="btn btn-danger d-none">X</button>
                            </td>
                            
                        </form>
                        </tr>
                       
                      <?php foreach ($fetchAll as $fetch) {
                        $id_poisson = htmlspecialchars($fetch['id_poisson']);
                        $qtt_poisson = htmlspecialchars($fetch['qttTranche']);
                        $sac_poisson = htmlspecialchars($fetch['sac']);
                        $totaltranchee += $qtt_poisson;
                        $totalcolis += $sac_poisson;
                      
                     $sql = "SELECT * FROM tranche WHERE id_poisson = :id_poisson AND date = :date";
                        $selection = $db->prepare($sql);
                        $selection->bindParam(':id_poisson', $id_poisson, PDO::PARAM_INT);
                        $selection->bindParam(':date', $date, PDO::PARAM_STR);
                        $selection->execute();
                        $trancheData = $selection->fetch(PDO::FETCH_ASSOC); // Fetch single row
                        $result = 100 - ((($trancheData['enterTranche'] + $trancheData['TeteTranche']) * 100) / $qtt_poisson);
                        $formattedResult = number_format($result, 2);
                        ?>
                        
                        <!-- HTML Form -->
                        <tr>
                            <td><?= htmlspecialchars($id_poisson)?></td>
                            <td><?= htmlspecialchars($qtt_poisson)?></td>
                            <td><?= htmlspecialchars($sac_poisson)?></td>
                            <td>
                                <form action="addstockM.php" method="POST">
                                    <input type="hidden" name="id_poisson" value="<?= htmlspecialchars($id_poisson) ?>">
                                    <input type="hidden" name="EnterDate" value="<?= htmlspecialchars($date) ?>">
                                    <input type="hidden" name="traitType" value="Tranche">
                                                               
                                <select name='nom_poisson' class='form-control'>
                                       <?php 
                                        $sql = "SELECT id, nomfilao FROM poisson ORDER BY nomfilao";
                                        $stmt = $db->prepare($sql);
                                        $stmt->execute();
                                    
                                        $filaos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                        foreach ($filaos as $filao) : ?>
                                            <option value="<?= $filao['nomfilao'] ?> TR"><?= $filao['nomfilao'] ?></option>
                                          <?php endforeach; ?>
                                          
                                         ?>
                                    </select>
                            
                                    
                            </td>
                            <td>
                                <input type="text" class='form-control' name="qtt" value="<?= $trancheData ? htmlspecialchars($trancheData['enterTranche']) : '' ?>">
                            </td>
                            <td>
                                <input type="text" class='form-control'name="sac" value="<?= $trancheData ? htmlspecialchars($trancheData['Tranchecolis']) : '' ?>">
                            </td>
                            <td>
                                <select class='form-control' name='type'>
                                    <option value='2' <?= $trancheData && $trancheData['emballage'] == 'carton' ? 'selected' : '' ?>>
                                        En carton
                                    </option>
                                    <option value='1' <?= $trancheData && $trancheData['emballage'] == 'sac' ? 'selected' : '' ?>>
                                        En sac
                                    </option>
                                </select>
                                <input type="hidden"class='form-control' name="TeteTranche" value="0">
                                <button type="submit" class="btn btn-danger d-none">X</button>
                            </td>
                            
                            
                        </form>
                        </tr>
                        
                      <?php } ?>

                    </tbody>
                  </table>
                </div>
                <?=require('afficheTranche.php');?>
                
                
                <table class="table table-bordered mt-3">
                    <thead>
                      <tr>
                        <th>classe</th>
                        
                        <th>Sortie Stock</th>
                       
                        <th>Nbr Colis</th>
                        <th>Entrer Stock (TR)</th>
                       
                        <th>Nbr Colis (TR)</th>
                        <th>Ecarts</th>
                        <th>Dessiccations</th>

                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TOTAL</td>
                            <td><?=$totaltranchee;?></td>
                            <td><?=$totalcolis;?></td>
                            <td><?= $TotalEnter ?></td>
                            <td><?= $TotalColis ?></td>
                            <td><?= $totaltranchee - $TotalEnter ?></td>
                            <td><?php $dec = 100- ((100 * $TotalEnter) / $totaltranchee);
                                $dec_formatted = number_format($dec, 2);
                                echo $dec_formatted?></td>
                        </tr>
                    </tbody>
              </div>
            </div>
                        

            <!-- Modal -->
          </div>
        </div>
      </div>
    </div>
  </div>
   <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Ajout Poisson</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="addn.php" method='POST'>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameBasic" class="form-label">Nom</label>
                                      <input type="text" id="nameBasic" class="form-control" placeholder="Non de Poisson" name="nom" />
                                      <input type="hidden" name="date" value="<?=$_GET['date'] ?>" />
                                      <input type="hidden" name="numFact" value="<?= $_GET['numFact'] ?>" />
                                    </div>
                                  </div>


                                </div>
                                <div class="modal-footer">

                                  <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="../../assets/js/main.js"></script>
    <script src="../../assets/js/dashboards-analytics.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
