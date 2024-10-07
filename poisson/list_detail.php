    <?php
    require('../db.php');
    $numeroFacture = $_GET["numFact"];
    $selection = $db->prepare("SELECT * FROM detailfilao WHERE NumFac=$numeroFacture");
    $selection->execute();
    $fetchAll = $selection->fetchAll();

    function getNomPoisson($id_selector)
    {
      require('../db.php');
      $getBy = $db->prepare("SELECT nomfilao FROM poisson WHERE id=$id_selector");
      $getBy->execute();
      $fetchBy = $getBy->fetch();
      return $fetchBy["nomfilao"];
    }
        function getNomFournisseur($id_selector)
    {
      require('../db.php');
      $getBy = $db->prepare("SELECT `id`, `NUMERO`, `NOMS`, `PRENOMS`, `nomfournisseur`, `CIN`, `dateCin`, `LieudeDelivrance` FROM `fournisseur` WHERE id = $id_selector");
      $getBy->execute();
      $fetchBy = $getBy->fetch();
      return $fetchBy["NOMS"];
    }
       function getPrNomFournisseur($id_selector)
    {
      require('../db.php');
      $getBy = $db->prepare("SELECT `id`, `NUMERO`, `NOMS`, `PRENOMS`, `nomfournisseur`, `CIN`, `dateCin`, `LieudeDelivrance` FROM `fournisseur` WHERE id = $id_selector");
      $getBy->execute();
      $fetchBy = $getBy->fetch();
      return $fetchBy["PRENOMS"];
    }
           function getSurNomFournisseur($id_selector)
    {
      require('../db.php');
      $getBy = $db->prepare("SELECT `id`, `NUMERO`, `NOMS`, `PRENOMS`, `nomfournisseur`, `CIN`, `dateCin`, `LieudeDelivrance` FROM `fournisseur` WHERE id = $id_selector");
      $getBy->execute();
      $fetchBy = $getBy->fetch();
      return $fetchBy["nomfournisseur"];
    }
    function getCodePoisson($id_selector)
    {
      require('../db.php');
      $getBy = $db->prepare("SELECT CodeArticle FROM poisson WHERE id=$id_selector");
      $getBy->execute();
      $fetchBy = $getBy->fetch();
      return $fetchBy["CodeArticle"];
    }
?>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .facture-container {
            width: 100%;
            margin: 0 auto;
            padding: 40px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .header-facture {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-facture h1 {
            margin: 0;
        }
        .info-facture {
            margin-bottom: 20px;
        }
        .info-facture p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .total-section p {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class=" card facture-container">
        <div class="header-facture">
            <h1>Facture Numéro : <?= htmlspecialchars($numeroFacture) ?></h1>
            
            <p>Date : <?= $_GET['date'] ?></p>
        </div>

        <div class="info-facture">
            <p><strong>Fournisseur :</strong> <?= getNomFournisseur($_GET['id_fournisseur']) ?>  <?= getPrNomFournisseur($_GET['id_fournisseur']) ?> (<?= getSurNomFournisseur($_GET['id_fournisseur']) ?>)</p>
            <!-- Ajouter d'autres informations si nécessaire -->
        </div>

        <table>
            <thead>
                <tr>
                    <th>Code Poisson</th>
                    <th>Nom Poisson</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Sous-total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $total_poid = 0;
                foreach ($fetchAll as $fetch) {
                    $id_poisson = getNomPoisson($fetch['id_poisson']);
                    $Codepoisson = getCodePoisson($fetch['id_poisson']);
                    $qtt_poisson = $fetch['qtt'];
                    $id = $fetch['id'];
                    $prix_poisson = $fetch['prixUnit'];
                    $total += ($qtt_poisson * $prix_poisson);
                    $total_poid += $qtt_poisson;
                    
                    $variable = str_replace(' ', '', $id_poisson);
                    
                    $code = substr($variable, 0, 4);
                    echo $premieres_lettres; // Affichera "exe"

                ?>

                <tr>
                    <td><?= htmlspecialchars($code)?>.0NDC@MG/<?= htmlspecialchars($id) ?></td>
                    <td><?= htmlspecialchars($id_poisson) ?></td>
                    <td><?= htmlspecialchars($qtt_poisson) ?></td>
                    <td>
                        
                            <form action="update.php?id=<?= $id ?>&numFact=<?= $_GET['numFact'] ?>&id_fournisseur=<?= $_GET['id_fournisseur'] ?>" method="POST">
                                <input type="text" id=""class='form-control' name="prixUnit" value="" required>
                                <input type="submit" class='d-none' value="Mettre à jour">
                            </form>
                         </td>
                    <td><?= htmlspecialchars($qtt_poisson * $prix_poisson) ?> Ar</td>
                    <td>
                        <a href="delete.php?id=<?= $id ?>&numFact=<?= $_GET['numFact'] ?>&id_fournisseur=<?= $_GET['id_fournisseur'] ?>">Supprimer</a>
                    </td>
                </tr>

                <?php } ?>
            </tbody>
        </table>

        <div class="total-section">
            <p>Total Poids: <?= htmlspecialchars($total_poid) ?> kg</p>
            <p>Total Général: <?= htmlspecialchars($total) ?> Ar</p>
        </div>
    </div>
