<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 12/7/2017
 * Time: 11:50 AM
 */

include '../../../../config.php';
include '../../../../plugins/fpdf/fpdf.php';
include '../model/pdfReportClass.php';
include '../model/reportquery.php';

$pdf = new pdfReport();

$pdf->formtype=$formtype;
$pdf->formname=$formname;
$pdf->from=$month_array[$datefrom];
$pdf->to= $dateto;
$pdf->AliasNbPages();
$pdf->AddPage();
ob_end_clean();
$pdf->eventlogg($result);