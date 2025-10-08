<?php
echo $subfold = basename($_SERVER['REQUEST_URI']);
header('Location:../../index.php?action=Login&inst='.$subfold);
die();
?>