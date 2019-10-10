<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Paging{
	protected $CI;
	private $total, $pageNum, $b_pageNum_list, $page_limit, $page_list, $total_page, $block, $total_block, $b_start_page, $b_end_page;
		
	public function __construct(){
		$this->CI =& get_instance();
	}
	// 페이징 시작시 셋팅 먼저 option= 총갯수, 페이지넘버, 페이지당보여질 리스트 갯수, 보여질블럭갯수
	public function paging_setting($total, $pageNum, $page_list = 12, $b_pageNum_list = 5){
		$this->total 			= (int)$total;
		$this->pageNum 			= (int)$pageNum;
		$this->page_list		= (int)$page_list;											
		$this->b_pageNum_list	= (int)$b_pageNum_list;										
		$this->total_page		= ceil($this->total / $this->page_list);						
		if($this->pageNum > $this->total_page || $this->pageNum < 0) $this->pageNum = 1;	
		$this->block			= ceil($this->pageNum / $this->b_pageNum_list);					
		$this->b_start_page		= (($this->block-1) * $this->b_pageNum_list)+1;
		$this->b_end_page		= $this->b_start_page + $this->b_pageNum_list -1;
		$this->total_block		= ceil($this->total_page / $this->b_pageNum_list);
		$this->page_limit = ($this->pageNum-1) * $this->page_list;
		if($this->b_end_page > $this->total_page){
			$this->b_end_page = $this->total_page;
		}	
	}
	public function get_paging($this_page='', $search='', $custom_css = 'default-paging-nav'){
		if(empty($this_page)) $this_page = site_url();
		$paging_html = "";
		if($this->total >0 && $this->total_page > 1){
			$paging_html .= "<ul class='".$custom_css."'>".PHP_EOL;
			if(/* $this->block == $this->total_block && */ $this->block !=1){
				$paging_html .= "<li><a href='".$this_page."1".$search."' class='paging-first-btn paging-btn'>맨처음</a></li>";
			}
			if($this->block > 1){
				$paging_html .= "<li><a href='".$this_page.($this->b_start_page-1).$search."' class='paging-prev-btn paging-btn'>이전</a></li>";
			}
			$paging_html .= "<li><ol class='pagingBtns'>";
			for($i=$this->b_start_page; $i<=$this->b_end_page; $i++){
				if($this->pageNum == $i){
					$paging_html .= "<li><strong>".$i."</strong></li>"; 
				}else{
					$paging_html .= "<li><a href='".$this_page.$i.$search."'>".$i."</a></li>";
				}
			}
			$paging_html .= "</ol></li>";
			if($this->block < $this->total_block){
				$paging_html .= "<li><a href='".$this_page.($this->b_end_page+1).$search."' class='paging-next-btn paging-btn'>다음</a></li>";
			}
			if(/* $this->block  == 1 &&  $this->total_block > 1  */ $this->block < $this->total_block){
				$paging_html .= "<li><a href='".$this_page.$this->total_page.$search."' class='paging-last-btn paging-btn'>마지막</a></li>";
			}
			$paging_html .= "</ul>".PHP_EOL;
		}
		return $paging_html;
	}

	public function get_page_limit(){
		return $this->page_limit;
	}
	public function get_page_list(){
		return $this->page_list;
	}
}
?>

