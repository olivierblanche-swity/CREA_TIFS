<?php

namespace App\Controllers\ProjetsController;

use PDO;
use \App\Models\ProjetsModel;
use \App\Models\TagsModel;

// Prepare le detail du projet, ses tags et la barre laterale.
function showAction(PDO $conn, int $id)
{
    // Charge les fonctions du modele utilisees par la page.
    include_once '../app/models/projetsModel.php';


    $projet = ProjetsModel\findOneById($conn, $id);


    // Recupere les tags du projet.
    include_once '../app/models/tagsModel.php';
    $projetTags = TagsModel\findByProject($conn, $id);
    // Recupere les donnees de la barre laterale.
    include_once '../app/models/creatifsModel.php';
    $creatif = \App\Models\CreatifsModel\findOneById($conn, (int) $projet['creatifId']);
    $tags = TagsModel\findAll($conn);

    // Prepare la vue complete pour le template.
    global $title, $content;
    $title = "Les Projets de :" . $projet['creatifPseudo'];
    ob_start();
    include '../app/views/projets/show.php';
    $content = ob_get_clean();
}

// Charge les creatifs et les tags pour afficher le formulaire d'ajout.
function addFormAction(PDO $conn)
{

    // charge le formulaire pour ajouter un projet
    include_once '../app/models/projetsModel.php';
    include_once '../app/models/tagsModel.php';
    // Recupere les donnees de la barre laterale.
    $creatifs = ProjetsModel\findCreatifs($conn);
    $tags = TagsModel\findAll($conn);

    global $title, $content;
    $title = "Formulaire d'ajout";
    ob_start();
    include '../app/views/projets/addForm.php';
    $content = ob_get_clean();
}

// Recupere le formulaire et la photo, ajoute le projet puis redirige vers l'accueil.
function insertAction(PDO $conn)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . PUBLIC_BASE_URL . 'projects/add/form.html');
        exit;
    }

    include_once '../app/models/projetsModel.php';

    $image = \Core\Helpers\uploadImage($_FILES['image'] ?? []);

    // Recupere les informations du formulaire.
    $projet = [
        'titre' => trim($_POST['titre']),
        'texte' => trim($_POST['texte']),
        'image' => $image,
        'creatif' => (int) $_POST['creatif'],
    ];
    $tags = $_POST['tags'] ?? [];

    if (ProjetsModel\insert($conn, $projet, $tags)) {
        header('Location: ' . PUBLIC_BASE_URL, true, 303);
        exit;
    }

    if ($image !== null) {
        unlink('../public/images/' . $image);
    }
    exit("Le projet n'a pas pu être ajouté.");
}

// Supprime le projet demande puis retourne a la page d'accueil.
function deleteAction(PDO $conn, int $id)
{
    include_once '../app/models/projetsModel.php';

    if (ProjetsModel\delete($conn, $id)) {
        header('Location: ' . PUBLIC_BASE_URL, true, 303);
        exit;
    }

    exit("Le projet n'a pas pu être supprimé.");
}

// Charge le projet et ses tags pour preremplir le formulaire.
function editAction(PDO $conn, int $id)
{
    include_once '../app/models/projetsModel.php';
    include_once '../app/models/tagsModel.php';

    $projet = ProjetsModel\findOneById($conn, $id);
    if (!$projet) {
        http_response_code(404);
        exit('Projet introuvable.');
    }
    $creatifs = ProjetsModel\findCreatifs($conn);
    $tags = TagsModel\findAll($conn);
    $selectedTags = array_column(TagsModel\findByProject($conn, $id), 'id');

    global $title, $content;
    $title = 'Modifier un projet';
    ob_start();
    include '../app/views/projets/editForm.php';
    $content = ob_get_clean();
}

// Enregistre les modifications puis retourne a l'accueil.
function updateAction(PDO $conn, int $id)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . PUBLIC_BASE_URL);
        exit;
    }
    include_once '../app/models/projetsModel.php';
    $ancienProjet = ProjetsModel\findOneById($conn, $id);
    if (!$ancienProjet) {
        http_response_code(404);
        exit('Projet introuvable.');
    }

    $image = \Core\Helpers\uploadImage($_FILES['image'] ?? []);
    $projet = [
        'titre' => trim($_POST['titre']),
        'texte' => trim($_POST['texte']),
        // Sans nouvelle photo, conserve la photo actuelle.
        'image' => $image ?? $ancienProjet['projetImage'],
        'creatif' => (int) $_POST['creatif'],
    ];
    $tags = $_POST['tags'] ?? [];

    if (ProjetsModel\update($conn, $id, $projet, $tags)) {
        header('Location: ' . PUBLIC_BASE_URL, true, 303);
        exit;
    }
    if ($image !== null) {
        unlink('../public/images/' . $image);
    }
    exit("Le projet n'a pas pu être modifié.");
}
