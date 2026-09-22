<?php



if (isset($_GET['tags'])):
     include_once '../app/routers/tags.php';

elseif (isset($_GET['creatifs'])):
     include_once '../app/routers/creatifs.php';

elseif (isset($_GET['projets'])):
     include_once '../app/routers/projets.php';

else:
     /**
      * 1  route par defaut
      * PATTERN: /
      * CTRL:homeController
      * ACTION: home
      * 
      */

     include_once '../app/controllers/homeController.php';
     \App\Controllers\homeController\homeAction($conn);

endif;
