<style type="text/css">
	.panel-title:hover {
     cursor: pointer;
}
.amcharts-chart-div a {display:none !important;}
 .title {
  font-size: 20px;
  font-weight: bold;
  float: left;
  padding: 0;
  margin: 0;
}
.blue-gradient {
    background: -webkit-linear-gradient(50deg, #45cafc, #303f9f)!important;
    background: linear-gradient(40deg, #45cafc, #303f9f)!important;
    -webkit-transition: .5s ease;
    transition: .5s ease
}


</style>
<?php $rs = $paging->paginate();?>
<div class="main-content">

    <div class="page-wrapper">

    	<div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Wallet Details </div>
            </div>
             <?php $engine->msgBox($msg,$status); ?>
            <div class="row">
            	<div class="col-sm-4 ">
            		<!-- <div class="row">
            			<div class="col-sm-12" style="text-align: center;"><h3>Balance</h3></div>
            			<input type="hidden" name="bal" value="<?php echo number_format($balace,2); ?>">
            			<div class="col-sm-12" style="text-align: center;"> <h3>GH&#8373; <?php echo number_format($balace,2); ?> </h3></div>
            		</div> -->
            	
            	  <div class="card card-cascade blue-gradient" style="margin-top: 50px; border-radius: 2%;color: #fff; ">

                    <!--Card image-->
                    <div class="view gradient-card-header " >
                        <h2 class="h2-responsive"  style="text-align: center; margin-top: -25px; ">Balance</h2>
                        	<input type="hidden" id="bal" name="bal" value="<?php echo $balace; ?>">
                        <h1 class="h2-responsive"  style="text-align: center;">GH&#8373; <?php echo number_format($balace,2); ?></h1>
                    </div>
                    <!--/Card image-->

                    <!--Card content-->
                    <div class="card-body text-center" >

                      
                                <div id="scrollspy" class="sticky">
                                  
                                </div>
                            <!-- /div> -->
                        <hr>
                      
                    </div>
                    <!--/.Card content-->

                </div>
            	</div>
            	<div class="col-sm-8">
            		<!-- <h5>Transfer Funds</h5> -->
            		<div class="row">
            			 <div class="col-sm-12" style="margin-top: 20px;">
            			 	<div class="row">
                     <div class="col-sm-9"><h3 class="title">Transfer Funds</h3></div> 
                         <div class="col-sm-3"><!-- <h3 class="title"></h3 --> <small  style="text-align: right;color: grey">
                         Powered by Smartpay &reg;</small></div>               
                            </div>
            			 </div>
            			<div class="col-sm-12" style="margin-top: 20px;">

            				<div class="panel-group" id="accordion">
    <!-- First Panel -->
    <div class="panel panel-default">
        <div class="panel-heading">
             <h4 class="panel-title"
                 data-toggle="collapse" 
                 data-target="#collapseOne">
                <div class="row">
                	<div class="col-sm-3"><img src="media/img/SmartPay2.png" height="45px" alt="Smartpay logo"></div>
                	<div class="col-sm-9" style="margin-left: -110px">
<span >Smartpay</span>
                	<br>	<span style="font-size: 10px;">Transfer funds into your smartpay account.</span></div>
                </div>

             </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                 Service Unavailable
            </div>
        </div>
    </div>
    
    <!-- Second Panel -->
    <div class="panel panel-default">
        <div class="panel-heading">
             <h4 class="panel-title" 
                 data-toggle="collapse" 
                 data-target="#collapseTwo">
                 <div class="row">
                	<div class="col-sm-3"><img src="media/img/mobile_money.png" height="45px" alt="Mobile logo"></div>
                	<div class="col-sm-9" style="margin-left: -110px">
<span >Mobile Money</span>
                	<br>	<span style="font-size: 10px;">Transfer funds into your mobile money account. ie MTN, TIGO, AIRTEL etc.</span></div>
                </div>
             </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body">
            <div class="row">
            	<div class="col-sm-12">
            		 <label for="gender">Mobile Network</label>
            		<select name="modetype" class="form-control">
            			<option>Select Mobile Network</option>
            			<?php foreach ($modes as $key => $value) { ?>
            				
            			<option value="<?php echo $value['mode_code'] ?>"> <?php echo $value['mode_name'] ?></option>
            			<?php } ?>
            		</select>
            	</div>
            	<div class="col-sm-12">
            		 <label for="fname">Phone Number</label>
                    <input type="text" class="form-control" id="phone" placeholder="Enter Phone number" maxlength="10" onkeypress="return isNumberKey(event);" name="phone" value="">
               
            	</div>
            	<div class="col-sm-12">
            		 <label for="fname">Amount</label>&nbsp;&nbsp;&nbsp;&nbsp;<span id="errmsg"></span>
                    <input type="text" class="form-control" id="amount" placeholder="Enter Amount"  onkeypress="return isNumberKey(event);" name="amount" value="">
               
            	</div>
<!-- <div class="col-sm-6">
	<label for="fname">Voucher Code</label>
	<input type="text" class="form-control"   placeholder="Enter Voucher Code" name="vouchercode" value="">
</div>
 -->

            	<div class="col-sm-12">
            		 <label for="fname"></label>
            		<button style="; width: 750px" id="btntransfer" type="submit" disabled="disabled" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='transfer_payment';document.myform.submit;" class="btn btn-info mybutton"> Transfer </button>
            	</div>
            </div>
            </div>
        </div>
    </div>
    
    <!-- Third Panel -->
    <div class="panel panel-default">
        <div class="panel-heading">
             <h4 class="panel-title"
                 data-toggle="collapse"
                 data-target="#collapseThree">
                 <div class="row">
                	<div class="col-sm-3"><img src="media/img/cards.png" height="45px" alt="card logo"></div>
                	<div class="col-sm-9" style="margin-left: -110px">
<span >Credit & Debit Card</span>
                	<br>	<span style="font-size: 10px;">Transfer funds into your credit & debit card. ie VISA, MASTER etc.</span></div>
                </div>
             </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
            <div class="panel-body">
                Service Unavailable
            </div>
        </div>
    </div>
</div>
    
    
    
    
    
    
<!-- Post Info -->

            	</div>

            	
            </div>
    	</div>
    </div>
    <div class="row">
    	 <div class="col-md-12">
    	 	 <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Transaction Summary </div>
            </div>
                                    <!-- Nav tabs --><div class="" style="margin-top: 10px;">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Transactions Details</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Transactions Chart</a></li>
                                        
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content" style="margin-top: 2%;">
                                        <div role="tabpanel" class="tab-pane active" id="home">
                                        	 <div class="pagination-tab">
                <div class="table-title">
                    <div class="col-sm-3">
                        <div id="pager">
                            <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                            <?php echo $paging->renderPrev('<span class=""></span>','<span class="fa fa-arrow-circle-left"></span>');?>
                            <input name="page" type="text" class="pagedisplay short" value="<?php echo $paging->renderNavNum();?>" readonly />
                            <?php echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>
                            <?php echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>
                            <?php $paging->limitList($limit,"myform");?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';document.getElementById('view').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                    <div class="pagination-right">
                        <!-- Content goes here -->
                    </div>
                </div>
            </div>
<table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction Code</th>
                    <th>Transaction Type</th>
                    <th>Paid By</th>
                    <th>Amount</th>
                    <th>Date</th>
                   <th>Time</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $num = 1;
                if($paging->total_rows > 0 ){
                    $page = (empty($page))? 1:$page;
                    $num = (isset($page))? ($limit*($page-1))+1:1;
                    while(!$rs->EOF){
                        $obj = $rs->FetchNextObject();
                        $time=date('H:i:s',strtotime($obj->HRMSTRANS_INPUTDATE)) ;
                        $date1=date('d/m/y',strtotime($obj->HRMSTRANS_DATE));
                        if($obj->HRMSTRANS_USERTYPE =='1'){
                        	$type="Doctor";
                        }else{
                        	$type="Patient";
                        }
                        $currency='¢';
                        $money=number_format($obj->HRMSTRANS_AMOUNT,2);
                        $myAmount= $currency.' '.$money;
                        $name=$obj->USR_SURNAME.' '.$obj->USR_OTHERNAME;
                        echo '<tr>
                        <td>'.$num.'</td>
                        <td>'.$obj->HRMSTRANS_CODE.'</td>
                        <td>'.$type.'</td>
                        <td>'.$name.'</td>
                        <td>'.$myAmount.'</td>
                        <td>'.$date1.'</td>
                        <td>'.$time.'</td>
                        
                      
						
                    </tr>';
                        $num ++; }}
                ?>
                </tbody>
           </table>

                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="profile">
                                        	<div class="col-sm-12">
                                        		<h3><center> <span class="caption-subject bold uppercase font-green-haze" style="" > Transactions Chart (<?php echo date("Y"); ?>)</span></center></h3>
                                        		 <div id="chartdiv" style="width: 100%; height: 350px;"></div>
                                        	</div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="messages"></div>
                                        <div role="tabpanel" class="tab-pane" id="settings"></div>
                                    </div>
</div>
                                </div>
    	
            </div>


            	</div>
    </div>
</div>
<script type="text/javascript">
	$(function () {

    var active = true;

    $('#collapse-init').click(function () {
        if (active) {
            active = false;
            $('.panel-collapse').collapse('show');
            $('.panel-title').attr('data-toggle', '');
            $(this).text('Enable accordion behavior');
        } else {
            active = true;
            $('.panel-collapse').collapse('hide');
            $('.panel-title').attr('data-toggle', 'collapse');
            $(this).text('Disable accordion behavior');
        }
    });
    
    $('#accordion').on('show.bs.collapse', function () {
        if (active) $('#accordion .in').collapse('hide');
    });

});
	function isNumberKey(evt){
   // alert('dfgdfgsdff');
    
    var charCode=(evt.which) ? evt.which : evt.keyCode
    return !(charCode > 31 && (charCode < 48 || charCode >57));
}

//check balance
$('#amount').keyup(function(){
	var subBut = $('#btntransfer');

	if ($(this).val() > 1000){
    // alert("No numbers above 1000");
     $("#errmsg").html("Maximum amount 1000").show().css("color","red");
     	subBut.attr("disabled", "disabled")
    $(this).val('1000');
  }
	if ($(this).val() < 50){
    // alert("No numbers above 1000");
     $("#errmsg").html("Minimum amount is 50").show().css("color","red");
     	subBut.attr("disabled", "disabled")
    // $(this).val('50');
  }
  // if ($(this).val() >= <?php echo number_format($balace,2); ?>){
  //   // alert("insuffient fund");
  //   subBut.attr("disabled", "disabled");
  //   $("#errmsg").html("Insufficient funds").show().css("color","red"); 
           
  //   $(this).val('');
  //    return false;
  // }

  if (($(this).val() <= 1000) && ($(this).val() >= 50) && ($(this).val() <= <?php echo number_format($balace,2); ?>)){
    // alert("insuffient fund");
    subBut.removeAttr('disabled') 
     return true;
  }
});
// disable 

</script>
<script>
            var chart;

            var chartData = [
                {
                    "country": "January",
                    "visits": <?php echo $jan;?>
                },
                {
                    "country": "February",
                    "visits": <?php echo $feb;?>
                },
                {
                    "country": "March",
                    "visits": <?php echo $mar;?>
                },
                {
                    "country": "April",
                    "visits": <?php echo $apr;?>
                },
                {
                    "country": "May",
                    "visits": <?php echo $may;?>
                },
                {
                    "country": "June",
                    "visits": <?php echo $jun;?>
                },
                {
                    "country": "July",
                    "visits": <?php echo $jul;?>
                },
                {
                    "country": "August",
                    "visits": <?php echo $aug;?>
                },
                {
                    "country": "September",
                    "visits": <?php echo $sep;?>
                },
                {
                    "country": "October",
                    "visits": <?php echo $oct;?>
                },
                {
                    "country": "November",
                    "visits": <?php echo $nov;?>
                },
                {
                    "country": "December",
                    "visits": <?php echo $dec;?>
                }
               
                
               
            ];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "country";
                chart.startDuration = 1;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.gridPosition = "start";

                // value
                // in case you don't want to change default settings of value axis,
                // you don't need to create it, as one value axis is created automatically.

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "visits";
                graph.balloonText = "[[category]]: <b>[[value]]</b>";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 0.8;
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = false;
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = "top-right";

                chart.write("chartdiv");
            });
        </script>