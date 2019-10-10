<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'assets/lib/phpExcelClasses/PHPExcel/IOFactory.php';

class Phpexcel_rank{
	public function  __construct(){
		//$this->filepath = FCPATH.'assets/file/down/2016_univ_us_rank.xlsx';	
	}
	// 기본셋팅
	private function set_table($filepath=''){
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
	}
	// 미국에서 활동하고있는 sgu출신 한국인 의사
	public function get_medi_excel_value($filepath, $hide=false){
		$this->set_table($filepath);
		$len = 0;
		$row = 0;
		for($column = 'A'; $column != $this->maxColumn; $column++){
			$len++;
		}
		$table='';
		foreach ($this->lines as $key => $line) {	
            $cursor = 0;
			$table .= (!$hide) ? "<tr>" : ($row > 6) ? "<tr class='hide-line'>" : "<tr>";
			for($i=0; $i<$len; $i++){
				$table .= "<td>".$line[$cursor++]."</td>";
			}
			$table .= '</tr>';
			$row++;
		}
		return $table;
	}
	// 약의학대페이지 
	public function get_medi_jobrank($show_len = 5, $filepath){
		$this->set_table($filepath);
		$rank_table ='';
		$rank_table .= '<table class="psu-tableB psu-tableC medi-jobrank-table" id="medi-jobrank-table">';
		$rank_table .= '<thead><tr><th scope="col" class="hide-column">순위</th><th scope="col">직업(Occupation title)</th><th scope="col" class="hide-column">평균 연봉</th></tr></thead>';
		$rank_table .= '<tbody>';
		$len = 0;	
        foreach ($this->lines as $key => $line) {
            $cursor = 0;
            $item = array(
            	"rank"=>$line[$cursor++],
                "Occupation_title"=>$line[$cursor++],
                "Annual_mean_wage"=>$line[$cursor++]
            );
			if($len == 0){
				$rank_table .= '<tr class="border-tnone">';
			}else{
				if($len > $show_len){
					$rank_table .= '<tr class="hide-tablerow">';
				}else{
					$rank_table .= '<tr>';
				}
			}
			$rank_table .= "<td class='hide-column imgfont-bold'>".$item['rank']."</td>";
			$rank_table .= "<td class='imgfont-bold'><span class='medi-td-jobrank'>".$item['rank']."위. </span>".$item['Occupation_title']."<span class='medi-td-wage'>평균 연봉 : $".number_format($item['Annual_mean_wage'])."</span></td>";
			$rank_table .= "<td class='hide-column imgfont-bold'>$".number_format($item['Annual_mean_wage'])."</td>";
			$rank_table .= '</tr>';
			$len++;
		}
		$rank_table .= '</tbody></table>';
		return $rank_table;	
	}
	// 미국대학순위
	public function get_rank_us($filepath){
		$this->set_table($filepath);
		$rank_table = '<div class="psu-table-sec">';
		$rank_table .= '<table class="psu-tableB univ-ranking-table"><caption>2016년 미국대학 순위와 해당학교의 위치, 학비, 신입생, 합격률</caption>';
		$rank_table .= '<colgroup><col style="width:9%" /><col style="width:26%" /><col style="width:20%" /><col style="width:15%" /><col style="width:15%" /><col style="width:15%" /></colgroup>';
		$rank_table .= '<thead><tr><th scope="col" class="bg_eaf2fb">순위</th><th scope="col">대학교</th><th scope="col">위치</th><th scope="col">학비/수수료</th><th scope="col">신입생(명)</th><th scope="col">합격률(지원자대비)</th></tr></thead>';
		$rank_table .= '<tbody>';
		$len = 0;	
        foreach ($this->lines as $key => $line) {
            $cursor = 0;
            $item = array(
            	"rank"=>$line[$cursor++],
                "year"=>$line[$cursor++],
                "university"=>$line[$cursor++],
                "place"=>$line[$cursor++],
                "expense"=>$line[$cursor++],
                "freshmen"=>$line[$cursor++],
                "success"=>$line[$cursor++]
            );
			if($len == 0){
				$rank_table .= '<tr class="border-tnone">';
			}else{
				$rank_table .= '<tr>';
			}
			$rank_table .= "<td class='bg_fbfcdf'>".$item['rank'].".</td>";
			$rank_table .= "<td>".$item['university']."</td>";
			$rank_table .= "<td>".$item['place']."</td>";
			$rank_table .= "<td>$".number_format((int) $item['expense'])."</td>";
			$rank_table .= "<td>".preg_replace('/^0$/', '--', number_format((int) $item['freshmen']))."</td>";
			$rank_table .= "<td>".preg_replace('/^0\%$/', '--', round((int)$item['success']*100).'%')."</td>";
			$rank_table .= '</tr>';
			$len++;
		}
		$rank_table .= '</tbody></table>';
		$rank_table .= '</div>';
		return $rank_table;		
	}
	// 세계대학순위 
	public function get_rank_world($filepath){
		$this->set_table($filepath);
		$rank_table = '<div class="psu-table-sec">';
$rank_table .= '<table class="psu-tableB univ-ranking-table"><caption>2016년 세계대학 순위와 해당학교의 국가, 교육여건, 국제화지표, 연구분야, 논문피인용수, 산합혁력 데이터</caption>';
		$rank_table .= '<colgroup><col style="width:9%" /><col style="width:28%" /><col style="width:9%" /><col style="width:18%" /><col style="width:9%" /><col style="width:9%" /><col style="width:9%" /><col style="width:9%" /></colgroup>';
		$rank_table .= '<thead><tr><th scope="col" class="bg_eaf2fb">순위</th><th scope="col">대학교</th><th scope="col">국가</th><th scope="col">도시</th><th scope="col">글로벌 스코어</th><th scope="col">전체학생</th><th scope="col">외국인학생</th><th scope="col">연구순위</th></tr></thead>';
		$rank_table .= '<tbody>';
		$len = 0;			
        foreach ($this->lines as $key => $line) {
            $cursor = 0;
            $item = array(
                "rank"=>$line[$cursor++],
                "year"=>$line[$cursor++],
                "university"=>$line[$cursor++],
                "nation"=>$line[$cursor++],
                "city"=>$line[$cursor++],
                "global_score"=>$line[$cursor++],
                "total_students"=>$line[$cursor++],
                "total_int_students"=>$line[$cursor++],
                "research_ranking"=>$line[$cursor++]
            );
			if($len == 0){
				$rank_table .= '<tr class="border-tnone">';
			}else{
				$rank_table .= '<tr>';
			}
			$rank_table .= "<td class='bg_fbfcdf'>".$item['rank'].".</td>";
			$rank_table .= "<td>".$item['university']."</td>";
			$rank_table .= "<td>".$item['nation']."</td>";
			$rank_table .= "<td>".$item['city']."</td>";
			$rank_table .= "<td>".preg_replace('/.0$/', '', sprintf("%.1f",$item['global_score']))."%</td>";
			$rank_table .= "<td>".preg_replace('/^0$/', '--', number_format((int) $item['total_students']))."</td>";
			$rank_table .= "<td>".preg_replace('/^0$/', '--', number_format((int) $item['total_int_students']))."</td>";
			$rank_table .= "<td>".$item['research_ranking']."</td>";
			$rank_table .= '</tr>';
			$len++;
        }
		$rank_table .= '</tbody></table>';
		$rank_table .= '</div>';
		return $rank_table;	
	}
	// psu스타강사 
	public function get_teacher_card($type, $filepath){
		$this->set_table($filepath);
		
		$html_txt = '';
		$js_arr = '<script>';
		$js_arr .= 'var aTeacher =[';
		$len = 0;	
        foreach ($this->lines as $key => $line) {
            $cursor = 0;
            $item = array(
            	"name"		 => func_change_marks($line[$cursor++]),
                "name2"		 => $line[$cursor++],
                "subject"	 => func_change_marks($line[$cursor++]),
                "experience" => func_change_marks($line[$cursor++]),
                "youtube"	 => $line[$cursor++],
                "image"		 => $line[$cursor++],
                "alt"		 => func_change_marks($line[$cursor++]),
                "best"		 => $line[$cursor++]
            );
			
			$js_arr .= ($len==0) ? '{' : ', {';
			$js_arr .= 'name:"'.$item['name'].'",';
			$js_arr .= 'name_another:"'.$item['name2'].'",';
			$experience_arr = explode("+", $item['experience']);
			$experience_txt = '[';
			for($k = 0; $k<count($experience_arr); $k++){
				if($k == 0){
					$experience_txt .= "'".$experience_arr[$k]."'";
				}else{
					$experience_txt .= ",'".$experience_arr[$k]."'";
				}
			}
			$experience_txt .= ']';
			$js_arr .= 'experience:'.$experience_txt.',';
			$js_arr .= 'image:"'.$item['image'].'",';
			
			$youtube_check = (trim($item['youtube']) !== '') ? 'true' : 'false';
			$js_arr .= 'youtube:{use:'.$youtube_check.', link:"'.trim($item['youtube']).'"},';
			$js_arr .= 'alt:"'.$item['alt'].'",';
			$js_arr .= 'best:"'.$item['best'].'"';
			$js_arr .= '}';
			
			$html_txt .= '<li>';
			$html_txt .= ($youtube_check == 'true') ? '<div class="inner-box youtubeWrap">' : '<div class="inner-box">';
			$html_txt .= '<div class="txt-box">';
			$html_txt .= '<h5 class="tit">'.$item['name'].' 선생님</h5><ul>';
			for($j = 0; $j<count($experience_arr); $j++){
				$html_txt .= '<li>- '.$experience_arr[$j].'</li>';
			}
			$html_txt .= '</ul>';
			if($youtube_check == 'true') $html_txt .= '<div class="youtube-go"><a href="'.trim($item['youtube']).'" target="_blank" title="새창"><img src="/img/btn_youtube.png" alt="동영상보기" /></a></div>';
			$html_txt .= '</div><div class="img-box"><img src="/assets/'.trim($item['image']).'" alt="'.$item['alt'].'" /></div>';		
			$html_txt .= '</div>';
			$html_txt .= '</li>';
			
			$len++;
		}
		$js_arr .= ']</script>';
		if($type == 'js'){
			return $js_arr;	
		}else{
			return $html_txt;	
		}
	}	
}
?>