function exporterTableauEnCSV(nomFichier) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++) {
            var cellText = cols[j].innerText;

            // Remplacer les points par des virgules dans la deuxième colonne (index 1)
            if (j === 1) {
                cellText = cellText.replace(/\./g, ',');
            }

            row.push(cellText);
        }

        // Joindre les colonnes avec un point-virgule
        csv.push(row.join(";"));        
    }

    // Télécharger le fichier CSV
    telechargerCSV(csv.join("\n"), nomFichier);
}

function telechargerCSV(csv, nomFichier) {
    var blob = new Blob([csv], { type: 'text/csv' });
    var link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = nomFichier;

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
