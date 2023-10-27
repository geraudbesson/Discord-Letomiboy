// Attendre que le document soit prêt
$(document).ready(function() {
    // Initialiser le DataTable
    $('#participantsTable').DataTable({
        "ajax": "../table.php", // Chemin vers le script PHP qui récupère les données de la base de données
        "columns": [
            { "data": "nomparticipant" }, // Colonne pour le nom du participant
            { "data": "file" }, // Colonne pour le nom du fichier
            { "data": "exifs" }, // Colonne pour les exifs
            { "data": "funfact" } // Colonne pour les funfacts
        ]
    });
});
