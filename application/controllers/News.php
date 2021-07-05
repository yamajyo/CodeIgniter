<?php
class News extends CI_Controller {

	public function __construct()
	{
			parent::__construct();

			// モデルのロード。 news_model というオブジェクト名で使用できる。
			// このコントローラの他のメソッドで使う。
			$this->load->model('news_model');

			// system/helpers の URL ヘルパー関数をロード。ビューで使う。
			$this->load->helper('url_helper');
	}

	public function index()
	{
			// 引数を指定せずに全ニュースをモデル経由で連想配列として取得する。
			$data['news'] = $this->news_model->get_news();

			$data['title'] = 'News archive';

			$this->load->view('templates/header', $data);
			$this->load->view('news/index', $data);
			$this->load->view('templates/footer');
	}

	public function view($slug = NULL)
	{
			// 引数を指定して WHERE 'slug' = $slug のニュースをモデル経由で連想配列として取得する。
			$data['news_item'] = $this->news_model->get_news($slug);

			if (empty($data['news_item']))
			{
					show_404();
			}

			$data['title'] = $data['news_item']['title'];

			$this->load->view('templates/header', $data);
			$this->load->view('news/view', $data);
			$this->load->view('templates/footer');
	}

	public function create()
	{
			// フォームヘルパーとフォームバリデーションライブラリをロードする。コンストラクタでやってもよい。
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'Create a news item';

			// title と text を必須入力 required に設定する。
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('text', 'Text', 'required');

			if ($this->form_validation->run() === FALSE)
			{
					// submit 前や、不正な入力のときはフォームを表示する。
					$this->load->view('templates/header', $data);
					$this->load->view('news/create');
					$this->load->view('templates/footer');
			}
			else
			{
					// 正しく入力されたときは成功ページを表示する。
					$this->news_model->set_news();
					$this->load->view('news/success');
			}
	}
}
