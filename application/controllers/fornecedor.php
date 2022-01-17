<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fornecedor extends CI_Controller {

	public function Fornecedor() 
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
        $data['title'] = "Cadastro de Fornecedor - Controle de Estoque";
        $data['headline'] = "Cadastro de Fornecedores";
        $data['include'] = "fornecedor_add";
		$this->load->model('MFornecedor', '', TRUE);
		$data['fornecedores'] = $this->MFornecedor->listFornecedor();
        $this->load->view('template', $data);
    }
	
	function create()
    {
        $this->load->model('MFornecedor','',TRUE);
        $this->MFornecedor->addFornecedor($_POST);
        redirect('fornecedor/listing', 'refresh');
    }
	
	function edit()
	{
		$id = $this->uri->segment(3);
		$this->load->model('MFornecedor', '', TRUE);
		$data['fornecedor'] = $this->MFornecedor->getFornecedor($id)->result();
		$data['title'] = "Modificar Fornecedores - Controle de Estoque";
		$data['headline'] = "Edição de Fornecedores";
		$data['include'] = "fornecedor_edit";
		$this->load->view('template', $data);
	}
	
	function update()
	{
		$this->load->model('MFornecedor','',TRUE);
		$this->MFornecedor->updateFornecedor($_POST['id_fornecedor'], $_POST);
		redirect('fornecedor/listing', 'refresh');
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
		$this->load->model('MFornecedor','',TRUE);
		$this->MFornecedor->deleteFornecedor($id);
		redirect('fornecedor/listing', 'refresh');
	}
	
	function inativa()
	{
		$id = $this->uri->segment(3);
		$this->load->model('MFornecedor','',TRUE);
		$this->MFornecedor->inativarFornecedor($id);
		redirect('fornecedor/listing', 'refresh');
	}
	
	function ativa()
	{
		$id = $this->uri->segment(3);
		$this->load->model('MFornecedor','',TRUE);
		$this->MFornecedor->ativarFornecedor($id);
		redirect('fornecedor/listing_inativos', 'refresh');
	}

	function listing()
	{
		$this->load->model('MFornecedor','',TRUE);
		$qry = $this->MFornecedor->listFornecedor();
		$table = $this->table->generate($qry);
		$tmpl = array ( 'table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;"); 
		$this->table->set_heading('Editar', 'Inativar', 'CNPJ', 'Razão Social', 'Telefone');
		$table_row = array();
		foreach ($qry->result() as $fornecedor)
		{
			$table_row = NULL;
			$table_row[] = anchor('fornecedor/edit/' . $fornecedor->id_fornecedor, '<span class="ui-icon ui-icon-pencil"></span>');
			$table_row[] = anchor('fornecedor/inativa/' . $fornecedor->id_fornecedor, '<span class="ui-icon ui-icon-minusthick"></span>');
			$table_row[] = $fornecedor->cnpj;
			$table_row[] = $fornecedor->razao_social;
			$table_row[] = $fornecedor->telefone;
			$this->table->add_row($table_row);
		}    
		$table = $this->table->generate();
		$data['title'] = "Listagem de Fornecedores - Controle de Estoque";
		$data['headline'] = "Listagem de Fornecedores";
		$data['include'] = 'fornecedor_listing';
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}
	
	function listing_inativos()
	{
		$this->load->model('MFornecedor','',TRUE);
		$qry = $this->MFornecedor->listFornecedorInativo();
		$table = $this->table->generate($qry);
		$tmpl = array ( 'table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;"); 
		$this->table->set_heading('Ativar', 'CNPJ', 'Razão Social', 'Telefone');
		$table_row = array();
		foreach ($qry->result() as $fornecedor)
		{
			$table_row = NULL;
			$table_row[] = anchor('fornecedor/ativa/' . $fornecedor->id_fornecedor, '<span class="ui-icon ui-icon-plusthick"></span>');
			$table_row[] = $fornecedor->cnpj;
			$table_row[] = $fornecedor->razao_social;
			$table_row[] = $fornecedor->telefone;
			$this->table->add_row($table_row);
		}    
		$table = $this->table->generate();
		$data['title'] = "Listagem de Fornecedores - Controle de Estoque";
		$data['headline'] = "Listagem de Fornecedores";
		$data['include'] = 'fornecedor_listing';
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}
}

/* End of file fornecedor.php */
/* Location: ./application/controllers/fornecedor.php */