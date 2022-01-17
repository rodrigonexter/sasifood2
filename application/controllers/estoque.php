<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estoque extends CI_Controller {

	public function Estoque() 
	{
		parent::__construct();
		$this->check_isvalidated();
	}
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }
	
	public function sair(){
        $this->session->sess_destroy();
        redirect('login');
    }

	public function index()
	{
        $data['title'] = "Página Inicial - Controle de Estoque";
        $data['headline'] = "Controle de Estoque";
        $data['include'] = "estoque_index";
	    $this->load->view('template', $data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(3);
		$this->load->model('MEstoque', '', TRUE);
		$data['estoque'] = $this->MEstoque->getEstoque($id)->result();
		$data['title'] = "Modificar Estoque - Controle de Estoque";
		$data['headline'] = "Edição de Estoque";
		$data['include'] = "estoque_edit";
		$this->load->model('MProduto', '', TRUE);
		$data['produtos'] = $this->MProduto->listProduto();
		$this->load->view('template', $data);
	}
	
	function update()
	{
		$this->load->model('MEstoque','',TRUE);
		$this->MEstoque->updateEstoque($_POST['id_estoque'], $_POST);
		redirect('estoque/listing', 'refresh');
	}
	
	function listing()
	{
		$this->load->model('MEstoque','',TRUE);
		$qry = $this->MEstoque->listEstoque();
		$table = $this->table->generate($qry);
		$tmpl = array ( 'table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;"); 
		$this->table->set_heading('Editar', 'Produto', 'Quantidade');
		$table_row = array();
		foreach ($qry->result() as $estoque)
		{
			$table_row = NULL;
			$table_row[] = anchor('estoque/edit/' . $estoque->id_estoque, '<span class="ui-icon ui-icon-pencil"></span>');
			$table_row[] = $estoque->nome_produto;
			if($estoque->quantidade <= $estoque->qtd_minima)
			{
				$table_row[] = ('<span class="badge badge-important">' . $estoque->quantidade . '</span>');
			} else
			{
				$table_row[] = $estoque->quantidade;
			}
			$this->table->add_row($table_row);
		}    
		$table = $this->table->generate();
		$data['title'] = "Listagem do Estoque - Controle de Estoque";
		$data['headline'] = "Listagem do Estoque";
		$data['include'] = 'estoque_listing';
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}
}

/* End of file estoque.php */
/* Location: ./application/controllers/estoque.php */