<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rss extends MY_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('syndication');
	}
	public function bbsxml($bbs_table='', $type='board', $bbs_id=0){
		if(empty($bbs_table) || is_numeric($bbs_table) || !is_numeric($bbs_id)) show_404();
		if($type == 'single' || $type=='list'){
			$result = $this->syndication->board_ping($bbs_table, $type, $bbs_id);
		}else{
			$result = $this->syndication->board_get($bbs_table, $bbs_id);
		}
		if(!$result) show_404();
		$data = array(
			'result'	=> $result,
			'date' 		=> date(DATE_ATOM, time()),
		);
		header('Content-type:application/rss+xml');
		header('Content-type:text/xml; charset=utf-8');
		$this->load->view('syndixmlboard', $data);
	}
	public function boardxml($bbs_table='', $page=1){
		if(empty($bbs_table) || is_numeric($bbs_table)) show_404();
		header('Content-type:application/rss+xml');
		header('Content-type:text/xml; charset=utf-8');
		$result = $this->syndication->board_get($bbs_table, $page);
		$data = array(
			'result'	=> $result,
			'date' 		=> date(DATE_ATOM, time()),
		);
		$this->load->view('syndixmlboard', $data);
	}
	public function xml($cate=0){
		header('Content-type:application/rss+xml');
		header('Content-type:text/xml; charset=utf-8');
		$result = $this->syndication->get($cate, 0, true, false);
		$data = array(
			'result'	=> $result,
			'date' 		=> date(DATE_ATOM, time()),
			'type'		=> 'view'
		);
		$this->load->view('syndixml', $data);
	}
	public function delxml($cate=0, $id=0){
		header('Content-type:application/rss+xml');
		header('Content-type:text/xml; charset=utf-8');
		$result = $this->syndication->get($cate, $id, true, false);
		$data = array(
			'result'	=> $result,
			'date' 		=> date(DATE_ATOM, time()),
			'type'		=> 'delete'
		);
		$this->load->view('syndixml', $data);
	}
	public function mainrss($cate = 0){
		/*
		 * DATE_RFC822
			DATE_RFC2822
		 */
		if(!is_numeric($cate)) show_404();
		header('Content-type:application/rss+xml');
		header('Content-type:text/xml; charset=utf-8');
		$meta = $this->_get_home_metatag();
		if($cate > 0){
			$result = $this->syndication->get($cate, 0, true, false);
			$data= array(
				'meta'			=> array(
					'title'				=> $result['feed'][0]->syn_title.' - '.$meta['title'],
					'meta_description'	=> $meta['meta_description']
				),
				'result'		=> $result['entry'],
				'feed_mail'		=> 'info@psuedu.org',
				'feed_time' 	=> date(DATE_RFC822, time()),
			);
		}else{
			$result = $this->syndication->get_all(false, true);
			$data= array(
				'meta'			=> $meta,
				'result'		=> $result,
				'feed_mail'		=> 'info@psuedu.org',
				'feed_time' 	=> date(DATE_RFC2822, time()),
			);
		}
		$this->load->view('mainrss', $data);
	}
}
?>
