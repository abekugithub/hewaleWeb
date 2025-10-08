<?php
  $catmenu = $menus->getAllCategory();
?>
<div id="mySidenav" class="sidenav">
    <div class="applogo">
        <span>Hewale <b>HMS</b></span>
        <!--<img src=""/>-->
    </div>
    <a href="index.php?action=index&pg=dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>

 <?php
  $i=1; $x=1;
  while($objcatmenu = $catmenu->FetchNextObject()){
	$smtdetailsmenu = $menus->getMenuViewAccessRightSide($objcatmenu->MENUCAT_CODE);
	?>
  <a href="#submenu_<?php echo $i++; ?>" data-toggle="collapse" data-parent="#MainMenu"><i class="<?php echo $objcatmenu->MENUCAT_ICONS;?>"></i> <?php echo $objcatmenu->MENUCAT_NAME ; ?><i class="fa fa-plus more-nav"></i></a>
    <div class="collapse" id="submenu_<?php echo $x++; ?>">
	   <?php while($objdetailsmenu = $smtdetailsmenu->FetchNextObject()){
	    $linkview = 'index.php?pg='.md5($objcatmenu->MENUCAT_NAME).'&amp;option='.md5($objdetailsmenu->MENUDET_NAME).'&uiid='.md5('1_pop');
       echo '<a href="#" onClick="CallWindow(\''.$linkview.'\')" class="list-group-item">'.$objdetailsmenu->MENUDET_NAME.'</a>';
	   }?>

    </div>
 <?php }
 echo '<a href="index.php?action=index&pg='.md5('Setup').'&amp;option='.md5('Change Password').'"><i class="fa fa-lock"></i> Change Password</a>';
  ?>

</div>