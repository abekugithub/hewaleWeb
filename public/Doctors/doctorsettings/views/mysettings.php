<div class="main-content">
    <div class="page-wrapper">
<!--        <ul class="nav nav-tabs">-->
<!--            <li class="active"><a data-toggle="tab" href="#complains">Consultation Setup</a></li>-->
<!--            <li><a data-toggle="tab" href="#labs">Drug Setup</a></li>-->
<!--        </ul>-->

        <div class="page form">
            <?php $engine->msgBox($msg,$status); ?>
            <div class="tab-content">
                <!--    Start Tab    -->
                <div id="complains" class="tab-pane fade in active">
                    <div class="moduletitle" style="margin-bottom:33px;">
<!--                        <button type="submit" style="border-radius: 1px;margin-left: 1em" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-danger pull-right"> Cancel </button>-->
<!--                        <button type="submit" style="border-radius: 1px;" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='save';document.myform.submit;" class="btn btn-info pull-right"> Save </button>-->
                        <div class="moduletitleupper">Set up</div>

                    </div>

                    <div class="col-sm-12">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label for="currency">Currency:</label>
                                    <select id="dr_currency" name="dr_currency" class="form-control" readonly>
<!--                                        <option value="" disabled selected>Currency</option>-->
                                        <?php foreach($currencies as $curr){ ?>
                                            <option value="<?php echo $curr->CY_CODE;?>" <?php echo (($dr_currency == $curr->CY_CODE)?"selected":"");?>>
                                                <?php echo $curr->CY_CODE; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="charges">Charge per Consultation:</label>
                                    <input type="text" class="form-control" value="<?php echo $charges; ?>" id="charges" name="charges">
                                </div>

                                <div class="col-sm-4">
                                    <label for="numbercons">Maximum Number of Consultation Per Day:</label>
                                    <input type="number" class="form-control" id="numbercons" name="numbercons" value="<?php echo (!empty($numbercons)?$numbercons:'')?>">
                                </div>
                            </div>
                        </div>
                           <div class="row">
                               <div class="form-group">
                                   <div class="col-sm-12" style="margin-bottom:10px;">

                                       <label for="emername2">Drugs per Country</label>
                                       <select class="form-control select2" multiple name="drugcountry[]" id="drugcountry[]">
                                           <option value="" disabled>-- Select Country --</option>
                                           <?php
                                           $stmt = $engine->getCountry();
                                           while ($country = $stmt->FetchNextObj()){?>
                                               <option value="<?php echo $country->CN_COUNTRY; ?>" <?php foreach ($drug_country as $drg_count){echo ($drg_count==$country->CN_COUNTRY)?'selected':'';} ?> >
                                                   <?php echo $country->CN_COUNTRY; ?>
                                               </option>
                                           <?php } ?>
                                       </select>
                                   </div>

                               </div>
                           </div>
                        <br>
                        <div class="row">
                            <div class="form-group" style="margin-bottom:10px;">

                                    <div class="col-sm-4">
                                        <label for="qconsult">Charge per Appointment</label>
                                        <input type="text" class="form-control" id="perappoint" name="perappoint" value="<?php
                                        echo (!empty($perappoint)?$perappoint:'')?>">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="qconsult">Charge per quick consult <span
                                                    id="charts"></span></label>
                                        <input type="text" class="form-control" id="perqconsult" name="perqconsult"
                                               value="<?php echo (!empty($perqconsult)?$perqconsult:'')?>">
                                    </div>

                                <div class="col-sm-4">
                                    <label for="currency">Quick consult charge type:</label>
                                    <select id="qconsulttype" name="qconsulttype" class="form-control" onchange="SelectChange()" required>
                                        <option value="1" <?php echo (($qconsulttype == 1)?'Selected':'')
                                        ?>>PER MESSAGE</option>
                                        <option value="2" <?php echo (($qconsulttype == 2)?'Selected':'')
                                        ?>>PER SESSION</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="form-group" style="margin-bottom:10px;">

                                    <div class="col-sm-4">
                                        <label for="premserCharge">Charge for Premium Service</label>
                                        <input type="text" class="form-control" id="premserCharge" name="premserCharge" value="<?php
                                        echo (!empty($premserCharge)?$premserCharge:'')?>">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="premserChargeNurses">Premium Service Charge for Nurses <span
                                                    id="charts"></span></label>
                                        <input type="text" class="form-control" id="premserChargeNurses" name="premserChargeNurses"
                                               value="<?php echo (!empty($premserChargeNurses)?$premserChargeNurses:'')?>">
                                    </div>
                                <!--
                                <div class="col-sm-4">
                                    <label for="currency">Quick consult charge type:</label>
                                    <select id="qconsulttype" name="qconsulttype" class="form-control" onchange="SelectChange()" required>
                                        <option value="1" <?php //echo (($qconsulttype == 1)?'Selected':'')
                                        ?>>PER MESSAGE</option>
                                        <option value="2" <?php //echo (($qconsulttype == 2)?'Selected':'')
                                        ?>>PER SESSION</option>
                                    </select>
                                </div>
                                -->
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12" >
                                <label for="emername2">Disclaimer</label>
                                <textarea class="form-control" rows="5" id="comment" placeholder="" name="disclaimer">
                                    <?php echo (!empty($disclaimer)?$disclaimer:'')?>  </textarea>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="container-fluid" style="margin-top: 12em">
                        <div class="col-sm-4">
                            <button type="submit" style="border-radius: 1px;" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='save';document.myform.submit;" class="btn btn-info"> Save </button>
                            <button type="submit" style="border-radius: 1px;" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-danger"> Cancel </button>
                        </div>
                </div>


                </div>
                <!--    End Tab    -->





















                <!--    Start Tab    -->
                <div id="labs" class="tab-pane fade">
                    <h3>Setup your drug register for consultation</h3>
                    <p>Select Country's drug register you want to use for prescribing medication to your patient</p>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="emername2">Drug Country</label>
                                <select class="form-control select2" multiple name="drugcountry[]" id="drugcountry[]">
                                    <option value="" disabled>-- Select Country --</option>
                                    <?php
                                    $stmt = $engine->getCountry();
                                    while ($country = $stmt->FetchNextObj()){?>
                                        <option value="<?php echo $country->CN_COUNTRY; ?>" ><?php echo $country->CN_COUNTRY; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid" style="margin-top: 7em">
                        <div class="col-sm-4">
                            <button type="submit" style="border-radius: 1px;" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='saveDrugCountry';document.myform.submit;" class="btn btn-info"> Save </button>
                        </div>
                    </div>
                </div>
                <!--    End Tab    -->
            </div>
        </div>
    </div>
</div>