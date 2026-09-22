<?php

namespace App\Controllers\TagsController;

use PDO;

function indexAction(PDO $conn): void
{
    include_once '../app/models/tagsModel.php';
    include_once '../app/models/creatifsModel.php';

    $tagId = $_GET['id'];
    $projets = \App\Models\TagsModel\findProjects($conn, $tagId);
    $creatifs = \App\Models\CreatifsModel\findCreatifs($conn);
    $tags = \App\Models\TagsModel\findAll($conn);

    global $title, $content, $aside;
    $page = 1;
    $totalPages = 1;
    $title = 'Tag';
    ob_start();
    include '../app/views/projets/index.php';
    $content = ob_get_clean();
    ob_start();
    include '../app/views/templates/partials/_aside.php';
    $aside = ob_get_clean();
}
