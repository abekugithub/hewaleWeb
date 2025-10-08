<!DOCTYPE html>
<html lang="en">

<head>
  <title>Hewale Social Health</title>
  <meta http-equiv="content-type" content="text/html" charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="media/css/main.css" rel="stylesheet">
  <link href="media/css/animation.css" rel="stylesheet">
  <link rel="icon" href="media/img/favicon.png" type="image/png" sizes="16x16">
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
  <script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
      appId: "7552392c-4d7d-4e4d-a672-56509c316478",
      autoRegister: true,
      notifyButton: {
        enable: false /* Set to false to hide */
      },
      allowLocalhostAsSecureOrigin: true

    }]);
    OneSignal.push(function() {
      OneSignal.getUserId(function(userId) {
        console.log("OneSignal User ID:", userId);

        //Update browser player id
        var patientcode = $('#patientcode').val();
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: 'public/layout/model/updateplayerid.php',
          data: {
            "userId": userId
          },
          success: function(e) {

          },
        });

      });


    });
  </script>
  <script type="text/javascript" src="media/js/jquery.min.js"></script>
  <script type="text/javascript" src="media/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="media/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="media/js/bootstrap-toggle.min.js"></script>
  <script type="text/javascript" src="media/js/select2.full.js"></script>
  <script type="text/javascript" src="media/js/custom.js"></script>
  <script type="text/javascript" src="media/js/moment.min.js"></script>
  <script type="text/javascript" src="media/js/ez.countimer.js"></script>

  <?php
  if (isset($uiid) && $uiid = md5('1_pop')) {
  } else {
    echo '<script type="text/javascript" src="media/js/sidebar.js"></script>';
  }

  ?>
  <script type="text/javascript" src="media/js/chart.bundle.js"></script>
  <script type="text/javascript" src="media/js/chart.utils.js"></script>
  <script type="text/javascript" src="media/js/sweet-alert.min.js"></script>
  <script type="text/javascript" src="media/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="media/js/bootstrap-clockpicker.min.js"></script>
  <script type="text/javascript" src="plugins/ckeditor/ckeditor.js"></script>

  <!--Starting the sticky note block-->
  <script type="text/javascript" src="media/js/jquery.stickynote.min.js"></script>
  <script type="text/javascript" src="media/js/StickyNotes.js"></script>
  <script src="media/js/amcharts.js" type="text/javascript"></script>
  <script src="media/js/serial.js" type="text/javascript"></script>


  <!--Ending the sticky note block-->
  <script>
    $(document).ready(function() {
      $("#loading").fadeOut("slow");
      if (localStorage.getItem('modal')) {
        $('#modalpop').val(localStorage.getItem('modal'));
      }
      $('input').attr('autocomplete', 'off');

      //Date picker starts here
      var date_input = $('input[name="startdate"]'); //our date input has the name "startdate"
      var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
      date_input.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      })

      var date_input = $('input[name="enddate"]'); //our date input has the name "enddate"
      var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
      date_input.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      })
      //Date picker ends here
      $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true
      });
    });


    setTimeout(function() {
      $('#msg').hide();
    }, 10000);


    function confirmSubmit(message, confirmbtn, callbackftn) {
      swal({
        title: "Warning",
        text: message,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '',
        confirmButtonText: confirmbtn,
        closeOnConfirm: false
      }, callbackftn);
    }
  </script>


  <!--Video and Audio Chat-->
  <script type="text/javascript" src="media/js/prettify.js"></script>
  <script type="text/javascript" src="media/js/loadAndFilter.js"></script>

  <script src="media/js/socket.io/socket.io.js"></script>
  <script type="text/javascript" src="media/js/easyrtc.js"></script>
  <script type="text/javascript" src="media/js/demo_audio_video_simple.js"></script>
  <!--End video and audio chat-->
  <!--instant Chat messaging-->
  <script type="text/javascript" src="media/js/demo_instant_messaging.js"></script>
  <!--End instant Chat messaging-->
  <?php include(SPATH_MEDIA . DS . "scripts.php"); ?>


</head>
<!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script> -->
<script>
  /* var OneSignal =  || [];
    OneSignal.push(["init", {
      appId: "7552392c-4d7d-4e4d-a672-56509c316478",
      autoRegister: true,
      notifyButton: {
        enable: true /* Set to false to hide */
  /*    },
      allowLocalhostAsSecureOrigin: true
    }]);
OneSignal.push(function() {
  OneSignal.getUserId(function(userId) {
    console.log("OneSignal User ID:", userId);
  });  
});  */
</script>

<body>
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