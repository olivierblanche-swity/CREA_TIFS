<?php

namespace App\Controllers\TagsController;

use PDO;

// Prepare la liste des projets du tag choisi et les donnees de la barre laterale.
function indexAction(PDO $conn)
{
    include_once '../app/models/tagsModel.php';
    include_once '../app/models/creatifsModel.php';

    $tagId = $_GET['id'];
    $projets = \App\Models\TagsModel\findProjects($conn, $tagId);
    $tag = \App\Models\TagsModel\findById($conn, (int) $tagId);
    $creatifs = \App\Models\CreatifsModel\findCreatifs($conn);
    $tags = \App\Models\TagsModel\findAll($conn);

    global $title, $content;
    $page = 1;
    $totalPages = 1;
    $title = 'Tags : ' . $tag['nom'];
    ob_start();
    include '../app/views/projets/index.php';
    $content = ob_get_clean();
}
