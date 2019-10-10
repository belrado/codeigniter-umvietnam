<?php
class MY_Exceptions extends CI_Exceptions{
	function __construct(){
		parent::__construct();
	}
    public function show_404($page = '', $log_error = TRUE)
    {
		$this->CI =& get_instance();
		$this->CI->load->helper('language');
		$lang_message		= $this->CI->lang->line("message");

        if (is_cli())
        {
            $heading = 'Not Found';
            $message = 'The controller/method pair you requested was not found.';
        }
        else
        {
            $heading = '404 Page Not Found';
            $message = array(
				$lang_message['not_found_page_text'],
				$lang_message['not_found_page'],
				$lang_message['more_info_call_us']
			);
        }
        // By default we log this, but allow a dev to skip it
        if ($log_error)
        {
            log_message('error', $heading.': '.$page);
        }
        echo $this->show_error($heading, $message, 'error_404', 404);
        exit(4); // EXIT_UNKNOWN_FILE
    }
}
?>
