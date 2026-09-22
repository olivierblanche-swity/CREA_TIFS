<?php

// Route /projets/

use App\Controllers\ProjetsController;

include_once '../app/controllers/projetsController.php';

switch ($_GET['projets']):

    case 'edit':
        ProjetsController\editAction($conn, (int) $_GET['id']);
        break;

    case 'update':
        ProjetsController\updateAction($conn, (int) $_GET['id']);
        break;

    case 'delete':
        ProjetsController\deleteAction($conn, (int) $_GET['id']);
        break;

    case 'insert':
        ProjetsController\insertAction($conn);
        break;

    case 'addForm':
        ProjetsController\addFormAction($conn);
        break; 

    case 'show':
        ProjetsController\showAction($conn,$_GET['id']);
        break;

endswitch;


