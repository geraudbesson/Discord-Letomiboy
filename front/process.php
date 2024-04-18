<?php
require_once 'model.php';
$db = new Database();

// Création des participation au concours photo
if (isset($_POST['action']) && $_POST['action'] === 'create'){
        extract($_POST);
        $db->create((int)$idusers, $img, $exifs, $funfact, (int)$idtheme);
        echo 'perfect';
    }

if (isset($_POST['action']) && $_POST['action'] === 'fetchCP'){
    $outputCP = '';

    if ($db->countBillsCP() > 0) {
        $billsCP = $db->readCP();
        $outputCP .= '
        <table id="CPorderTable" class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Ordre</th>
                <th scope="col">Pseudo</th>
                <th scope="col">Photo</th>
                <th scope="col">Exifs</th>
                <th scope="col">Funfact</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach ($billsCP as $billCP){
            $outputCP .= "
            <tr>
                <th scope=\"row\">$billCP->idparticipant</th>
                <td><img src=\"https://cdn.discordapp.com/avatars/$billCP->discord_id/$billCP->discord_avatar.jpg\" style=\"width: 35px; height: auto;\">$billCP->discord_username</td>
                <td><img src=\"../img/Participants/$billCP->img\" alt=\"$billCP->img\" style=\"width: 150px; height: auto;\"></td>
                <td>$billCP->exifs</td>
                <td>$billCP->funfact</td>
                <td>
                    <a href=\"#\" class=\"text-info me-2 infoBtn\" title=\"Voir info personne\" data-id=\"$billCP->idparticipant\">
                        <i class=\"fas fa-info-circle\"></i>
                    </a>
                    <a href=\"#\" class=\"text-info me-2 infoBtn\" title=\"Modifier\" data-id=\"$billCP->idparticipant\">
                        <i class=\"fas fa-edit\" data-bs-toggle='modal' data-bs-target='#updateModal'></i>
                    </a>
                    <a href=\"#\" class=\"text-danger me-2 deleteBtn\" title=\"Delete participation\" data-id=\"$billCP->idparticipant\">
                        <i class=\"fas fa-trash\"></i>
                    </a>
                </td>
            </tr>
            ";
        }
        $outputCP .= "</tbody></table>";
        echo $outputCP;
    } else {
        echo "<h3>Aucune participation pour le moment</h3>";
    }
}

// // Info sur les auteurs des participations
// if (isset($_POST['informationId'])){
//     $informationId = (int)$_POST['informationId'];
//     echo json_encode($db->getSingleBillCP($informationId));
// };

// Supprimer participation
if (isset($_POST['deletionId'])){
    $deletionId = (int)$_POST['deletionId'];
    echo $db->deleteCP($deletionId);
};

// Reset des participations (il manque encore à update des notes)
if (isset($_POST['resetData'])){
    $resetResult = $db->reset();

    if ($resetResult) {
        // Réinitialisation réussie
        echo 'success';
    } else {
        // Échec de la réinitialisation
        echo 'error';
    }
};

if (isset($_POST['action']) && $_POST['action'] === 'fetchRCP'){
    $outputRCP = '';

    if ($db->countBillsRCP() > 0) {
        $billsRCP = $db->readRCP();
        usort($billsRCP, function($a, $b) {
            return $b->moyenne <=> $a->moyenne;
        });
        $counterRCP = 1;
        $outputRCP .= '
        <table id="RCPorderTable" class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Classement</th>
                <th scope="col">Pseudo</th>
                <th scope="col">Photo</th>
                <th scope="col">Moyenne</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach ($billsRCP as $billRCF){
            $outputRCP .= "
            <tr class=\"\">
                <th scope=\"row\">$counterRCP</th>
                <td><img src=\"https://cdn.discordapp.com/avatars/$billRCF->discord_id/$billRCF->discord_avatar.jpg\" style=\"width: 35px; height: auto;\"> $billRCF->discord_username</td>
                <td><img src=\"../img/Participants/$billRCF->img\" alt=\"$billRCF->img\" style=\"width: 150px; height: auto;\"></td>
                <td scope=\"row\">$billRCF->moyenne</td>
                <td>
                    <a href=\"#\" class=\"text-info me-2 infoBtn\" title=\"Voir info personne\"><i class=\"fas fa-info-circle\"></i></a>
                    <a href=\"#\" class=\"text-danger me-2 deleteBtn\" title=\"Delete participation\"><i class=\"fas fa-trash\"></i></a>
                </td>
            </tr>
            ";
            $counterRCP++;
        }
        $outputRCP .= "</tbody></table>";
        echo $outputRCP;
    } else {
        echo "<h3>Aucun vote pour le moment</h3>";
    }
}
