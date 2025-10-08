<script src="public/Doctors/gosocial/scripts/angular.min.js"></script>
<script src="public/Doctors/gosocial/scripts/main.scripts.js"></script>
<?php
    include 'controller.php';
    switch($view){
        case 'details':
            include "views/details.php";
        break;
        default:
            include "views/list.php";
        break;
    }
?>