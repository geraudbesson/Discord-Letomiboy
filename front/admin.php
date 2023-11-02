
<?php
        include_once 'header.php';
        include_once '../auth-discord/connexion_bdd.php';
        
        session_start();

        if($_SESSION['userData']['role']!='admin'){
            header("location: http://localhost/site/front/index.php?error=not_admin");
            exit();
        }
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Image Thème</title>
    <link rel="icon" type="image/png" href="img/Logo-Noir.png">
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

    <div class="content">
    <div class="rules-box">
        <h1> Liste des Participants: vérification du suivi des règles</h1>
        <table id="participantsTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Ordre d'arriver</th>
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
                            "url": "table.php",
                            "dataSrc": ""
                        },
                        "columns": [
                            { "data": "idparticipant" },
                            { "data": "nomparticipant" },
                            { 
                                "data": "file",
                                "render": function(data, type, row, meta) {
                                    return '<img src="Participants/' + data + '" alt="' + row.nomparticipant + '" style="max-width: 200px; max-height: 200px;">';
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
    </div>
    
    <div class="rules-box">
        <h1> Liste des votants: vérification du fair-play</h1>
        <table id="votantsTable" class="display">
            <thead>
                <tr>
                    <th>ID Votant</th>
                    <th>Nom Votant</th>
                    <th>Choix 1 (ID Participant)</th>
                    <th>Choix 2 (ID Participant)</th>
                    <th>Choix 3 (ID Participant)</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les données seront chargées ici -->
                <script>
                    $(document).ready(function() {
                    // Initialisez le DataTable
                    $('#votantsTable').DataTable({
                        ajax: {
                            url: 'table-vote.php', // Remplacez cela par l'URL de votre API ou du script serveur
                            dataSrc: '' // La clé dans la réponse JSON contenant les données
                        },
                        columns: [
                            { data: 'idvotant' },
                            { data: 'nomvotant' },
                            { data: 'choix1_nom' }, // Utilisez la syntaxe pour accéder aux propriétés imbriquées dans l'objet JSON
                            { data: 'choix2_nom' },
                            { data: 'choix3_nom' }
                        ]
                    });
                    });
                </script>
            </tbody>
        </table>
    </div>
    </div>
    
    <?php
        include('footer.php');
    ?>
</body>
</html>
