<?php
	class Pages extends CI_Controller {

		public function show($page = 'home')
		{
			if (! file_exists(APPPATH.'views/pages/'.$page.'.php'))
			{
				show_404();
			}

			$data['title'] = ucfirst($page);

			//ここでviewにとばしている第1引数に飛ばしたいviewファイルの文字列
			//第2引数に飛ばしたいデータの配列(連想配列)
			$this->load->view('templates/header', $data);
			$this->load->view('pages/' . $page, $data);
			$this->load->view('templates/footer', $data);
		}

		public function test()
		{
			$data['test'] = 'テスト';
			$data['test2'] = 'テスト2';
			$data['test3'] = 'テスト3';

			$this->load->view('templates/test', $data);
		}

		public function index()
		{
			$data['test'] = 'テスト7';
			$data['test2'] = 'テスト8';
			$data['test3'] = 'テスト9';

			$this->load->view('templates/test', $data);
		}

	}
