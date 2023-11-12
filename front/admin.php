
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
                                <a href="#" class="btn btn-danger btn-sm me-3"><i class="fa-solid fa-trash"></i> Reset</a></button>
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
                            <h5 class="fw-bold mb-0">Liste des participations</h5>
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
