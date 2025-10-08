<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Social Health</title>
    <link rel="icon" href="media/img/favicon.png" type="image/png" sizes="16x16">

    <link rel="stylesheet" href="media/css/login.css">
    <script type="text/javascript" src="media/js/jquery.min.js"></script>
    <script type="text/javascript" src="media/js/sweet-alert.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#loading").fadeOut("slow");
        });
        setTimeout(function () {
            $('.login-msg').hide();
        }, 5000);
    </script>

</head>

<body id="background">
    <div id="background-overlay">
        <div class="lds-css" id="loading">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div style="width:100%;height:100%;" class="lds-ripple">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(isset($attempt_in)){?>
        <div class="alert-danger">
            <?php
                    if($attempt_in < 3){
                        $msg =  'Invalid user name or password.';
                    }else if($attempt_in =='11'){
                        $msg = 'Invalid Code entered.';
                    }else if($attempt_in =='120'){
                        $msg = 'Suspended account.';
                    }else if($attempt_in =='140'){
                        $msg = 'Locked. Wait for 5min and try again.';
                    }else if($attempt_in =='110'){
                        $msg = 'User account locked.';
                    }
                ?>
        </div>
        <?php } ?>

        <div class="wrapper fadeInDown">
            <div id="formContent" class="">
                <!--            <input type="text" name="msg" id="msg" value="-->
                <?php //echo $msg?>
                <!--" />-->
                <?php echo (($msg))?'<div class="login-msg">'.$msg.'</div>':''; ?>
                <div class="success-msg" hidden></div>
                <!-- Tabs Titles -->
                <h2 class="active"> Sign In </h2>
                <h2 class="inactive underlineHover" onClick="mod('signUp');"><a href="#">Sign Up </a></h2>

                <!-- Icon -->
                <div class="fadeIn first">
                    <?php echo (!empty($instlogo)?'<img src="media/uploaded/logo/'.$instlogo.'" id="icon" alt="User Icon" />':'<img src="media/img/hewale-logo.svg" id="icon" alt="User Icon" />') ; ?>
                </div>
                <div class="company-name">
                    <?php echo ((isset($inst) && !empty($inst))?$instname:'Social Health'); ?>
                </div>
                <!-- Login Form -->
                <form class="form-signin" action="index.php?action=index&pg=1" method="post" enctype="application/x-www-form-urlencoded"
                    name="loginForm" id="loginForm" autocomplete="off">

                    <?php if(isset($inst) && empty($inst)){?>
                    <input type="text" id="login" class="fadeIn second" name="uname" placeholder="user name">
                    <?php } ?>
                    <!-- Hidden user text field with predefined extension -->
                    <?php if(isset($inst) && !empty($inst)){?>
                    <div class="hidfrm">
                        <div class="hidfrml">

                            <input type="text" class="fadeIn second" name="uname" placeholder="user name">

                        </div>
                        <div class="hidfrmr">


                            <input type="text" class="fadeIn second" name="alias" value="@<?php echo $instalias ;?>" readonly>

                        </div>
                    </div>
                    <?php } ?>
                    <input type="password" id="password" class="fadeIn third" name="pwd" placeholder="password">
                    <div class="turing">
                        <a href="#">
                            <div class="turing reload"><b>&#x21BA; reload code</b></div>
                        </a>
                        <div class="turing text"><input type="text" id="login" style="width:97.5%;" class="fadeIn second" name="txtcaptha" placeholder="enter code"></div>
                        <div class="turing code">
                            <img id="turingimg" src="plugins/turing/turing.php" style="width:90%;height:47px;margin-bottom:6px; margin-top:3px;background:transparent;">
                        </div>
                    </div>

                    <input type="submit" class="fadeIn fourth" value="Log In">
                    <input type="hidden" name="doLogin" id="doLogin" value="systemPingPass" />
                    <input type="hidden" name="inst" id="inst" value="<?php echo ((isset($inst) && !empty($inst))?$inst:'') ?>" />
                </form>

                <!-- Remind Passowrd -->
                <div id="formFooter">
                    <a class="underlineHover" href="#">Forgot Password?</a>
                </div>

            </div>
        </div>

    </div>


    <!-- The Modal for Option for Sign-up -->
    <div id="signUp" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onClick="closeMod('signUp')">&times;</span>
                <span class="text">Select an option</span>
            </div>
            <div class="modal-body">
                <p>
                    <div class="tabs">
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn" onClick="mod('docReg');">
                                    <img src="media/img/doctor.svg"/><br>
                                    <label>Doctors</label>
                                </button>
                        </div>
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn" onClick="mod('labReg');">
                                    <img src="media/img/lab.svg"/><br>
                                    <label>Laboratory / X-ray</label>
                                </button>
                        </div>
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn" onClick="mod('pharmReg');">
                                    <img src="media/img/pharmacy.svg"/><br>
                                    <label>Pharmacy</label>
                                </button>
                        </div>
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn" onClick="mod('hospitalReg');">
                                    <img src="media/img/hospital.svg"/><br>
                                    <label>Hospital</label>
                                </button>
                        </div>
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn" onClick="mod('courierReg');">
                                    <img src="media/img/courier.svg"/><br>
                                    <label>Courier</label>
                                </button>
                        </div>
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn" onClick="mod('vitalsPost');">
                                    <img src="media/img/icons/113-vital-post.png"/><br>
                                    <label>Nurse / Vitals Post</label>
                                </button>
                        </div>
                    </div>
                </p>
            </div>
        </div>

    </div>

    <!-- The Modal for Doctors Registration-->
    <div id="docReg" class="modal">

        <!-- Modal content -->
        <p>
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close" onClick="closeMod('docReg')">&times;</span>
                    <span class="text">Doctor Registration</span>
                </div>
                <div class="modal-body">
                    <p>
                        <div class="modal-wrapper">
                            <form class="form-signin" action="#" method="post" enctype="application/x-www-form-urlencoded" name="doctorForm" id="doctorForm"
                                autocomplete="off">
                                <div class="form-objs">
                                    <div class="form-objl"><input type="text" class="fadeIn second" id="fname" name="fname" placeholder="First Name"
                                            required></div>
                                    <div class="form-objr"><input type="text" class="fadeIn second" id="lname" name="lname" placeholder="Last Name"
                                            required></div>
                                </div>
                                <div class="form-objs">
                                    <input type="text" class="fadeIn second" id="location" name="location" placeholder="Location" required>
                                    <input type="email" class="fadeIn second" id="email" name="email" placeholder="E-mail" required>
                                </div>
                                <div class="form-objs">
                                    <div class="form-objl"><input type="tel" class="fadeIn second" id="phonenum" name="phonenum" placeholder="Phone Number"
                                            required></div>
                                    <div class="form-objr"><input type="text" class="fadeIn second" id="registration_num" name="registration_num"
                                            placeholder="License No." required></div>
                                </div>
                                <div class="form-objs">
                                    <select id="specialisation" name="specialisation" class="fadeIn second" >
                                        <option value="" disabled selected>Specialisation</option>
                                        <?php
                                        $stmts = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_st_speciality WHERE SP_STATUS ='1'"));
                                        while($objs = $stmts->FetchNextObject()){
                                            ?>
                                            <option value="<?php echo $objs->SP_CODE;?>"<?php echo (($specialisation == $objs->SP_CODE)?"selected":"");?>>
                                                <?php echo $objs->SP_NAME; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                        </div>

                    </p>
                </div>
                <div class="modal-footer">
                    <div class="form-objs">
                        <div class="form-objl"><input type="button" class="fadeIn third" id="doctor" value="Submit"></div>
                        <div class="form-objr"><input type="button" class="fadeIn third btn-danger" value="Close" onClick="closeMod('docReg')"></div>
                    </div>
                    </form>
                </div>
            </div>
        </p>

    </div>

    <!-- The Modal for Vital Post Registration-->
    <div id="vitalsPost" class="modal">

        <!-- Modal content -->
        <p>
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close" onClick="closeMod('vitalsPost')">&times;</span>
                    <span class="text">Nurse / Vitals Post Registration</span>
                </div>
                <div class="modal-body" id="vitalspost">
                    <p>
                        <div class="modal-wrapper">
                            <form class="form-signin" action="#" method="post" enctype="application/x-www-form-urlencoded" name="VitalsForm" id="VitalsForm"
                                autocomplete="off">
                                <div class="form-objs">
                                    <select name="vital_nurse" class="fadeIn second" id="vital_nurse" placeholder="Nurse">
                                        <option value="" disabled selected>Select Option</option>
                                        <option value="1">Nurse</option>
                                        <option value="2">Vital Post</option>
                                    </select>
                                </div>
                                <div class="form-objs">
                                    <div class="form-objl"><input type="text" class="fadeIn second" id="fname" name="fname" placeholder="First Name"
                                            required></div>
                                    <div class="form-objr"><input type="text" class="fadeIn second" id="lname" name="lname" placeholder="Last Name"
                                            required></div>
                                </div>
                                <div class="form-objs">
                                    <input type="text" class="fadeIn second" id="location" name="location" placeholder="Location" required>
                                    <input type="email" class="fadeIn second" id="email" name="email" placeholder="E-mail" required>
                                </div>
                                <div class="form-objs">
                                    <div class="form-objl"><input type="tel" class="fadeIn second" id="phonenum" name="phonenum" placeholder="Phone Number"
                                            required></div>
                                    <div class="form-objr"><input type="text" class="fadeIn second" id="registration_num" name="registration_num"
                                            placeholder="License No." required></div>
                                </div>
                                <div class="form-objs">
                                <input type="text" class="fadeIn second" id="residentialaddress" name="residentialaddress"
                                            placeholder=" Residential Address" required>
                                    <!--<select id="specialisation" name="specialisation" class="fadeIn second" >
                                        <option value="" disabled selected>Specialisation</option>
                                        <?php
                                        //$stmts = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_st_speciality WHERE SP_STATUS ='1'"));
                                        //while($objs = $stmts->FetchNextObject()){
                                            ?>
                                            <option value="<?php //echo $objs->SP_CODE;?>"<?php //echo (($specialisation == $objs->SP_CODE)?"selected":"");?>>
                                                <?php //echo $objs->SP_NAME; ?>
                                            </option>
                                            <?php
                                        //}
                                        ?>
                                    </select>-->
                                </div>

                        </div>

                    </p>
                </div>
                <div class="modal-footer">
                    <div class="form-objs">
                        <div class="form-objl"><input type="button" class="fadeIn third" id="vitalpost" value="Submit"></div>
                        <div class="form-objr"><input type="button" class="fadeIn third btn-danger" value="Close" onClick="closeMod('vitalsPost')"></div>
                    </div>
                    </form>
                </div>
            </div>
        </p>

    </div>

    <!-- The Modal for Laboratory Registration-->
    <div id="labReg" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onClick="closeMod('labReg')">&times;</span>
                <span class="text">Laboratory / X-ray Registration</span>
            </div>
            <div class="modal-body">
                <p>
                    <div class="modal-wrapper">
                        <?php $engine->msgBox($msg,$status);?>
                        <form class="form-signin" action="#" method="post" enctype="application/x-www-form-urlencoded" name="labforms" id="labforms"
                            autocomplete="off">
                            <div class="form-objs">
                                <select name="fac_type" class="fadeIn second" id="fac_type" placeholder="Laboratory Name">
                                    <option value="" disabled selected>Select Facility Type</option>
                                    <option value="1">Laboratory</option>
                                    <option value="2">X-ray</option>
                                </select>
                                <input type="text" name="labname" class="fadeIn second" id="labname" placeholder="Laboratory Name">
                                <input type="text" name="loca" class="fadeIn second" id="location" placeholder="Location">
                                <input type="text" name="email" class="fadeIn second" id="email" placeholder="E-mail">
                            </div>
                            <div class="form-objs">
                                <div class="form-objl"><input type="text" name="phonenum" class="fadeIn second" id="phonenum" placeholder="Phone Number"></div>
                                <div class="form-objr"><input type="text" name="regnum" class="fadeIn second" id="registration_num" placeholder="Registration Number"></div>
                            </div>

                    </div>

                </p>
            </div>
            <div class="modal-footer">
                <div class="form-objs">
                    <div class="form-objl"><input type="reset" class="fadeIn third" id="labs" value="Submit"></div>
                    <div class="form-objr"><input type="button" class="fadeIn third btn-danger" value="Close" onClick="closeMod('labReg')"></div>

                </div>
                </form>
            </div>
        </div>

    </div>

    <!-- The Modal for Pharmacy Registration-->
    <div id="pharmReg" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onClick="closeMod('pharmReg')">&times;</span>
                <span class="text">Pharmacy Registration</span>
            </div>
            <div class="modal-body">
                <p>
                    <div class="modal-wrapper">
                        <form class="form-signin" action="#" method="post" enctype="application/x-www-form-urlencoded" name="pharmForm" id="pharmForm"
                            autocomplete="off">
                            <div class="form-objs">
                                <input type="text" class="fadeIn second" name="pharmname" id="pharmname" placeholder="Pharmacy Name">
                                <input type="text" class="fadeIn second" name="location" id="location" placeholder="Location">
                                <input type="text" class="fadeIn second" name="email" id="email" placeholder="E-mail">
                            </div>
                            <div class="form-objs">
                                <div class="form-objl"><input type="text" class="fadeIn second" name="phonenum" id="phonenum" placeholder="Phone Number"></div>
                                <div class="form-objr"><input type="text" class="fadeIn second" name="registration_num" id="registration_num" placeholder="Registration Number"></div>
                            </div>

                    </div>

                </p>
            </div>
            <div class="modal-footer">
                <div class="form-objs">
                    <div class="form-objl"><input type="submit" class="fadeIn third" id="pharm" value="Submit"></div>
                    <div class="form-objr"><input type="button" class="fadeIn third btn-danger" value="Close" onClick="closeMod('pharmReg')"></div>
                </div>
                </form>
            </div>
        </div>

    </div>


    <!-- The Modal for Hospital Registration-->
    <div id="hospitalReg" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onClick="closeMod('hospitalReg')">&times;</span>
                <span class="text">Hospital Registration</span>
            </div>
            <div class="modal-body">
                <p>
                    <div class="modal-wrapper">
                        <form class="form-signin" method="post" action="#" data-toggle="validator" role="form" enctype="multipart/form-data" id="hospitalform">
                            <div class="form-objs">
                                <input type="text" class="fadeIn second" id="hosptname" name="hosptname" placeholder="Hospital Name">
                                <input type="text" class="fadeIn second" id="hosptlocation" name="hosptlocation" placeholder="Location">
                                <input type="text" class="fadeIn second" id="hosptemail" name="hosptemail" placeholder="E-mail">
                            </div>
                            <div class="form-objs">
                                <div class="form-objl"><input type="text" class="fadeIn second" name="hosptphonenum" id="hosptphonenum" placeholder="Phone Number"></div>
                                <div class="form-objr"><input type="text" class="fadeIn second" name="hosptregistration_num" id="hosptregistration_num"
                                        placeholder="Registration Number"></div>
                            </div>

                    </div>

                </p>
            </div>
            <div class="modal-footer">
                <div class="form-objs">
                    <div class="form-objl"><input type="button" class="fadeIn third" id="save-hospital" value="Submit"></div>
                    <div class="form-objr"><input type="button" class="fadeIn third btn-danger" value="Close" onClick="closeMod('hospitalReg')"></div>
                </div>
                </form>
            </div>
        </div>

    </div>

    <!-- The Modal for Courier Registration-->
    <div id="courierReg" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onClick="closeMod('courierReg')">&times;</span>
                <span class="text">Courier Registration</span>
            </div>
            <div class="modal-body">
                <p>
                    <div class="modal-wrapper">
                        <form class="form-signin" method="post" action="#" data-toggle="validator" role="form" enctype="multipart/form-data" id="courierform">
                            <div class="form-objs">
                                <input type="text" class="fadeIn second" id="compname" name="compname" placeholder="Company Name">
                                <input type="text" class="fadeIn second" id="email" name="email" placeholder="E-mail">
                                <input type="text" class="fadeIn second" id="location" name="location" placeholder="Location">
                                <input type="text" class="fadeIn second" id="contact" name="contact" placeholder="Contact Number">

                            </div>
                            <div class="form-objs">
                                <div class="form-objl"><input type="text" class="fadeIn second" id="business_reg" name="business_reg" placeholder="Business Reg. No."></div>
                                <div class="form-objr"><input type="text" class="fadeIn second" id="tax_number" name="tax_number" placeholder="Tax Number(TIN)"></div>
                            </div>

                    </div>

                </p>
            </div>
            <div class="modal-footer">
                <div class="form-objs">
                    <div class="form-objl"><input type="button" class="fadeIn third" id="save-courier" value="Submit"></div>
                    <div class="form-objr"><input type="button" class="fadeIn third btn-danger" value="Close" onClick="closeMod('courierReg')"></div>
                </div>
                </form>
            </div>
        </div>

    </div>
</div>


    <script>

        $(document).ready(function(){
            resizeLogin();
        });
        function resizeLogin(){
            var width = window.outerWidth;
            if(width < 640){
                $('#formContent').addClass('zoom-page');
                //alert('yes--'+width);
                }else{
                $('#formContent').removeClass('zoom-page');
                //alert('no--'+width);
            }
        }

        $('.reload').on('click', function () {
            var rightnow = new Date();
            document.images.turingimg.src = 'plugins/turing/turing.php?' + rightnow.getTime();
            return false;
        });

        function closeMod(modal = string) {
            var modal = document.getElementById(modal);
            modal.style.display = "none";
        };

        function mod(modal = string) {
            var modal = document.getElementById(modal);
            var span = document.getElementsByClassName("close");
            modal.style.display = "block";


            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    </script>
    <?php 
	include 'model/js.php'; 
	include 'model/pharmjs.php';
	?>

</body>

</html>