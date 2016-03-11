<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel {
 
    private $excel;
 
    public function __construct() {
        // initialise the reference to the codeigniter instance
        require_once APPPATH.'third_party/PHPExcel.php';
        $this->excel = new PHPExcel();   
    }
 
    public function load($path) {
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $this->excel = $objReader->load($path);
    }
 
    public function save($path) {
        // Write out as the new file
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save($path);
    }
 
    public function create_excel($filename, $data=null) {
        if($data!=null){
            $col = 'A';
            foreach ($data[0] as $key => $val) {
                $objRichText = new PHPExcel_RichText();
                $objPayable = $objRichText->createTextRun(str_replace("_", " ", $key));
                $objPayable->getFont()->setBold(true);
                $objPayable->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKRED));
                $this->excel->getActiveSheet()->getCell($col . '1')->setValue($objRichText);
                //$objPHPExcel->getActiveSheet()->setCellValue($col.'1' , str_replace("_"," ",$key));
                $col++;
            }
            $rowNumber =2; //start in cell 1
            foreach ($data as $row) {
                $col = 'A'; // start at column A
                foreach ($row as $cell) {
                    $this->excel->getActiveSheet()->setCellValue($col . $rowNumber, $cell);
                    $col++;
                }
                $rowNumber++;
            }
        }

		$realfilepath = realpath(APPPATH . '../upload/files/');
		$filepath = '/upload/files/';
		
        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"".$filename."\"");
        header("Cache-control: private");       
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	//  $objWriter->save('php://output'); 
        $objWriter->save("$realfilepath" . "/" . "$filename");
        header("location: ".base_url()."$filepath" . "$filename");
		$path = $realfilepath . "/" . $filename;
        //unlink("$realfilepath" . "/" . "$filename");
    }
     
    public function  __call($name, $arguments) { 
        // make sure our child object has this method 
        if(method_exists($this->excel, $name)) { 
            // forward the call to our child object 
            return call_user_func_array(array($this->excel, $name), $arguments); 
        } 
        return null; 
    } 
	
	public function read_excel($filename) {
		$realfilepath = realpath(APPPATH . '../upload/files/');
		$objPHPExcel = PHPExcel_IOFactory::load($realfilepath . "/". $filename);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
		    $worksheetTitle     = $worksheet->getTitle();
		    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
		    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		    $nrColumns = ord($highestColumn) - 64;
		   // echo "<br>The worksheet ".$worksheetTitle." has ";
		   // echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
		    //echo ' and ' . $highestRow . ' row.';
		    $arr = array();
			$n = 0;
		   // echo '<br>Data: <table border="1"><tr>';
		    for ($row = 2; $row <= $highestRow; ++ $row) {
		        echo '<tr>';
		        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
		            $cell = $worksheet->getCellByColumnAndRow($col, $row);
		            $val = $cell->getValue();
		            //$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
		            if($col == 0 && $val == '')
		            	continue;
		          //  echo '<td>' . $val . '</td>';
					$arr[$n][$col] = $val;
		        }
		      //  echo '</tr>';
				$n++;
		    }
		   // echo '</table>';
		}
		return $arr;
	}


	function download_merit_to_excel($array, $filename) {
	    header('Content-Disposition: attachment; filename='.$filename.'.xls');
	    header('Content-type: application/force-download');
	    header('Content-Transfer-Encoding: binary');
	    header('Pragma: public');
	    print "\xEF\xBB\xBF"; // UTF-8 BOM
	    $h = array();
		
		print_r($array['header']);
		
		echo '<table><tr>';
		for($i=0; $i<count($array['header']); $i++){
			 echo '<th>'.$array['header'][$i].'</th>';
		}
		echo '</tr>';
	
	    foreach($array['result'] as $row){
	        echo '<tr>';
	        foreach($row as $val)
	            $this->writeRow($val);   
	    }
	    echo '</tr>';
	    echo '</table>';
	}
	
	function writeRow($val) {
	    echo '<td>'.$val.'</td>';              
	}

	    
}
?>