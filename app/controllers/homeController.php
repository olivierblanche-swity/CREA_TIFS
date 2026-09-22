<?php

/**
 * ../app/controllers/projetsController.php
 */

namespace App\Controllers\homeController;

use \PDO;
use \App\Models\ProjetsModel;

function homeAction(PDO $conn): void
{
    // Charge les fonctions du modele utilisees par la page.
    include_once '../app/models/projetsModel.php';

    // Determine la page demandee et limite l'affichage a 10 projets.
    $projectsPerPage = 10;
    $page = max(1, (int) ($_GET['page'] ?? 1));
    $totalProjects = ProjetsModel\countAll($conn);
    $totalPages = max(1, (int) ceil($totalProjects / $projectsPerPage));
    $page = min($page, $totalPages);
    $projets = ProjetsModel\findAll($conn, $projectsPerPage, ($page - 1) * $projectsPerPage);

    // Recupere les donnees affichees dans la barre laterale.
    $creatifs = ProjetsModel\findCreatifs($conn);
    include_once '../app/models/tagsModel.php';
    $tags = \App\Models\TagsModel\findAll($conn);

    // Prepare le contenu principal et la barre laterale pour le template.
    global $title, $content, $aside;
    $title = "HOME";
    ob_start();
    include '../app/views/projets/index.php';
    $content = ob_get_clean();
    ob_start();
    include '../app/views/templates/partials/_aside.php';
    $aside = ob_get_clean();
}
