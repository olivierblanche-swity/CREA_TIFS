<?php


     /**
      * 4 route des tags
      */
if (isset($_GET['tags'])):
     include_once '../app/routers/tags.php';
     /**
      * 3 route des creatifs
      */
elseif (isset($_GET['creatifs'])):
     include_once '../app/routers/creatifs.php';
     /**
      * 2 route des projets
      */
elseif (isset($_GET['projets'])):
     include_once '../app/routers/projets.php';

else:
     /**
      * 1  route par defaut
      * PATTERN: /
      * CTRL:projetsController
      * ACTION: index
      * 
      */

     include_once '../app/controllers/projetsController.php';
     \App\Controllers\projetsController\indexAction($conn);

endif;
