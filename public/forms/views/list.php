<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Form
                    <span class="pull-right">
                        <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:18px; padding-top:-10px;">
                            <i class="fa fa-clone"></i>
                        </button>
                        <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:25px; padding-top:-10px;">&times;</button>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">First Name</label>
                    <input type="text" class="form-control" id="fname" name="fname">
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Other Names</label>
                    <input type="text" class="form-control" id="othername" name="othername">
                </div>
                <div class="col-sm-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4">
                    <label for="phonenumber">Phone Number</label>
                    <input type="number" class="form-control" id="phonenumber" name="phonenumber">
                </div>
                <div class="col-sm-4 required uniq-user">
                    <label for="username">User Name</label>
                    <div class="uniq-left">
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="uniq-right">
                        <input type="text" class="form-control" id="alias" name="alias">
                    </div>
                </div>
                <div class="col-sm-4 required">
                    <label for="pwd">Password</label>
                    <input type="password" class="form-control" id="pwd" name="pwd">
                </div>
            </div>

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-default">Submit</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="submit" class="btn btn-danger">Submit</button>
                    <button type="submit" class="btn btn-dark">Submit</button>
                </div>
            </div>

        </div>
    </div>

    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Medical History
                    <span class="pull-right">
                        <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:25px; padding-top:-10px;">&times;</button>
                    </span>
                </div>
            </div>

            <div class="col-sm-12 paddingclose personalinfo">
                <div class="col-sm-2">
                    <div class="id-photo">
                        <img src="<?php echo(($photourl))?$photourl:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                    </div>
                </div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Personal Information </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td>
                                        <b>Name:</b> Kofi Doe</td>
                                    <td>
                                        <b>Date of Birth:</b> 12-12-2000</td>
                                    <td>
                                        <b>Email:</b> kofi@doe.com</td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Phone Number:</b> 0201234567</td>
                                    <td>
                                        <b>Postal Address:</b> P.O.Box LT 234 Late Toronto Accra</td>
                                    <td>
                                        <b>Residential Address:</b> 4th Florence Street,HNo.233 Late Toronto Accra</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 alegyinfo">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Allergies </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td>
                                        <b>1:</b> Dust</td>
                                    <td>
                                        <b>2:</b> Pollen</td>
                                    <td>
                                        <b>3:</b> Sulpha Based Drugs</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-12 chronicinfo">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Chronic Conditions </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td>
                                        <b>1:</b> Asthma</td>
                                    <td>
                                        <b>2:</b> Diabetes</td>
                                    <td>
                                        <b>3:</b> Chronic Headaches</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-12 conshistoryinfo">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Consultation History </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Other Name</th>
                                        <th>E-mail</th>
                                        <th>Phone Number</th>
                                        <th>User Name</th>
                                        <th>Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Kofi</td>
                                        <td>Doe</td>
                                        <td>kofi@doe.com</td>
                                        <td>0302123456</td>
                                        <td>koffi@User</td>
                                        <td>1234567</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Ama</td>
                                        <td>Doe</td>
                                        <td>ama@doe.com</td>
                                        <td>0302123456</td>
                                        <td>ama@User</td>
                                        <td>1234567</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Yaw</td>
                                        <td>Doe</td>
                                        <td>yaw@doe.com</td>
                                        <td>0302123456</td>
                                        <td>yaw@User</td>
                                        <td>1234567</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Tables</div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Other Name</th>
                        <th>E-mail</th>
                        <th>Phone Number</th>
                        <th>User Name</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Kofi</td>
                        <td>Doe</td>
                        <td>kofi@doe.com</td>
                        <td>0302123456</td>
                        <td>koffi@User</td>
                        <td>1234567</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Ama</td>
                        <td>Doe</td>
                        <td>ama@doe.com</td>
                        <td>0302123456</td>
                        <td>ama@User</td>
                        <td>1234567</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Yaw</td>
                        <td>Doe</td>
                        <td>yaw@doe.com</td>
                        <td>0302123456</td>
                        <td>yaw@User</td>
                        <td>1234567</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Tables With Options</div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Other Name</th>
                        <th>E-mail</th>
                        <th>Phone Number</th>
                        <th>User Name</th>
                        <th>Password</th>
                        <th width="170">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Kofi</td>
                        <td>Doe</td>
                        <td>kofi@doe.com</td>
                        <td>0302123456</td>
                        <td>koffi@User</td>
                        <td>1234567</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <button>Edit User</button>
                                    </li>
                                    <li>
                                        <button>Reset Password</button>
                                    </li>
                                    <li>
                                        <button>Delete User</button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Ama</td>
                        <td>Doe</td>
                        <td>ama@doe.com</td>
                        <td>0302123456</td>
                        <td>ama@User</td>
                        <td>1234567</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <button>Edit User</button>
                                    </li>
                                    <li>
                                        <button>Reset Password</button>
                                    </li>
                                    <li>
                                        <button>Delete User</button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Yaw</td>
                        <td>Doe</td>
                        <td>yaw@doe.com</td>
                        <td>0302123456</td>
                        <td>yaw@User</td>
                        <td>1234567</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <button>Edit User</button>
                                    </li>
                                    <li>
                                        <button>Reset Password</button>
                                    </li>
                                    <li>
                                        <button>Delete User</button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Cards</div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="col-sm-2">
                        <div class="card">
                            <img src="media/img/tip.png" alt="Avatar" style="width:100% !important; margin:0px !important;">
                            <div class="container">
                                <h4>
                                    <b>John Doe</b>
                                </h4>
                                <p>Ambulance Service</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="card">
                            <img src="media/img/tip.png" alt="Avatar" style="width:100% !important; margin:0px !important;">
                            <div class="container">
                                <h4>
                                    <b>John Doe</b>
                                </h4>
                                <p>Ambulance Service</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#personal">Personal Information</a>
            </li>
            <li>
                <a data-toggle="tab" href="#menu1">Menu 1</a>
            </li>
            <li>
                <a data-toggle="tab" href="#menu2">Menu 2</a>
            </li>
        </ul>
        <div class="page form">
            <div class="tab-content">
                <div id="personal" class="tab-pane fade in active">
                    <h3>Personal Information</h3>
                    <p>
                        Some content.
                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success">Modal</button>
                    </p>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Some content in menu 1.</p>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Some content in menu 2.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Nested Checkboxs
                    <span class="pull-right">
                        <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:25px; padding-top:-10px;">&times;</button>
                    </span>
                </div>
            </div>
            <div class="gyn-treeview">
                <ul>
                    <li>
                        <input type="checkbox" id="node-0" checked="checked" />
                        <label>
                            <input type="checkbox" />
                            <span></span>
                        </label>
                        <label for="node-0">Libraries</label>
                        <ul>
                            <li>
                                <input type="checkbox" id="node-0-0" checked="checked" />
                                <label>
                                    <input type="checkbox" />
                                    <span></span>
                                </label>
                                <label for="node-0-0">Documents</label>
                                <ul>
                                    <li>
                                        <input type="checkbox" id="node-0-0-0" checked="checked" />
                                        <label>
                                            <input type="checkbox" />
                                            <span></span>
                                        </label>
                                        <label for="node-0-0-0">My Documents</label>
                                        <ul>
                                            <li>
                                                <input type="checkbox" id="node-0-0-0-0" />
                                                <label>
                                                    <input type="checkbox" />
                                                    <span></span>
                                                </label>
                                                <label for="node-0-0-0-0">Downloads</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="node-0-0-0-1" />
                                                <label>
                                                    <input type="checkbox" />
                                                    <span></span>
                                                </label>
                                                <label for="node-0-0-0-1">Projects</label>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <input type="checkbox" id="node-0-1" />
                                <label>
                                    <input type="checkbox" />
                                    <span></span>
                                </label>
                                <label for="node-0-1">Music</label>
                                <ul>
                                    <li>
                                        <input type="checkbox" id="node-0-1-0" />
                                        <label>
                                            <input type="checkbox" />
                                            <span></span>
                                        </label>
                                        <label for="node-0-1-0">My Music</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="node-0-1-1" />
                                        <label>
                                            <input type="checkbox" />
                                            <span></span>
                                        </label>
                                        <label for="node-0-1-1">Public Music</label>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <input type="checkbox" id="node-0-2" />
                                <label>
                                    <input type="checkbox" />
                                    <span></span>
                                </label>
                                <label for="node-0-2">Pictures</label>
                                <ul>
                                    <li>
                                        <input type="checkbox" id="node-0-2-0" />
                                        <label>
                                            <input type="checkbox" />
                                            <span></span>
                                        </label>
                                        <label for="node-0-2-0">My Pictures</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="node-0-2-1" />
                                        <label>
                                            <input type="checkbox" />
                                            <span></span>
                                        </label>
                                        <label for="node-0-2-1">Public Pictures</label>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <input type="checkbox" id="node-0-3" checked="checked" />
                                <label>
                                    <input type="checkbox" checked="checked" />
                                    <span></span>
                                </label>
                                <label for="node-0-3">Video</label>
                                <ul>
                                    <li>
                                        <input type="checkbox" id="node-0-3-0" />
                                        <label>
                                            <input type="checkbox" checked="checked" />
                                            <span></span>
                                        </label>
                                        <label for="node-0-3-0">My Videos</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="node-0-3-1" />
                                        <label>
                                            <input type="checkbox" checked="checked" />
                                            <span></span>
                                        </label>
                                        <label for="node-0-3-1">Public Videos</label>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <p> </p>
        </div>
    </div>

</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>
                    <div class="tabs">
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn">
                                <img src="media/img/doctor.svg" />
                                <br>
                                <label>Doctors</label>
                            </button>
                        </div>
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn">
                                <img src="media/img/lab.svg" />
                                <br>
                                <label>Laboratory</label>
                            </button>
                        </div>
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn">
                                <img src="media/img/pharmacy.svg" />
                                <br>
                                <label>Pharmacy</label>
                            </button>
                        </div>
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn">
                                <img src="media/img/hospital.svg" />
                                <br>
                                <label>Hospital</label>
                            </button>
                        </div>
                        <div class="col-sm-6 tabs-col">
                            <button class="tabs-btn">
                                <img src="media/img/courier.svg" />
                                <br>
                                <label>Courier</label>
                            </button>
                        </div>
                    </div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-square" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script>
    /* Script to auto select sub tree checkboxes */
    $(".gyn-treeview").delegate("label input:checkbox", "change", function () {    
        var checkbox = $(this),
            nestedList = checkbox.parent().next().next(),
            selectNestedListCheckbox = nestedList.find("label:not([for]) input:checkbox");     
        if (checkbox.is(":checked")) {        
            return selectNestedListCheckbox.prop("checked", true);    
        }    
        selectNestedListCheckbox.prop("checked", false);
    });
</script>

<?php
    $report_comp_logo = "media/img/report-logo.png";
    $report_comp_name = "Hewale Hospital";
    $report_title = "Medical Record";
    $report_comp_location = "P.O.Box AC 123 Achomota Accra.";
    $report_phone_number = "0302 000 123";
    $report_content = '';
?>

<div class="main-content">
    <div class="page-wrapper page form">
        <div class="moduletitle">
            <div class="moduletitleupper">Report
                <span class="pull-right">
                    <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:18px; padding-top:-10px;" title="Generate Excel">
                        <i class="fa fa-file-excel-o"></i>
                    </button>
                    <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:18px; padding-top:-10px;" title="Generate PDF">
                        <i class="fa fa-file-pdf-o"></i>
                    </button>
                    <button type="button" class="form-tools print-block" onclick="printDiv('printReport')" style="font-size:18px; padding-top:-10px;" title="Print Document">
                        <i class="fa fa-print"></i>
                    </button>
                    <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:25px; padding-top:-10px; line-height:1.3em" title="Close">&times;</button>
                </span>
            </div>
        </div>
        <div class="page-report" id="printReport">
            <table>
                <tr class="report-title">
                    <td width="15%">
                        <img src="<?php echo $report_comp_logo; ?>"/>
                        <h5><?php echo $report_comp_name; ?></h5>
                    </td>
                    <td width="60%"><h4><?php echo $report_title; ?></h4></td>
                    <td class="address" width="30%">
                        <span><b>Location:</b> <?php echo $report_comp_location; ?></span><br><br>
                        <span><b>Phone Number:</b> <?php echo $report_phone_number; ?></span><br><br>
                    </td>
                </tr>
                <tr>
                    <td class="report-content">
                        <?php echo $report_content; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script>
   function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>