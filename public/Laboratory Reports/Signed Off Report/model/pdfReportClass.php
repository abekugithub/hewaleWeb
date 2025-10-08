<?php
/**
 * Description of pdfReportClass
 *
 * @author orcons systems
 */
class pdfReport extends FPDF{

	/**public $monthyear;
	public $unitname;**/

	public $from;
	public $to;
	public $formtype;
	public $formname;

    function  __construct() {
        parent::__construct();

    }

     //multicell code
    function SetWidths($w)
    {
    	//Set the array of column widths
    	$this->widths=$w;
    }

    function SetAligns($a)
    {
    	//Set the array of column alignments
    	$this->aligns=$a;
    }

    function Row($data)
    {
    	//Calculate the height of the row
    	$nb=0;
    	for($i=0;$i<count($data);$i++)
    		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    	$h=5*$nb;
    	//Issue a page break first if needed
    	$this->CheckPageBreak($h);
    	//Draw the cells of the row
    	for($i=0;$i<count($data);$i++)
    	{
    		$w=$this->widths[$i];
    		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
    		//Save the current position
    		$x=$this->GetX();
    		$y=$this->GetY();
    		//Draw the border
    		$this->Rect($x,$y,$w,$h);
    		//Print the text
    		$this->MultiCell($w,5,$data[$i],0,$a);
    		//Put the position to the right of the cell
    		$this->SetXY($x+$w,$y);
    	}
    	//Go to the next line
    	$this->Ln($h);
    }

    function CheckPageBreak($h)
    {
    	//If the height h would cause an overflow, add a new page immediately
    	if($this->GetY()+$h>$this->PageBreakTrigger)
    		$this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
    	//Computes the number of lines a MultiCell of width w will take
    	$cw=&$this->CurrentFont['cw'];
    	if($w==0)
    		$w=$this->w-$this->rMargin-$this->x;
    	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    	$s=str_replace("\r",'',$txt);
    	$nb=strlen($s);
    	if($nb>0 and $s[$nb-1]=="\n")
    		$nb--;
    	$sep=-1;
    	$i=0;
    	$j=0;
    	$l=0;
    	$nl=1;
    	while($i<$nb)
    	{
    		$c=$s[$i];
    		if($c=="\n")
    		{
    			$i++;
    			$sep=-1;
    			$j=$i;
    			$l=0;
    			$nl++;
    			continue;
    		}
    		if($c==' ')
    			$sep=$i;
    		$l+=$cw[$c];
    		if($l>$wmax)
    		{
    			if($sep==-1)
    			{
    				if($i==$j)
    					$i++;
    			}
    			else
    				$i=$sep+1;
    			$sep=-1;
    			$j=$i;
    			$l=0;
    			$nl++;
    		}
    		else
    			$i++;
    	}
    	return $nl;
    }
    //multicell end
  public function  Header(){

	$this->SetFont('Times','B',10);
    $this->Cell(190,7,"GOG PENSION MANAGEMENT SYSTEM",0,1,'C');
//	 $formtype;
	$this->Cell(190,10,$this->formname." Approved Report",0,1,'C');
	$this->Line(80,24,129,24);
	$this->Ln(3);
	$this->SetFont('Times','',8);

      $this->SetX(30);
      $this->Cell(20,3,"Previewed @ ".date("M d, Y"),20,10,'L');
      $this->SetX(30);
      $this->Cell(210,3,"Month: ".$this->from,0,1,'L');
      $this->SetX(30);
      $this->Cell(210,3,"Year: ".$this->to,0,1,'L');
	/*$this->Cell(210,3,"MGT. UNIT: ".$this->unitname,0,1,'L');*/

	$this->Ln(6);
	//Table header
//	$this->cell(20);
    $this->SetX(30);
	$this->SetFont('Times','B',6);
	$this->SetWidths(array(10,20,30,20,20,18));
	$this->Row(array('No.','PATIENT NAME','HEWALE NUMBER','LAB. TEST','DISCIPLINE','DATE'));

}

public function Footer(){
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

}//end Footer

  //Investment Statement
function eventlogg($result)
	{
      $i = 1;
      //Start loop

	$this->SetFont('Times','',6);
	$this->SetWidths(array(10,20,30,20,20,18,18,20));
	//$totalprincipal = $totalint = $totalfacevalue = 0;
	// date('d/m/Y',strtotime($index[6]))
	foreach($result as $index){
		$this->SetX(30);
	$this->Row(array($i++,$index['patientname'],$index['patientcode'],$index['testname'],$index['labdiscpline'],date('d/m/Y',strtotime($index['labrequestdate']))));

      }
//End Core Data

$this->Output("Approved_report.pdf","D");
	}

}
?>