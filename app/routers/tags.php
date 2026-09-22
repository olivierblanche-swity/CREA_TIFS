<?php

// Route /tags/

use App\Controllers\TagsController;

include_once '../app/controllers/tagsController.php';

switch ($_GET['tags'] ?? ''):
    
    case 'index':
        
        TagsController\indexAction($conn);
        break;

    default:
        return;
endswitch;
