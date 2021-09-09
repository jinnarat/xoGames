<?php
/***
 * filepath: application/core/MY_Controller.php
 */

//setup your base controller
class DB_Controller extends CI_Controller {

    //declare them globally in your controller
//    protected $ncr_db;
//    protected $signon_db;

    function __construct() 
    {
        parent::__construct();

        //Load them in the constructor
        $this->db = $this->load->database('default', TRUE);
       
    }

}