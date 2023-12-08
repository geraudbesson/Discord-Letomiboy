<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Concours Créatif</title>
    <link rel="icon" type="image/png" href="img/Logo-Noir.png">
</head>
<body>
<div class="container-form">
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h2>Concours Photo</h2>
        <div class="separator"></div><br>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img src="../img/Theme_10_2023.jpg" class="card-img-top" alt="Image Concours Photo 1">
                    <div class="card-body">
                        <h5 class="card-title">Participer au concours photo</h5>
                        <p class="card-text">Partagez votre participation au concours photo.</p><br>
                        <a href="participer.php" class="btn btn-primary">Je veux participer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="../img/Theme_10_2023.jpg" class="card-img-top" alt="Image Concours Photo 2">
                    <div class="card-body">
                        <h5 class="card-title">Voter pour le concours photo</h5>
                        <p class="card-text">Mettez vos notes aux participation du concours photo.</p><br>
                        <a href="voter.php" class="btn btn-primary">Je veux voter</a>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5">Concours Retouche</h2>
        <div class="separator"></div><br>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img src="../img/Theme_10_2023.jpg" class="card-img-top" alt="Image Concours Retouche 1">
                    <div class="card-body">
                        <h5 class="card-title">Participer au concours retouche</h5>
                        <p class="card-text">Partagez votre participation au concours retouche.</p><br>
                        <a href="participer-retouche.php" class="btn btn-primary">Je veux participer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="../img/Theme_10_2023.jpg" class="card-img-top" alt="Image Concours Retouche 2">
                    <div class="card-body">
                        <h5 class="card-title">Voter pour le concours Retouche</h5>
                        <p class="card-text">Mettez vos notes aux participation du concours retouche.</p><br>
                        <a href="participer-retouche.php" class="btn btn-primary">Je veux voter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
</div>



</body>
</html>