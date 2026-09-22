<?php

// Route /creatifs/

use App\Controllers\CreatifsController;

include_once '../app/controllers/creatifsController.php';

switch ($_GET['creatifs'] ?? ''):
    
    case 'index':
        
        CreatifsController\indexAction($conn);
        break;

    default:
        return;
endswitch;
