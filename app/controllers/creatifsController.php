<?php

namespace App\Controllers\CreatifsController;

use PDO;

function indexAction(PDO $conn): void
{
    include_once '../app/models/creatifsModel.php';

    $creatifId = $_GET['id'];
    $projets = \App\Models\CreatifsModel\findAll($conn, $creatifId);

    $creatifs = \App\Models\CreatifsModel\findCreatifs($conn);
    include_once '../app/models/tagsModel.php';
    $tags = \App\Models\TagsModel\findAll($conn);

    global $title, $content, $aside;
    $page = 1;
    $totalPages = 1;
    $title = 'Créatif';
    ob_start();
    include '../app/views/projets/index.php';
    $content = ob_get_clean();
    ob_start();
    include '../app/views/templates/partials/_aside.php';
    $aside = ob_get_clean();
}
