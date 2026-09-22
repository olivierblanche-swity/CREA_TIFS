<?php

// Route /creatifs/{id}/{slug}.html reecrite en index.php?creatifs=show&id={id}.
switch ($_GET['creatifs'] ?? ''):
    
    case 'show':
        include_once '../app/controllers/creatifsController.php';
        \App\Controllers\CreatifsController\indexAction($conn);
        break;

    default:
        return;
endswitch;
