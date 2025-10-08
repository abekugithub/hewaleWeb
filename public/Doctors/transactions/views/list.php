<?php
  $rs = $paging->paginate();
  $fdsearch = "";
?>
<form name="myform" id="myform" method="post" action="#">
  <input id="view" name="view" value="" type="hidden" />
  <input id="viewpage" name="viewpage" value="" type="hidden" />
  <input id="keys" name="keys" value="" type="hidden" />
  <input id="micro_time" name="micro_time" value="<?php echo md5(microtime()); ?>" type="hidden" />
  <div class="content">
  <div class="page-header">
    <h1 class="title">Transactions</h1>
    <!--<ol class="breadcrumb">
      <li class="active">&nbsp;</li>
    </ol>-->
    
    <!-- Start Page Header Right Div -->
    <div class="right">    
        <div class="btn-group">
	
      </div>
    </div>
    <!-- End Page Header Right Div --> 
    
  </div>
    <!-- End Page Header Right Div -->
    
    
    <span id="msg"><?php $engine->msgBox($msg,$status); ?></span>
    
   <div class="panel-body table-responsive">
   <div class="table-title">
   <div class="col-sm-3 col-xs-5">
          <div id="pager">
                  <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                  <?php echo $paging->renderPrev('<span class=""></span>','<span class="fa fa-arrow-circle-left"></span>');?>
                  <input name="page" type="text" class="pagedisplay short" value="<?php echo $paging->renderNavNum();?>" readonly />
                  <?php echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>
                  <?php echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>
                  <?php $paging->limitList($limit,"myform");?>
          </div>
        </div>
        <div class=" col-sm-4 col-xs-6">
          <div class="input-group ">
            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch"  placeholder="Search..."/>
            <span class="input-group-btn">
              <button type="submit" onClick="document.getElementById('view').value='';document.getElementById('viewpage').value='searchitem';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
        <div class="col-sm-2 col-xs-2">
            <div class="btn-group">
                
                <button type="submit" onClick="document.getElementById('view').value='';document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-gyn-teal square"> <i class="fa fa-refresh"></i> </button>
            </div>
        </div>
        <div class="add-search">
		<button type="submit" onClick="document.getElementById('view').value='add_new';document.myform.submit;" 
        class="btn btn-gyn-teal square"><i class="fa fa-plus"></i> Add Trasnsaction</button>
      </div>
    </div>

   
        <table class="table table-hover member_info">
          <thead>
            <tr>
              <th>#</th>
              <th>Memeber Name</th>
              <th>Transaction Type</th>
              <th>Amount</th>
              <th>Date Added</th>
              <th>Actor</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
          <?php
			      $num=1; $i=1;
            $url = 'media/uploaded/';
            if($paging->total_rows > 0){
              $page = (empty($page))? 1:$page;
              $num = (isset($page))? ($limit*($page-1))+1:1;
              $obj   = $rs->GetAll();
              foreach($obj as $row){
              list($memname,$transoption,$transamount,$transdateadded,$username)=$row;  
		      ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo $memname; ?></td>
              <td><?php echo $transoption; ?></td>
              <td><?php echo $currency.$transamount; ?></td>
              <td><?php echo date('d-m-Y',strtotime($transdateadded)); ?></td>
              <td><?php echo $username;?></td>
              <td>
              <div class="btn-group">
              	  <!--<button type="submit" class="btn btn-gyn-teal square" onClick="document.getElementById('keys')
                    .value='<?php //echo $obj->TI_ID ?>';document.getElementById('viewpage')
                    .value='edit';document.getElementById('view')
                    .value='edit';document.myform.submit;" title="Edit"><i class="fa fa-pencil"></i>
                  </button>-->
                  &nbsp;
                  <button type="submit" class="btn btn-danger square" onClick="document.getElementById('keys')
                    .value='<?php echo $obj->TI_ID ?>';document.getElementById('viewpage')
                    .value='delete_tithe';document.myform.submit; return confirmDelete(this);" title="Delete">
                    <i class="fa fa-trash"></i>
                  </button>
                  <script>
                     function confirmDelete(link) {
                        if (confirm("Are you sure you want to Delet this Record?")) {
                            doAjax(link.href, "POST"); // doAjax needs to send the "confirm" field
                        }
                         return false;
                     }
                  </script>
              </div>
              </td>
            </tr>
            <?php }
              }else{
              echo '<tr class="odd pointer">
                      <td class="a-center " colspan="6">
                          No Record Found.
                      </td>
                    </tr>';
                  }
          	?>
          </tbody>
        </table>
      </div><div class="space"></div>
   </div>
</form>

