<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    function WordWrap($w, $h, $x, $t)
    {
       $height = $h/3;
       $first = $height+0.1;
       $second = $height+$height+0.8;
       $len = strlen($t);
       if($len>22){
           $txt = str_split($t, 22);
           $this->setX($x);
           $this->Cell($w, $first, $txt[0], 0, 0,'L');
           $this->setX($x);
           $this->Cell($w, $second, $txt[1], 0 , '','L');
           $this->setX($x);
           $this->Cell($w, $h, '', 0, 0,'L', 0);
       }else{
           $this->SetX($x);
           $this->Cell($w, $h, $t, 0, 0,'L', 0);
       }
    }
}
?>