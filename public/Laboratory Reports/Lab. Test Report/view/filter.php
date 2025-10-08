<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/27/2017
 * Time: 4:35 PM
 */
?>

<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Filter - Laboratory Test Report
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
                    <label class="control-label" for="fname">Filter by:</label>
                    <select name="filterby" id="filterby" class="form-control" readonly="">
                        <option value="">date range</option>
                    </select>
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">From:</label>
                    <input type="date" class="form-control" id="datefrom" name="datefrom">
                </div>
                <div class="col-sm-4 required">
                    <label for="email">To:</label>
                    <input type="date" class="form-control" id="dateto" name="dateto">
                </div>
            </div>

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" id="report" onclick="document.getElementById('view').value='report';document.getElementById('viewpage').value='report';document.myform.submit();">Submit</button>
                    <button type="submit" class="btn btn-danger">Cancel</button>
                </div>
            </div>

        </div>
    </div>
</div>