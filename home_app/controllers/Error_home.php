<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Error_home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
        show_404();
	}
}
?>
