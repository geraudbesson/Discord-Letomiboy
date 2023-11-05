
<?php
        include_once 'header.php';
        include_once '../auth-discord/connexion_bdd.php';

        if($_SESSION['userData']['role']!='admin'){
            header("location: index.php?error=not_admin");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
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
</head>
<body>
    
<div class="dashboard-box">
    <div class="container mt-5">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <img src="<?php echo $avatar_url?>" style="width: 42px; height: 42px; border-radius: 50%; margin-right: 10px;" />
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</button> 
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="concours_photo-tab" data-bs-toggle="tab" data-bs-target="#concours_photo" type="button" role="tab" aria-controls="concours_photo" aria-selected="false">Concours retouche</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="resultat_concours_photo-tab" data-bs-toggle="tab" data-bs-target="#resultat_concours_photo" type="button" role="tab" aria-controls="resultat_concours_photo" aria-selected="false">Classement concours créa</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="concours_retouche-tab" data-bs-toggle="tab" data-bs-target="#concours_retouche" type="button" role="tab" aria-controls="concours_retouche" aria-selected="false">Concours retouche</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="resultat_concours_retouche-tab" data-bs-toggle="tab" data-bs-target="#resultat_concours_retouche" type="button" role="tab" aria-controls="resultat_concours_retouche" aria-selected="false">Classement concours retouche</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <div class="dashboard">
                    <div class="imgtheme-box">
                        <h2>Formulaire d'Image Thème</h2>
                        <form action="../trait-table/traitement_theme.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="file" class="col-form-label">Téléverser un Fichier:</label>
                                <input type="file" id="file" name="file" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="text" class="col-form-label">Nom du thème:</label>
                                <input type="text" id="text" name="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="col-form-label">Date du thème:</label>
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-info">Envoyer</button>
                        </form>
                    </div>
                    <div class="raw-box">
                        <h2>Image raw à récupérer</h2>
                            <form action="../trait-table/traitement_theme.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="file" class="col-form-label">Téléverser un Fichier:</label>
                                    <input type="file" id="file" name="file" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="text" class="col-form-label">Nom du fichier:</label>
                                    <input type="text" id="text" name="text" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-info">Envoyer</button>
                            </form>
                    </div>
                    <div class="check-box">
                        <h2>Dashboard formulaires</h2>
                            <div>
                                <h5>Reset les participants</h5>
                                <div class="container mt-5">
                                <!-- Formulaire avec un champ caché pour soumettre la requête -->
                                <form id="updateForm" method="post">
                                    <input type="hidden" name="update" value="true">
                                </form>
                                <!-- Bouton Bootstrap -->
                                <button type="button" class="btn btn-danger" id="confirmButton">Confirmer l'opération</button>
                                </div>
                                <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {

                                // Exécutez votre requête UPDATE ici (exemple de requête pour mettre à jour une table nommée "users")
                                $sql = "UPDATE participants_photo SET participer = '0'";

                                if ($conn->query($sql) === TRUE) {
                                    echo "La mise à jour a été effectuée avec succès.";
                                } else {
                                    echo "Erreur lors de la mise à jour : " . $conn->error;
                                }
                            }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="concours_photo" role="tabpanel" aria-labelledby="concours_photo-tab">
                <h1> Liste des Participants: vérification du suivi des règles</h1>
                <table id="participantsTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Ordre d'arriver</th>
                            <th>Nom</th>
                            <th>Fichier</th>
                            <th>Exifs</th>
                            <th>Funfacts</th>
                            <th>Date de prise</th>
                        </tr>
                    </thead>
                    <tbody>
                        <script>
                            $(document).ready(function() {
                                $('#participantsTable').DataTable({
                                    "ajax": {
                                        "url": "../trait-table/table-participant.php",
                                        "dataSrc": ""
                                    },
                                    "columns": [
                                        { "data": "idparticipant" },
                                        { "data": "discord_username",
                                            "render": function(data, type, row, meta) {
                                                var avatarUrl = "https://cdn.discordapp.com/avatars/" + row.discord_id + "/" + row.discord_avatar + ".jpg";
                                                return '<img src="' + avatarUrl + '" alt="' + data + '" style="max-width: 40px; max-height: 40px;"> ' + data;
                                            }
                                        },
                                        { 
                                            "data": "file",
                                            "render": function(data, type, row, meta) {
                                                return '<img src="../img/Participants/' + data + '" alt="' + row.nomparticipant + '" style="max-width: 200px; max-height: 200px;">';
                                            }
                                        },
                                        { "data": "exifs" },
                                        { "data": "funfact" },
                                        { "data": "dateprise" },
                                    ]
                                });
                            });
                        </script>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="resultat_concours_photo" role="tabpanel" aria-labelledby="resultat_concours_photo-tab">

            </div>
            <div class="tab-pane fade" id="concours_retouche" role="tabpanel" aria-labelledby="concours_retouche-tab">

            </div>
            <div class="tab-pane fade" id="resultat_concours_retouche" role="tabpanel" aria-labelledby="resultat_concours_retouche-tab">

            </div>
        </div>
    </div>
</div>

<script referrerpolicy="no-referrer" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script crossorigin="anonymous" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="></script>
    <?php
        include('footer.php');
    ?>
</body>
</html>
