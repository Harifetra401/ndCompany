<?php
// Inclure la connexion à la base de données
require('../../db.php'); 
$date = $_GET['date'];
$dateTime = new DateTime($date);

// Configurer le formateur de date pour le français
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);

// Formater la date
$formattedDate = $formatter->format($dateTime);
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
                <div class="container"><br>
                  <?php
                  $date = htmlspecialchars($_GET["date"]); // Sanitizing user input
                  
                  // Prepared statement with placeholder
                  $selection = $db->prepare("SELECT * FROM detailfilaosortie WHERE DateMelange = :date");
                  $selection->bindParam(':date', $date, PDO::PARAM_STR);
                  $selection->execute();
                  $fetchAll = $selection->fetchAll();
                  ?>
                  <!-- Start the table -->
                  <table class="table table-bordered mt-3">
                    <thead>
                      <tr>
                        <th>Article</th>
                        
                        <th>Quantité</th>
                       
                        <th>Sac</th>
                        
                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($fetchAll as $fetch) {
                        $id_poisson = htmlspecialchars($fetch['id_poisson']);
                        $qtt_poisson = htmlspecialchars($fetch['Qttmelange']);
                        $sac_poisson = htmlspecialchars($fetch['sac']);
                      
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
                            <td><?= htmlspecialchars($id_poisson) ?></td>
                            <td><?= htmlspecialchars($qtt_poisson) ?></td>
                            <td><?= htmlspecialchars($sac_poisson) ?></td>
                        
                            <td>
                                
                        
                        </tr>
                        <br>
                        <tr>
                      <?php } ?>
                      
                    </tbody>
                  </table>
                  <br><br>
                  <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Article</th>
                                            <th>Ret Hier</th>
                                            <th>Poids</th>
                                            <th>Colis type</th>
                                            <th>Nbr</th>
                                            <th>Retour</th>
                                            <th>Sortie</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                                
                                                  <tr>

                                               <form action="addstockM.php" method="POST">
                                                        <td>
                                                            <select name="nom_poisson" class="form-control">
                                                            <?php 
                                                                  require('../../db.php') ;
                                                                $sql = "SELECT id, nomfilao FROM poisson ORDER BY nomfilao";
                                                                $stmt = $db->prepare($sql);
                                                                $stmt->execute();
                                                            
                                                                $filaos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                        
                                                                foreach ($filaos as $filao) : ?>
                                                                    <option value="<?= $filao['nomfilao'] ?>"><?= $filao['nomfilao'] ?></option>
                                                                  <?php endforeach; ?>
                                                                  
                                                                 ?>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="form-control" value='' name="retHier"></td>
                                                        <td>
                                                            <input type="hidden" class="form-control" value="0" name="enter">
                                                            <input type="hidden" class="form-control" value="0" name="poisson">
                                                            <input type="text" class="form-control" value='' name="qtt">
                                                        </td>
                                                        <td>
                                                            <select name="type" class="form-control">
                                                                <option value="1">en Sac</option>
                                                                <option value="2">en Carton</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="form-control" value='' name="sac"></td>
                                                        <td><input type="text" class="form-control" name="retour" value=''></td>
                                                        <td><input type="text" class="form-control" name="sortie" value=''></td>
                                                        <td>
                                                            <input type="hidden" class="form-control w-50" value="Melange" name="traitType">
                                                            <input type="hidden" class="form-control w-50" value="<?=$date?>" name="EnterDate">
                                                            <input type="submit" value="OK" class="form-control btn-success">
                                                        </td>
                                                        </tr>
                                                    </form>
                                           
                                                
                                       
                                    </tbody>
                                
                </div>
               
              </div>
            </div>
            <?=require('afficheMelange.php')?>
            <!-- Modal -->
        
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    let modal = document.getElementById("myModal");
    let btn = document.getElementById("openModalBtn");
    let span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
  </script>

  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/js/menu.js"></script>
</body>
</html>
