<?php
class Language extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function lang_switch($language = 'ko') 
    {
        $returnURI = ($this->input->get('returnURL'))?$this->input->get('returnURL'):'';
        $change_uri = $this->homelanguage->lang_switch_link($returnURI, $language);
        redirect(base_url().$change_uri);
    }
}
?>
