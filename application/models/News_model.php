<?php
    class News_model extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function get_news($slug = false)
        // $slugのエスケープ処理は Query Builder がしてくれる。
        {
            if ($slug === false) {
                // SELECT * FROM news
                $query = $this->db->get('news');

                // 結果を配列で取得する。
                return $query->result_array();
            }

            // SELECT * FROM news WHERE 'slug' = $slug
            $query = $this->db->get_where('news', array('slug' => $slug));

            // 結果を1行、配列で取得する。
            return $query->row_array();
        }

        public function set_news()
        {
            // URL ヘルパーをロード。コンストラクタでやってもよいし、
            // ニュースセクションのときにコントローラのコンストラクタでロードする設定にしているので、
            // ここで明示的にロードしなくてもよい。
            $this->load->helper('url');

            // URL ヘルパーの url_title() メソッドを使い、スペースを - に、大文字を小文字に置換する。
            // input ライブラリの post() メソッドを使い、データを取得する。
            // 組み込み関数 urlencode() を使うことで、日本語等マルチバイト文字の入力にも対応する。
            $slug = urlencode(url_title($this->input->post('title'), '-', true));

            $data = array(
                'title' => $this->input->post('title'),
                'slug' => $slug,
                'text' => $this->input->post('text')
            );

            return $this->db->insert('news', $data);
        }
    }
