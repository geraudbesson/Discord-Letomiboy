<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Image Thème</title>
    <link rel="icon" type="image/png" href="img/Logo-Noir.png">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles-admin.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
    <script>
        function afficherApercu(event) {
            var fichier = event.target.files[0];
            var lecteur = new FileReader();
            lecteur.onload = function(e) {
                var imageApercu = document.getElementById('imageApercu');
                imageApercu.src = e.target.result;
            };
            lecteur.readAsDataURL(fichier);
        }
    </script>

<style>
    #participantsTable thead th {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
    }

    #participantsTable tbody td {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
    }
</style>
</head>
<body>
    <header>
        <div id="logo">
            <img src="img/Logo-Blanc.png" alt="Logo de votre site">
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="participer.html">Participer</a></li>
                <li><a href="voter.html">Voter</a></li>
            </ul>
        </nav>
        <div id="connexion">
            <button><a href="admin.php">Connexion</a></button>
        </div>
    </header>
    <div class="theme-box" id="titre">
        <h2>Formulaire d'Image Thème</h2>
        <form action="traitement_formulaire.php" method="post" enctype="multipart/form-data">
            <label for="image">Choisir un fichier :</label>
            <input type="file" id="image" name="image" accept="image/*" onchange="afficherApercu(event)" required><br><br>
            <img id="imageApercu" src="#" alt="Aperçu de l'image" style="max-width: 200px; max-height: 200px;">
            <br><br>
            <button type="submit">Envoyer</button>
        </form>
    </div>
    <table id="participantsTable">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Fichier</th>
            <th>Exifs</th>
            <th>Funfacts</th>
        </tr>
    </thead>
    <tbody>
        <script>
            $(document).ready(function() {
                $('#participantsTable').DataTable({
                    "ajax": {
                        "url": "table.php", // Chemin vers le fichier fetch_data.php
                        "dataSrc": ""
                    },
                    "columns": [
                        { "data": "nomparticipant" },
                        { 
                            "data": "file",
                            "render": function(data, type, row, meta) {
                                return '<img src="Participants/' + data + '" alt="' + row.nomparticipants + '" style="max-width: 200px; max-height: 200px;">';
                            }
                        },
                        { "data": "exifs" },
                        { "data": "funfact" },
                    ]
                });
            });
        </script>
    </tbody>
    </table>
</body>
</html>
