﻿<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apresentacao extends CI_Controller {

	public function Apresentacao() 
	{
		parent::__construct();
		$this->check_isvalidated();
	}
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }
	
	function add()
    {
        $data['title'] = "Cadastro de Apresentação - Controle de Estoque";
        $data['headline'] = "Cadastro de Apresentação";
        $data['include'] = "apresentacao_add";
        $this->load->view('template', $data);
    }
	
	function create()
    {
        $this->load->model('MApresentacao','',TRUE);
        $this->MApresentacao->addApresentacao($_POST);
        redirect('produto/add', 'refresh');
    }
	
}

/* End of file Apresentacao.php */
/* Location: ./application/controllers/Apresentacao.php */