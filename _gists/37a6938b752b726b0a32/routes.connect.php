<?php
 
Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
 
Router::connect('/custom', array('controller' => 'wherever', 'action' => 'index'));
// ... Other routes
 
require CAKE . 'Config/routes.php';
