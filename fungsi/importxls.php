<?php
    require("fungsi/autoload.php");
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Reader\Csv;
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    use PhpOffice\PhpSpreadsheet\Reader\Xls;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    class importxls {
        function upload($dir){
           
            $target_dir = "file/fingerprint/".basename($_FILES[$dir]['name']);
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            move_uploaded_file($_FILES[$dir]['tmp_name'], $target_dir);
            $spreadsheet = $reader->load($target_dir);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            return $sheetData;
        } 
    }
    
?>