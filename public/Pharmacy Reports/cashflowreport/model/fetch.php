<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/25/2017
 * Time: 11:59 AM
 */
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();
$doc = new doctorClass();
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($datefrom) && !empty($dateto)){
    $from = date("Y-m-d",strtotime($datefrom));
    $to = date("Y-m-d",strtotime($dateto));
    $date = DateTime::createFromFormat('d/m/Y', $datefrom);
    $from2= $date->format('Y-m-d'); // => 2013-12-24 
    $date2 = DateTime::createFromFormat('d/m/Y', $dateto);
    $to2= $date2->format('Y-m-d'); // => 2013-12-24

     // $to2 = strftime("%Y-%m-%d",strtotime($dateto));
    // echo $from2.' '.$to2.'<br>';
    // echo $from.' '.$dateto;
    // die();
  //   $stmt = $sql->Execute($sql->Prepare("SELECT HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_RECEIVER,HRMSTRANS_DATE,HRMSTRANS_STATUS,HRMSTRANS_TYPE,HRMSTRANS_DESCRIPTION,HRMSTRANS_INPUTDATE,HRMSTRANS_CONFIRM_STATUS,HRMSTRANS_TRANS_TOKEN,CASE HRMSTRANS_STATUS WHEN '1' THEN 'Credit' WHEN '2' THEN 'Debit' END HRMSTRANS_STATUS FROM hms_wallet_transaction WHERE HRMSTRANS_RECEIVER = ".$sql->Param('a')." OR HRMSTRANS_USERCODE = ".$sql->Param('a')." AND HRMSTRANS_DATE BETWEEN ".$sql->Param('a')." AND ".$sql->Param('a')." AND HRMSTRANS_STATUS IN ('1','2')"),array($activeinstitution,$activeinstitution,$from2,$to2)); 
    $stmt = $sql->Execute($sql->Prepare("SELECT HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_RECEIVER,HRMSTRANS_DATE,HRMSTRANS_STATUS,HRMSTRANS_TYPE,HRMSTRANS_DESCRIPTION,HRMSTRANS_INPUTDATE,HRMSTRANS_CONFIRM_STATUS,HRMSTRANS_TRANS_TOKEN,    CASE HRMSTRANS_STATUS WHEN '1' THEN 'Credit' WHEN '2' THEN 'Debit' END HRMSTRANS_STATUS FROM hms_wallet_transaction WHERE HRMSTRANS_RECEIVER = ".$sql->Param('a')." AND HRMSTRANS_DATE BETWEEN ".$sql->Param('a')." AND ".$sql->Param('a')." AND HRMSTRANS_STATUS IN ('1','2')"),array($activeinstitution,$from2,$to2));
    print $sql->ErrorMsg();
    // var_dump($stmt);
    // die();
    //No.'.$number.'   Patient : '. $details_array[$key][0].'('.$details_array[$key][1].')'.  ' Prescribed By : '. $details_array[$key][2].'
    $data_array = [];
    if ($stmt->RecordCount()>0){
        while ($obj=$stmt->FetchNextObject()){
            $data_array[]= array('HRMSTRANS_CODE'=>$obj->HRMSTRANS_CODE,'HRMSTRANS_WALCODE'=>$obj->HRMSTRANS_WALCODE,'HRMSTRANS_USERCODE'=>$obj->HRMSTRANS_USERCODE,'HRMSTRANS_USERTYPE'=>$obj->HRMSTRANS_USERTYPE,'HRMSTRANS_AMOUNT'=>$obj->HRMSTRANS_AMOUNT,'HRMSTRANS_DATE'=>$obj->HRMSTRANS_DATE,'HRMSTRANS_RECEIVER'=>$obj->HRMSTRANS_RECEIVER,'HRMSTRANS_STATUS'=>$obj->HRMSTRANS_STATUS,'HRMSTRANS_TYPE'=>$obj->HRMSTRANS_TYPE,'HRMSTRANS_DESCRIPTION'=>$obj->HRMSTRANS_DESCRIPTION,'HRMSTRANS_INPUTDATE'=>$obj->HRMSTRANS_INPUTDATE,'HRMSTRANS_CONFIRM_STATUS'=>$obj->HRMSTRANS_CONFIRM_STATUS,'HRMSTRANS_TRANS_TOKEN'=>$obj->HRMSTRANS_TRANS_TOKEN);
        }
        if(is_array($data_array) && count($data_array)>0){
            $number=1;
            $result.= '<br><table class="table table-hover" >
                    <thead>
                    	<th colspan="3">Preview : @'. date("d/m/Y").'</th>
                    	<th colspan="2"></th>
                    	<th colspan="3"></th>
                        <tr>
                            <th colspan="4" style="border-bottom: none">From: '.$datefrom.'</th>
                        </tr>
                        <tr>
                            <th colspan="4" style="border-top: none">To: '.$dateto.'</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th width="200px">Transaction Code</th>
                            <th width="400px">Sender</th>
                            <th width="200px">Receiver</th> 
                          
                            <th width="100px">Amount</th>
                            <th width="100px">Status</th>
                           
                            <th width="200px">Date</th>
                            
                            
                        </tr>
                        </thead>';
            $num = 1;
            $result .='
                    <tbody>';
            foreach ($data_array as $key=>$val){
              
                            // if ($val['HRMSTRANS_USERTYPE']=='2') {
                            //     # code...
                            //     $sta="Pharmacy";
                            // }else{
                            //    $sta="Self"; 
                            // }
                 if($val['HRMSTRANS_USERTYPE'] =='1'){
                            $type="Doctor";
                        }elseif($val['HRMSTRANS_USERTYPE'] =='2'){
                            $type="Patient";
                        }elseif($val['HRMSTRANS_USERTYPE'] =='3'){
                            $type="Lab";
                        }elseif($val['HRMSTRANS_USERTYPE'] =='4'){
                            $type="Pharmacy";
                        }elseif($val['HRMSTRANS_USERTYPE'] =='5'){
                            $type="Courier";
                        }
                        $sta=!empty($engine->getPaymentBy($val['HRMSTRANS_USERCODE']))?$engine->getPaymentBy($val['HRMSTRANS_USERCODE']): $type;
                          if($val['HRMSTRANS_USERTYPE']==2){
                       $status=$engine->getFacDetCode($val['HRMSTRANS_RECEIVER']);
                      }else{
                         $status=$sta;
                      }

                $result.='<tr><td>'.$num++.'</td>
                        <td>'.$val['HRMSTRANS_CODE'].'</td>
                        
                        <td>'.$engine->getUSerDetils($val['HRMSTRANS_USERCODE']).'</td>
                        <td>'.$status.'</td>
                      
                        <td>'.$val['HRMSTRANS_AMOUNT'].'</td>
                        <td>'.$val['HRMSTRANS_STATUS'].'</td>
                       
                        <td>'.$val['HRMSTRANS_DATE'].'</td>
                        </tr>';
                $number++;
            }
            $result.='</tbody>
                </table>';
        }
    }else{
        $result.='<table class="table table-hover" >
                <tbody>
                <tr>
                <td colspan="6">No record found.</td>
				</tr>
				</tbody>
				</table>
				';
    }
    echo $result;
}
?>