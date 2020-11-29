<?php
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : "";
if ($id_user != ""){  //Kondisi awal untuk hak akses
	require "fungsi/fpdf/fpdf.php";
	include "fungsi/date_indo.php";

    $idpr = isset($_GET['idpr']) ? $_GET['idpr'] : "";
    $ids = isset($_GET['ids']) ? $_GET['ids'] : "";
    
    $sql = "SELECT pr.*, r.rolename, u.name, s.name as supplier
    FROM tb_purchase_requition pr 
    JOIN tb_detail_pr_item dpr ON pr.id_purchase_requition = pr.id_purchase_requition
    JOIN tb_suppliers s ON s.id_supplier = dpr.id_supplier
    JOIN tb_users u ON u.id_user = pr.created_by
    JOIN tb_roles r ON r.id_role = u.id_role
    WHERE pr.id_purchase_requition = :idpr";
    $supplierQuery = "";
    if($ids != ""){
        $supplierQuery = " and s.id_supplier=:id_supplier";
    }
    $query=$dbcon->prepare($sql.$supplierQuery);
    $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
    if($ids != ""){
        $query->bindParam("id_supplier", $ids, PDO::PARAM_STR);
    }
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $name = $result['name'];
    $supplier = $result['supplier'];
    class PDF extends FPDF
    {
        var $type;
        var $widths;
        var $aligns;
        function SetWidths($w)
        {
            //Set the array of column widths
            $this->widths=$w;
        }
        function SetType($t){
            $this->type=$t;
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
            $h=6*$nb;
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            for($i=0;$i<count($data);$i++)
            {
                $w=$this->widths[$i];
                $type = $this->type;
                if($type == "h"){
                    $Lspacing = strlen($data[$i]) > 11 && ($w >= 10 && $w <= 30) ? 6 : 12;
                }else{
                    $Lspacing = 6;
                }
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                //Save the current position
                $x=$this->GetX();
                $y=$this->GetY();
                //Draw the border
                $this->Rect($x,$y,$w,$h);
                //Print the text
                $this->MultiCell($w,$Lspacing,$data[$i],0,$a);
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
    }
    $breaks = array("<br />","<br>","<br/>"); 

    $pdf=new PDF("P");
	$pdf->AliasNbPages();
	$pdf->AddPage();
	

	//LOGO
	$pdf->Image('images/logo_cc.jpg',18,10,28,28);
	
	//Set Font
	$pdf->SetFont('Times','B',15);
	$pdf->SetMargins(3.18,2.54);
	//Move to Right
	$pdf->Cell(126);
	$pdf->Cell(20,15,'COFFEE AND COUPLE');
	$pdf->SetFont('Times','',10);
	$pdf->Ln();
	$pdf->Cell(118);
	$pdf->Cell(10,-5,'Jl. AsemBaris Raya No A11 Tebet Jakarta Selatan');
	$pdf->Ln();
	$pdf->Cell(112);
	$pdf->Cell(10,15,' Telp. (021) 8299280, 708806588, Fax (021) 83794263');
	$pdf->Ln();
	$pdf->Cell(98);
	$pdf->Cell(10,-5,'Email:coffeeandcouple@gmail.com, www.coffeeandcouple.com');
    $pdf->Line(17,40,194,40);
    $pdf->Line(17,41,194,41);
    $pdf->Ln();
	$pdf->SetFont('Times','BU',12);
	$pdf->Cell(210,30,'FORM PO SUPPLIER', 0, 0, 'C');
    $pdf->SetFont('Times','',11);
    $pdf->Ln();
	$pdf->Cell(15);
    $pdf->Cell(20,-10,'Suplier');
	$pdf->Cell(20);
    $pdf->Cell(15,-10,':  '.$supplier);

    $pdf->Cell(55);
    $pdf->Cell(25,-10,'Kode PO');
    $pdf->SetFont('Times','B',10);
    $pdf->Cell(15,-10,':  '.$result['id_purchase_requition']);
    $pdf->Ln();
    $pdf->Cell(15);
    $pdf->SetFont('Times','',10);
    $pdf->Cell(20, 18,'Tanggal Pengajuan');
	$pdf->Cell(20);
    $pdf->Cell(10, 18,':  '.date_indo($result['trx_date']));
    
    $sql = "SELECT g.name as goods, dpr.quantity, g.quantity_unit,  u.name as unit,
        CASE WHEN g.fixed_price > 0 THEN g.fixed_price
        ELSE g.price_estimate END price,
        CAST((dpr.quantity/g.quantity_unit)*(CASE WHEN g.fixed_price > 0 THEN g.fixed_price
        ELSE g.price_estimate END) AS INT) as total
        FROM tb_detail_pr_item dpr
        JOIN tb_goods g ON g.id_goods = dpr.id_goods
        JOIN tb_suppliers s ON s.id_supplier = dpr.id_supplier
        JOIN tb_unit u ON u.id_unit = g.id_unit
        WHERE dpr.id_purchase_requition=:idpr";
    $query=$dbcon->prepare($sql.$supplierQuery);
    $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
    if($ids != ""){
        $query->bindParam("id_supplier", $ids, PDO::PARAM_STR);
    }
    $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
    $query->execute();
    $data = array();
    #buat header tabel
    $pdf->Ln();
    $pdf->SetFont('Times','B',10);
    $pdf->Cell(15);
    $pdf->SetWidths(array(10, 38, 34, 28, 30, 35));
    $pdf->SetType('h');
    $pdf->setAligns(array('C', 'C', 'C', 'C', 'C', 'C'));
    $pdf->Row(array('NO', 'NAMA BARANG', 'KETERANGAN', 'JUMLAH', 'HARGA SATUAN', 'TOTAL'));
    
    // foreach ($header as $kolom) {
    //     $pdf->Cell($kolom['length'], 10, $kolom['label'], 1, '0', $kolom['align'], false);
    // }
    #tampilkan data tabelnya
    $i = 0;
    $pdf->SetFont('Times','',11);
    $pdf->SetType('r');
    $subtotal = 0;
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $i++;
        $data = array();
        $data[] = $i;
        $data[] = $row['goods'];
        $data[] = "";
        $data[] = $row['quantity'].' '. $row['unit'];
        $data[] = "";
        $data[] = "";
        $pdf->Cell(15);
        $pdf->SetWidths(array(10, 38, 34, 28, 30, 35));
        $pdf->setAligns(array('C', 'C', 'C', 'C', 'C', 'C'));
        $pdf->Row($data);
    }
    $pdf->SetWidths(array(140, 35));
    $pdf->SetType('r');
    $pdf->setAligns(array('C', 'L'));
    $pdf->Cell(15);
    $pdf->SetFont('Times','B',11);
    $pdf->Row(array('Total', "Rp " ));
    $pdf->Cell(15);
    $pdf->Ln();
    $pdf->Cell(15);
    $pdf->SetFont('Times','',11);
    $pdf->Ln();
    $pdf->Cell(22);
    $pdf->Cell(137, 15, 'Pemohon,');
    $pdf->Cell(38, 15, 'Mengetahui,');
    $pdf->Ln(25);
    $pdf->Cell(18);
    $pdf->Cell(135, 5, $name);
    $pdf->Cell(40, 5, '(..............................)');
    $filename = 'SP-'.$idpr.'-'.$supplier.'.pdf';
	$pdf->Output($filename, 'I');
}
else{
	echo"</br>";
	echo"</br>";
	echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>";  
}
?>
