<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'assets/lib/phpExcelClasses_1_8/PHPExcel.php';

class Phpexcel_home extends PHPExcel{
	private $cellCode = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	public function __construct(){
		parent::__construct();
	}
	protected function cleanstring($str){
		$str = strip_tags(preg_replace('/\r|\t|\n|\r\n|\"|\'|\s+/', '', $str));
		return $str;
	}
	public function set_excelfile_connection_db($filepath=''){
		try {
            $this->inputFileType = PHPExcel_IOFactory::identify($filepath);
            $this->objReader = PHPExcel_IOFactory::createReader($this->inputFileType);
            $this->objPHPExcel = $this->objReader->load($filepath);
        } catch (Exception $e) {
            die('Error loading file "'.pathinfo($filepath,PATHINFO_BASENAME).'": '.$e->getMessage());
        }		
		
        $this->sheet = $this->objPHPExcel->getSheet(0);
        $this->maxRow = $this->sheet->getHighestRow();
        $this->maxColumn = $this->sheet->getHighestColumn(); 
        $range_str = "A"."2".":"."$this->maxColumn"."$this->maxRow";
        $this->lines = $this->sheet->rangeToArray($range_str, NULL, TRUE, FALSE);
		$this->indexc = 0;

		$len = 0;
		$row = 0;
		for($column = 'A'; $column != $this->maxColumn; $column++){
			$len++;
		}
		$sql = 'insert into psu_presentation_user (p_id, u_name, u_name_en, u_phone, u_email, u_aca, u_relation, u_field, u_attendance, u_search,  u_register) values ';
		foreach ($this->lines as $key => $line) {	
            $cursor = 0;
			if($row == 0){
				$sql .= '(';
			}else{
				$sql .= ', (';
			}
			for($i=0; $i<=$len; $i++){
				if($i==0){
					$sql .= '"'.$line[$cursor++].'"';
				}else{
					$sql .= ', "'.$line[$cursor++].'"';
				}
			}
			$sql .= ')';
			$row++;
		}
		return $sql;
	}
	public function get_excelfile_dbresult($filepath=''){
		try {
            $this->inputFileType = PHPExcel_IOFactory::identify($filepath);
            $this->objReader = PHPExcel_IOFactory::createReader($this->inputFileType);
            $this->objPHPExcel = $this->objReader->load($filepath);
        } catch (Exception $e) {
            die('Error loading file "'.pathinfo($filepath,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
		$this->sheet = $this->objPHPExcel->getSheet(0);
        $this->maxRow = $this->sheet->getHighestRow();
        $this->maxColumn = $this->sheet->getHighestColumn(); 
        $range_str = "A"."2".":"."$this->maxColumn"."$this->maxRow";
        $this->lines = $this->sheet->rangeToArray($range_str, NULL, TRUE, FALSE);
		$this->indexc = 0;
		$len = 0;
		$row = 0;
		for($column = 'A'; $column != $this->maxColumn; $column++){
			$len++;
		}
		$data = array();
		foreach ($this->lines as $key => $line) {	
            $cursor = 0;
			for($i=0; $i<=$len; $i++){
				$dataValue = $this->cleanstring($line[$cursor++]);
				if($dataValue == '') continue;
				$data[$row][$i] = 	$dataValue;
			}
			$row++;
		}
		return $data;
	}
	public function down_excelfile($title='', $cell_name = array(), $data){
		$cell_count = count($cell_name);
		$cellcode_count = count($this->cellCode);
		
		$this->setActiveSheetIndex(0);
		$this->getActiveSheet()->setTitle($title);
		$ccount = 1;
		
		for($i=0; $i<$cell_count; $i++){
			if($cellcode_count > $i){
				$code = $this->cellCode[$i].'1';
				$this->getActiveSheet()->setCellValue($code, $cell_name[$i]);
			}else{
				if($i == ($cellcode_count*$ccount)){
					$ccount++;
				}
				$code = $this->cellCode[$ccount-2].$this->cellCode[$i-($cellcode_count*($ccount-1))].'1';
				$this->getActiveSheet()->setCellValue($code, $cell_name[$i]);
			}
			$this->getActiveSheet()->getStyle($code)->getFont()->setBold(true);
		}

		$this->getActiveSheet()->fromArray($data, NULL, 'A2');
		
		$filename=$title.'.xls';
		$filename = iconv("UTF-8","EUC-KR",$filename);
		header('Content-Type: application/vnd.ms-excel;charset=utf-8'); //mime 타입
		header('Content-Type: application/x-msexcel;charset=utf-8');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); // 브라우저에서 받을 파일 이름
		header('Cache-Control: max-age=0'); //no cache
		header('Pragma: no-cache');	
		$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
}
?>