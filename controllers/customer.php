<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends MY_Controller {
    
  public function __construct() {
    parent::__construct();
    $this->load->model( 'Customer_model' );
    
    // Define the search values
    $this->_searchConf  = array(
      'shop' => $this->_default_store,
      'customer_name' => '',
      'email' => '',
      'page_size' => '80',
    );
    $this->_searchSession = 'customer';
  }
  
  public function index(){
    $this->is_logged_in();
    
    $this->manage();
  }
  
  public function manage( $page =  0 ){
    // Check the login
    $this->is_logged_in();

    // Init the search value
    $this->initSearchValue();

    // Get data
    $arrCondition =  array(
       'customer_name' => $this->_searchVal['customer_name'],
       'email' => $this->_searchVal['email'],
       'page_size' => $this->_searchVal['page_size'],              
    );
    $this->Customer_model->rewriteParam($this->_searchVal['shop']);
    $data['query'] =  $this->Customer_model->getList( $arrCondition );
    $data['total_count'] = $this->Customer_model->getTotalCount();
    $data['page'] = $page;
    
    // Define the rendering data
    $data = $data + $this->setRenderData();

    // Store List    
    $arr = array();
    foreach( $this->_arrStoreList as $shop => $row ) $arr[ $shop ] = $shop;
    $data['arrStoreList'] = $arr;
    
    // Load Pagenation
    $this->load->library('pagination');

    $this->load->view('view_header');
    $this->load->view('view_customer', $data );
    $this->load->view('view_footer');
  }
}            

