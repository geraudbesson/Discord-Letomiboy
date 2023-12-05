
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
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <h1 class="fs-4 text-center lead text-primary">
            <img src="<?php echo $avatar_url?>" style="width: 42px; height: 42px; border-radius: 50%;" />Hey <?php echo $name?></h1>
            <li class="nav-item" role="concoursphoto">
                <button class="nav-link active" id="concoursphoto-tab" data-bs-toggle="tab" data-bs-target="#concoursphoto" type="button" role="tab" aria-controls="true" aria-selected="true">Concours photo</button> 
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="resultatphoto-tab" data-bs-toggle="tab" data-bs-target="#resultatphoto" type="button" role="tab" aria-controls="false" aria-selected="false">Resultat Concours Photo</button>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="déco-tab" href="front-secondaire/logout.php" role="tab" aria-controls="déconnexion" aria-selected="false">Se déconnecter</a>
            </li>
        </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="concoursphoto" role="tabpanel" aria-labelledby="concoursphoto-tab">
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
                        <input type="texte" class="form-control" id="file" name="file">
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

    <?php
        include('footer.php');
    ?>
</body>
</html>
