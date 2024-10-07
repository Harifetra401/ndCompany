<?php
$date = $_GET['date'];
$dateTime = new DateTime($date);

// Configurer le formateur de date pour le français
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);

// Formater la date
$formattedDate = $formatter->format($dateTime);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content remains the same -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Logiciel de Gestion</title>
    <link rel="icon" href="../assets/img/favicon/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php require('../nav/menu.php') ?>
            <div class="layout-page">
                <?php $title = 'Traitement'; require('../nav/header.php') ?>
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Mise en Sac le <br><?= $formattedDate; ?></h5>
                             <button type="button" class="col-4 col-sm-2  btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                  <i class="">+</i>
                                </button>
                            <div class="table-responsive text-nowrap">
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
                                        
                                                
                                                    <form action="../stock/add.php" method="POST">
                                                        <td>
                                                            <select name="nom_poisson" class="form-control">
                                                                <?php require '../poisson/liste2.php'?>
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
                                                            <input type="hidden" class="form-control w-50" value="<?=$date?>" name="EnterDate">
                                                            <input type="submit" value="OK" class="form-control btn-success">
                                                        </td>
                                                    </form>

                                                </tr>
                                           
                                                
                                       
                                    </tbody>
                                </table>
                                <div class="container-fluid flex-grow-1 container-p-y">
                                    <div class="card">
                                         <?php require('raportdeci.php')?>
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
                              <form action="adp.php" method='POST'>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameBasic" class="form-label">Nom</label>
                                      <input type="text" id="nameBasic" class="form-control" placeholder="Non de Poisson" name="nom" />
                                      <input type="hidden" name="date" value="<?=$date?>" />
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
                    
                </div>
            </div>
        </div>
    </div>
     
                    
                   
    <!-- Scripts remain the same -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/dashboards-analytics.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
