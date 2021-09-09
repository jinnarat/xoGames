<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MainContro extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('Main_Model', 'model');	
		}

		public function index()
		{
			$names['games'] = $this->model->getLastFiveMatches();
			
			$this->load->view('template/header');
			$this->load->view('player_name_view', $names);	
			$this->load->view('template/footer');
		}
		
		
		public function submit()
		{
			$result = $this->model->submit();
			
			redirect(base_url('MainContro/game', $result));
		}

		public function posting_results()
		{
			$result = $this->model->posting_results();
			
			redirect(base_url('MainContro/results', $result));
		}


		public function results()
		{
			$config = array();
			$config["base_url"] = base_url(). "MainContro/results";
			$config["total_rows"] = $this->model->results_count();
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;

			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["results"] = $this->model->fetch_results($config["per_page"], $page);
			$data["links"] = $this->pagination->create_links();

			$this->load->view('template/header');
			$this->load->view('history_view', $data);
			$this->load->view('template/footer');
		}

	
		function submitVsCpu()
		{
			$result = $this->model->submit1P();
			redirect(base_url('MainContro/gameVsCpu', $result));
		}

		
		public function gameVsCpu()
		{
			$names['games'] = $this->model->getPlayerNames();

			$this->load->view('template/header');
			$this->load->view('game_vs_cpu_view', $names);
			$this->load->view('template/footer');
		}
	}
?>