<?php
  require('../session.php');
  ?>
<?php

        require('../db.php');
        $sql = "SELECT id, nomfilao FROM poisson";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $filaos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    ?>
<!DOCTYPE html>
<html>
<head>
    <title>poisson</title>
    <link rel="stylesheet" href="../poisson/modal.css">
</head>

<body class="overflow-auto md:pl-[20%]">
<p id="result"></p>
    


    <!-- component -->
    <form method="post" action="../poisson/ajoutDetail.php">
<div class="min-h-screen bg-purple-400 flex justify-center items-center">
	<div class="absolute w-60 h-60 rounded-xl bg-purple-300 -top-5 left-[20%] z-0 transform rotate-45 hidden md:block">
	</div>
	<div class="absolute w-48 h-48 rounded-xl bg-purple-300 -bottom-6 -right-10 transform rotate-12 hidden md:block">
	</div>
	<div class="py-12 px-12 bg-white rounded-2xl shadow-xl z-20">
		<div>
			<h1 class="text-3xl font-bold text-center mb-4 cursor-pointer">Enregistrement</h1>
			<p class="w-80 text-center text-sm mb-8 font-semibold text-gray-700 tracking-wide cursor-pointer">
                Veillez ajouter les poissons d'aujourd'hui, s'il vous plait!
            </p>
		</div>
		<div class="space-y-4">
            <div class="flex justify-between text-sm rounded-lg w-full outline-none">
            <select id="poisson updateDiv"  name="poisson" class="text-sm py-3 px-4 rounded-lg w-full border outline-none">
                <?php foreach ($filaos as $filao) : ?>
                    <option value="<?= $filao['id'] ?>"><?= $filao['nomfilao'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="button" value="+" id="showDialog" class="py-3 px-3 font-bold cursor-pointer bg-purple-400 text-white hover:shadow-lg hover:shadow-indigo-500/40  border rounded-full m-1 text-[20pt]">
            </div>
			<input type="number" id="Qtt" name="qtt" placeholder="Enter la quantité" class="block text-sm py-3 px-4 rounded-lg w-full border outline-none" />
			<input type="number" type="text" id="Pu" name="pu" placeholder="Enter le prix de ce poisson" class="block text-sm py-3 px-4 rounded-lg w-full border outline-none" />
        </div>
			<div class="text-center mt-6">
				<button type="submit" onclick="calculateMultiplication()" class="py-3 w-full text-xl text-white bg-purple-400 rounded-2xl">Ajouter</button>
			</div>
		</div>
		<div class="w-40 h-40 absolute bg-purple-300 rounded-full top-0 right-12 hidden md:block"></div>
		<div
			class="w-20 h-40 absolute bg-purple-300 rounded-full bottom-20 left-[20%] transform rotate-45 hidden md:block">
		</div>
	</div>
    <input type="number" name="id_fournisseur" value="<?=$_GET['id_fournisseur']?>" style="display:none;"/>
    <input type="number" name="numFact" value="<?=$_GET['numFact']?>" style="display:none;">
    </form>
    <?php 
    $id_to_get_fou = $_GET['id_fournisseur'];

        $getFou = $db -> prepare("SELECT nomfournisseur FROM fournisseur WHERE id=$id_to_get_fou");
        $getFou -> execute();
        $fetchNom = $getFou -> fetch();
        $nom_fournisseur = $fetchNom["nomfournisseur"];
    
    ?>

    <h1>Numero du Facture: <?=$_GET['numFact']?></h1>
    <h1>Nom du Fournisseur: <?=$nom_fournisseur?></h1><br>

    <?php require('../detail/filao.php'); ?>

<!-- A modal dialog containing a form -->
<dialog id="favDialog" class="py-12 px-12 bg-white rounded-2xl shadow-xl z-20">
<div class="modal-content">
            <span class="absolute top-0 right-0 m-4 border-2 cursor-pointer px-2 py-1 rounded-full" id="closeModalBtn">&times;</span>
            <h2 class="text-3xl font-bold text-center mb-4">Ajouter le nouveau poisson</h2>

            <form action="../poisson/back.php" method="post">
			<input type="text" name="nom" placeholder="NomFilao" class="block text-sm py-3 px-4 rounded-lg w-full border outline-none my-1" />
				<button type="submit" class="py-3 w-full text-xl text-white bg-purple-400 rounded-2xl">Ajouter</button>
            </form>
        </div>
</dialog>


<script>
    // Ferme la modal 
    window.addEventListener("click", function(event) {
        if (event.target === document.getElementById("modal")) {
            document.getElementById("modal").style.display = "none"; 
        }
    });

    //Calcul Prix 
    function calculateMultiplication() {
    var qtt = parseFloat(document.getElementById("Qtt").value);
    var punit = parseFloat(document.getElementById("Pu").value);

    var result = qtt * punit;

    if (!isNaN(result)) {
        document.getElementById("result").textContent = "Résultat: " + result;
    } else {
        document.getElementById("result").textContent = "";
    }
}

</script>
<script>
    
const showButton = document.getElementById("showDialog");
const favDialog = document.getElementById("favDialog");
const close = document.getElementById("closeModalBtn");

// "Show the dialog" button opens the <dialog> modally
showButton.addEventListener("click", () => {
  favDialog.showModal();
});

close.addEventListener("click", () => {
    favDialog.close();
    });

</script>
</body>
</html>