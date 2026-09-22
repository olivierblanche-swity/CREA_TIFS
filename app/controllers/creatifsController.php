<?php

/**
 * ../app/models/creatifsModel.php
 */

namespace App\Controllers\CreatifsController;

use PDO;

// Prepare la liste des projets du creatif choisi et les donnees de la barre laterale.
function indexAction(PDO $conn)
{
    include_once '../app/models/creatifsModel.php';

    $creatifId = $_GET['id'];
    $projets = \App\Models\CreatifsModel\findAll($conn, $creatifId);

    $creatifs = \App\Models\CreatifsModel\findCreatifs($conn);
    include_once '../app/models/tagsModel.php';
    $tags = \App\Models\TagsModel\findAll($conn);

    global $title, $content;
    $page = 1;
    $totalPages = 1;
    $title = 'Créatifs';
    ob_start();
    include '../app/views/projets/index.php';
    $content = ob_get_clean();
}
