
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
    <link rel="icon" type="image/png" href="img/Logo-Noir.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Formulaire d'Image Thème</title>
    
</head>
<body>
    <section class="container py-5">
        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <h1 class="fs-4 text-center lead text-primary">
            <img src="<?php echo $avatar_url?>" style="width: 42px; height: 42px; border-radius: 50%;" />Hey <?php echo $name?></h1>
            <li class="nav-item" role="dashboard">
                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</button> 
            </li>
            <li class="nav-item" role="concoursphoto">
                <button class="nav-link" id="concoursphoto-tab" data-bs-toggle="tab" data-bs-target="#concoursphoto" type="button" role="tab" aria-controls="concoursphoto" aria-selected="false">Concours photo</button> 
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="resultatphoto-tab" data-bs-toggle="tab" data-bs-target="#resultatphoto" type="button" role="tab" aria-controls="resultatphoto" aria-selected="false">Resultat Concours Photo</button>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="déco-tab" href="front-secondaire/logout.php" role="tab" aria-controls="déconnexion" aria-selected="false">Se déconnecter</a>
            </li>
        </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <form action="admin.php" method="post">
                                    <label>
                                        <h3>Concours photo</h3>
                                        <?php
                                            $sql_select = "SELECT formphoto FROM formulaire";
                                            $result = $conn->query($sql_select);
                    
                                            if ($result === FALSE) {
                                                echo "Erreur dans la requête : " . $conn->error;
                                            } else {
                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $currentFormValue = $row["formphoto"];
                    
                                                    if ($currentFormValue == 1) {
                                                        echo "Participation activer";
                                                    } elseif ($currentFormValue == 2) {
                                                        echo "Vote activer";
                                                    } elseif ($currentFormValue == 3) {
                                                        echo "FERMÉ";
                                                    } else {
                                                        echo "La valeur de 'form' n'est pas reconnue.";
                                                    }
                                                }
                                            }
                                        ?>
                                        <select class="form-select" name="formphoto">
                                            <option selected>Choix du formulaire</option>
                                            <option value="1">Formulaire de participation</option>
                                            <option value="2">Formulaire de vote</option>
                                            <option value="3">Formulaires fermés</option>
                                        </select>
                                    </label>
                                    <input class="btn btn-info" type="submit" value="Valider">
                                </form>
                                <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                        $formphoto = isset($_POST['formphoto']) && $_POST['formphoto'] !== '' ? $_POST['formphoto'] : null;
                                    
                                        if ($formphoto !== null) {
                                            $sql = "UPDATE formulaire SET formphoto = $formphoto";
                                            if ($conn->query($sql) === TRUE) {
                                                echo "Formulaire mis à jour avec succès!";
                                            } else {
                                                echo "Erreur lors de la mise à jour du formulaire : " . $conn->error;
                                            }
                                        } else {
                                            echo "Aucune option sélectionnée.";
                                        }
                                    }
                                ?>
                            </div>

                            <div class="col-md-4 mb-3">
                                <form action="admin.php" method="post">
                                    <label>
                                        <h3>Concours retouche</h3>
                                        <?php
                                            $sql_select = "SELECT formretouche FROM formulaire";
                                            $result = $conn->query($sql_select);

                                            if ($result === FALSE) {
                                                echo "Erreur dans la requête : " . $conn->error;
                                            } else {
                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $currentFormValue = $row["formretouche"];

                                                    if ($currentFormValue == 1) {
                                                        echo "Participation activer";
                                                    } elseif ($currentFormValue == 2) {
                                                        echo "Vote activer";
                                                    } elseif ($currentFormValue == 3) {
                                                        echo "FERMÉ";
                                                    } else {
                                                        echo "La valeur de 'form' n'est pas reconnue.";
                                                    }
                                                }
                                            }
                                        ?>
                                        <select class="form-select" name="formretouche">
                                            <option selected>Choix du formulaire</option>
                                            <option value="1">Formulaire de participation</option>
                                            <option value="2">Formulaire de vote</option>
                                            <option value="3">Formulaires fermés</option>
                                        </select>
                                    </label>
                                    <input class="btn btn-info" type="submit" value="Valider">
                                </form>
                                <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                        $formretouche = isset($_POST['formretouche']) && $_POST['formretouche'] !== '' ? $_POST['formretouche'] : null;
                                    
                                        if ($formretouche !== null) {
                                            $sql = "UPDATE formulaire SET formretouche = $formretouche";
                                            if ($conn->query($sql) === TRUE) {
                                                echo "Formulaire mis à jour avec succès!";
                                            } else {
                                                echo "Erreur lors de la mise à jour du formulaire : " . $conn->error;
                                            }
                                        } else {
                                            echo "Aucune option sélectionnée.";
                                        }
                                    }

                                ?>
                            </div>

                            <div class="col-md-4 mb-3">
                                <h2>Ajouter un Nouveau Thème</h2>
                                <form action="../trait-table/traitement_theme.php" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Image du Thème (Thème / RAW)</label>
                                        <input type="file" class="form-control" name="file" id="file" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="text" class="form-label">Attribuer un nom au thème/raw</label>
                                        <input type="text" class="form-control" name="text" id="text" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="concours" class="form-label">Type de Concours</label>
                                        <select class="form-select" name="concours" id="concours" required>
                                            <option value="" disabled selected>Choisir le type de concours</option>
                                            <option value="1">Concours Photo</option>
                                            <option value="2">Concours Retouche</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date de Fin du Thème</label>
                                        <input type="date" class="form-control" name="date" id="date" required>
                                    </div>

                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-info" value="Ajouter le Thème">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="concoursphoto" role="tabpanel" aria-labelledby="concoursphoto-tab">
                    <div class="dropdown-divider border-warning"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-0">Liste des participations</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#createpartphoto"><i class="fas fa-folder-plus"></i> Ajouter</button>
                                <a href="#" class="btn btn-danger btn-sm me-3 resetBtn"><i class="fa-solid fa-trash"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider border-warning"></div>
                    <div class="row">
                        <div class="table-responsive" id="CPorderTable">
                            <h3 class="text-success text-center">Chargement des participations</h3>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="resultatphoto" role="tabpanel" aria-labelledby="resultatphoto-tab">
                    <div class="dropdown-divider border-warning"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-0">Classement du concours photo</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <a href="#" class="btn btn-danger btn-sm me-3"><i class="fa-solid fa-trash"></i> Reset</a></button>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider border-warning"></div>
                    <div class="row">
                        <div class="table-responsive" id="RCPorderTable">
                            <h3 class="text-success text-center">Chargement des participations</h3>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <div class="modal fade" id="createpartphoto" tabindex="-1" aria-labelledby="createpartphotoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createpartphotoLabel">Nouvelle participation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formOrderconcours" enctype="multipart/form-data">
                        <div class="mb-3">
                            <?php
                                $result = $conn->query("SELECT idusers, discord_username FROM users");
                                if ($result) {
                                    $options = '';
                                    while ($row = $result->fetch_assoc()) {
                                        $idusers = $row['idusers'];
                                        $discordUsername = $row['discord_username'];
                                        $options .= "<option value=\"$idusers\">$discordUsername</option>";
                                    }
                                }
                            ?>
                            <label for="idusers">Auteur</label>
                            <select class="form-select" id="idusers" aria-label="idusers" name="idusers">
                                <?php echo $options; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="file">Téléverser un Fichier:</label>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="exifs" name="exifs">
                                    <label for="exifs">EXIFS:</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="funfact" name="funfact">
                                    <label for="funfact">Anecdotes et funfacts:</label>
                                </div>
                                
                                <?php 
                                    $sql = "SELECT * FROM theme ORDER BY idtheme DESC LIMIT 1;";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $idtheme = $row['idtheme'];
                                ?>
                                <input type="hidden" id="idtheme" name="idtheme" value="<?php echo $idtheme?>">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" name="create" id="create">Ajouter la participation</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="process.js"></script>

    <footer>
        <div class="footer-content">
            <p>&copy; 2023 Votre Nom / Nom de votre entreprise<br></p>
            <div class="social-icons">
                <a href="#"><img src="../img/facebook.webp" ></a>
                <a href="#"><img src="../img/twitter.png" ></a>
                <a href="#"><img src="../img/instagram.png" ></a>
            </div>
        </div>
    </footer>
</body>
</html>
