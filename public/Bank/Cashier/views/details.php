
<div class="main-content">
    <form action="" method="post" enctype="multipart/form-data" name="myform">
        <input type="hidden" name="views" value="" id="views" class="form-control" />
        <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
        <input type="hidden" name="keys" value="<?php echo $keys ; ?>" id="keys" class="form-control" />
        <input type="hidden" name="nam" value="<?php echo $nam; ?>" id="nam" class="form-control" />
        <input type="hidden" name="dat" value="<?php echo $dat; ?>" id="dat" class="form-control" />
        <input type="hidden" name="p_num" value="<?php echo $p_num; ?>" id="p_num" class="form-control" />
        <input type="hidden" name="v_code" value="<?php echo $v_code; ?>" id="v_code" class="form-control" />
        <input type="hidden" name="v_cash" value="<?php echo $v_cash; ?>" id="v_cash" class="form-control" />
        <input type="hidden" name="v_altamt" value="<?php echo $v_altamt; ?>" id="v_altamt" class="form-control" />
        <input type="hidden" name="v_mde" value="<?php echo $v_mde; ?>" id="v_mde" class="form-control" />
        <input type="hidden" name="v_tot" value="<?php echo $v_tot; ?>" id="v_tot" class="form-control" />
        <div class="page-wrapper">
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Cash Payment
                        <span class="pull-right ">
                            <button class="form-tools" style="font-size:25px; padding-top:-10px;" onclick="document.getElementById('view').value='list';document.myform.submit;">×</button>
                        </span>
                    </div>
                </div>
				
				<?php $engine->msgBox($msg,$status); ?>

                <div class="col-sm-12">
                    <div class="form-group">
                        <br>
                        <div class="col-sm-12 client-info">
                            <table class="table client-table">
                                <tr>
                                    <td>
                                        <b>Name:</b>
                                        <?php echo $nam;?>
                                    </td>
                                    <td>
                                        <b>Request Date:</b>
                                        <?php echo $dat;?>
                                    </td>
                                    <td>
                                        <b>Patient No.:</b>
                                        <?php echo$p_num;?>
                                    </td>
                                    <!-- <td><b>Visit Code:</b> <?php //echo $v_code; ?></td> -->

                                </tr>
                                <tr>
                                    <td>
                                        <b>Cash:</b>
                                        <?php echo $v_cash;?> </div>
                                    </td>
                                    <td>
                                        <b>Alternate Amount:</b>
                                        <?php echo $v_altamt;?>
                                    </td>
                                    <td>
                                        <b>Payment Method:</b>
                                        <?php echo $v_mde;?>
                                    </td>
                                    <td>
                                        <b>Total:</b>
                                        <?php echo $v_tot;?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="col-sm-8 client-vitals">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Cash Cost</th>
                                    <th>Total Cost</th>
                                </tr>
                            </thead>
							
                            <tbody id="vitalsdata">
                                <!-- Table data goes here from JS.php -->
                                <?php
                                $n = 1;
                                $totalrate = 0;
                                while ($objitem = $stmtitems->FetchNextObject()){
                                    $chkitems =array();
                                    if($objitem-> B_STATUS == 1){$totalrate = $totalrate + $objitem->B_CASHAMT ;}
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" onchange="addsum(this);" name="chkitems[]" value="<?php
                                            echo $objitem->B_CODE; ?>">
                                        </td>
                                        <td>
                                            <?php echo $n++; ?>
                                        </td>
                                        <td>
                                            <?php echo $objitem->B_ITEMNAME; ?>
                                        </td>
                                        <td>
                                            <?php echo $objitem->B_CASHAMT; ?>
                                        </td>
                                        <td>
                                            <?php echo $objitem->B_TOTAMT; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                echo '<tr><td ><strong>Total</strong></td> <td></td><td></td><td></td><td><strong>'.number_format($totalrate,
                                        2).'</strong></td></tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-4 client-vitals">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="bgroup">Total Amount:</label>
                                <input type="text" class="form-control" id="tamount1" value="" name="tamount" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="bgroup">Date:</label>
                                <input type="text" class="form-control" id="fname" name="startdate">
                                <span class="add-on ">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-calendar"></i>
                                </span>
                            </div>
                            <div class="col-sm-6">
                                <label for="bgroup">Amount Paid:</label>
                                <input type="text" class="form-control" id="tamount2" placeholder="Enter figures Only..." value="" name="amtpaid">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <label for="bgroup">Description:</label>
                                <textarea type="text" class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label for="bgroup"></label>
                                <button type="button" id="addpay" onclick="document.getElementById('viewpage').value='savepay';document.getElementById('views').value='';document.myform.submit();"
                                    class="btn btn-success form-control"><i class="fa fa-check"></i> Save </button>
                            </div>
                            <div class="col-sm-6">
                                <label for="bgroup"></label>
                                <button type="button" id="addpay" onclick="document.getElementById('views').value='list';document.myform.submit();" class="btn btn-danger form-control">
                                <i class="fa fa-close"></i> Cancel </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>