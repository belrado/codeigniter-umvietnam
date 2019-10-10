<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Umv extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}
	public function _remap($method, $params = array()){
		if (method_exists($this, $method)){
			return call_user_func_array(array($this, $method), $params);
		}else{
			$data = $this->set_home_base(strtolower(__CLASS__), strtolower($method), 'subheader-'.strtolower(__CLASS__));
			$lang_use_page = array('minnesota', 'minnesota_intro', 'about', 'map');
			if(in_array(strtolower($method), $lang_use_page)){
				$this->lang->load('umv/'.strtolower($method), $this->homelanguage->lang_seting($this->umv_lang));
				$data['lang_contents']		= $this->lang->line("contents");
			}
			if(strtolower($method) === 'minnesota_intro'){
				$data['rank1']	= $this->minnesota_intro_ranking('rank1');
				$data['rank2']	= $this->minnesota_intro_ranking('rank2');
				$data['rank3']	= $this->minnesota_intro_ranking('rank3');
				$data['rank4']	= $this->minnesota_intro_ranking('rank4');
				$data['rank5']	= $this->minnesota_intro_ranking('rank5');
				$data['rank6']	= $this->minnesota_intro_ranking('rank6');
				$data['nobel']	= $this->nobel_list();
			}
			$this->load->view('include/header' ,$data);
			$this->_page(strtolower(__CLASS__).'/'.strtolower($method), $data);
			$this->load->view('include/footer', $data);
		}
	}
	public function index(){
		redirect(site_url().$this->homelanguage->get_lang().'/umv/minnesota');
	}
	private function minnesota_intro_ranking($rank){
		switch($rank){
			case 'rank1' :
				return array(
					'point'=>-1,
					'list'=>array(
						'Harvard University',
						'Stanford University',
						'University of Cambridge',
						'Massachusetts Institute of Technology (MIT)',
						'University of California, Berkeley',
						'Princeton University',
						'University of Oxford',
						'Columbia University'
					)
				);
			break;
			case 'rank2' :
				return array(
					'point'=>0,
					'list'=>array(
						'University of Minnesota, Twin Cities',
						'The University of Melbourne',
						'University of Colorado at Boulder',
						'The University of Texas at Austin',
						'University of Illinois at Urbana-Champaign',
						'University of Paris-Sud (Paris 11)',
						'University of British Columbia'
					)
				);
			break;
			case 'rank3' :
				return array(
					'point'=>-1,
					'list'=>array(
						'University of Pennsylvania (Wharton)',
						'Stanford University',
						'Harvard University',
						'Massachusetts Institute of Technology (Sloan)',
						'University of Chicago (Booth)'
					)
				);
			break;
			case 'rank4' :
				return array(
					'point'=>0,
					'list'=>array(
						'University of Minnesota, Twin Cities (Carlson)',
						'University of Wisconsin, Madison',
						'University of Georgia (Terry)',
						'Michigan State University (Broad)',
						'University of Texas,Dallas',
						'Texas A&M University,College Station (Mays)',
						'University of Maryland,College Park (Smith)',
						'University of Rochester (Simon)'
					)
				);
			break;
			case 'rank5' :
				return array(
					'point'=>1,
					'list'=>array(
						'University of North Carolina, Chapel Hill',
						'University of Minnesota, Twin Cities',
						'University of California, San Francisco',
						'University of Michigan, Ann Arbor',
						'University of Texas, Austin',
						'Ohio State University'
					)
				);
			break;
			case 'rank6' :
				return array(
					'point'=>3,
					'list'=>array(
						'Massachusetts Institute of Technology',
						'California Institute of Technology',
						'University of California, Berkeley',
						'University of Minnesota, Twin Cities',
						'Stanford University',
						'University of Texas, Austin (Cockrell)',
						'Georgia Institute of Technology'
					)
				);
			break;
		}
	}
	private function nobel_list(){
		return array(
			array(
				'laureate' 		=> 'Bob Dylan',
				'discipline'	=> 'Literature',
				'year'	=> '2016'
			),
			array(
				'laureate' 		=> 'Lars Peter Hansen',
				'discipline'	=> 'Economic Sciences',
				'year'	=> '2013'
			),
			array(
				'laureate' 		=> 'Robert J. Shiller',
				'discipline'	=> 'Economic Sciences',
				'year'	=> '2013'
			),
			array(
				'laureate' 		=> 'Brian Kobilka',
				'discipline'	=> 'Chemistry',
				'year'	=> '2012'
			),
			array(
				'laureate' 		=> 'Thomas J. Sargent',
				'discipline'	=> 'Economic Sciences',
				'year'	=> '2011'
			),
			array(
				'laureate' 		=> 'Christopher A. Sims',
				'discipline'	=> 'Economic Sciences',
				'year'	=> '2011'
			),
			array(
				'laureate' 		=> 'Leonid Hurwicz',
				'discipline'	=> 'Economic Sciences',
				'year'	=> '2007'
			),
			array(
				'laureate' 		=> 'Edward C. Prescott',
				'discipline'	=> 'Economic Sciences',
				'year'	=> '2004'
			),
			array(
				'laureate' 		=> 'Daniel McFadden',
				'discipline'	=> 'Economic Sciences',
				'year'	=> '2000'
			),
			array(
				'laureate' 		=> 'Louis J. Ignarro',
				'discipline'	=> 'Physiology or Medicine',
				'year'	=> '1998'
			),
			array(
				'laureate' 		=> 'Paul D. Boyer',
				'discipline'	=> 'Chemistry',
				'year'	=> '1997'
			),
			array(
				'laureate' 		=> 'Edward B. Lewis',
				'discipline'	=> 'Physiology or Medicine',
				'year'	=> '1995'
			),
			array(
				'laureate' 		=> 'George J. Stigler',
				'discipline'	=> 'Economic Sciences',
				'year'	=> '1982'
			),
			array(
				'laureate' 		=> 'John H. van Vleck',
				'discipline'	=> 'Physics',
				'year'	=> '1977'
			),
			array(
				'laureate' 		=> 'Milton Friedman',
				'discipline'	=> 'Economic Sciences',
				'year'	=> '1976'
			),
			array(
				'laureate' 		=> 'Saul Bellow',
				'discipline'	=> 'Literature',
				'year'	=> '1976'
			),
			array(
				'laureate' 		=> 'William Lipscomb',
				'discipline'	=> 'Chemistry',
				'year'	=> '1976'
			),
			array(
				'laureate' 		=> 'John Bardeen',
				'discipline'	=> 'Physics',
				'year'	=> '1972'
			),
			array(
				'laureate' 		=> 'Norman Borlaug',
				'discipline'	=> 'Peace',
				'year'	=> '1970'
			),
			array(
				'laureate' 		=> 'Melvin Calvin',
				'discipline'	=> 'Chemistry',
				'year'	=> '1961'
			),
			array(
				'laureate' 		=> 'Walter Brattain',
				'discipline'	=> 'Physics',
				'year'	=> '1956'
			),
			array(
				'laureate' 		=> 'John Bardeen',
				'discipline'	=> 'Physics',
				'year'	=> '1956'
			),
			array(
				'laureate' 		=> 'Edward C. Kendall',
				'discipline'	=> 'Physiology or Medicine',
				'year'	=> '1950'
			),
			array(
				'laureate' 		=> 'Philip S. Hench',
				'discipline'	=> 'Physiology or Medicine',
				'year'	=> '1950'
			),
			array(
				'laureate' 		=> 'Ernest O. Lawrence',
				'discipline'	=> 'Physics',
				'year'	=> '1939'
			),
			array(
				'laureate' 		=> 'Arthur H. Compton',
				'discipline'	=> 'Physics',
				'year'	=> '1927'
			)
		);
	}
}
?>
