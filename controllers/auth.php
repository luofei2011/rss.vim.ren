<?php
class Auth extends Controller {
    public $isLogin = false;
    public $username = null;
    public $uid = null;

    public function __construct() {
        if (Session::get('token')) {
            $this->isLogin = true;
        }

        $this->username = Session::get('username');

        $this->main = $this->load_model('main');

        // 得到用户信息
        $result = $this->main->get_user_id($this->username);
        if ($result) {
            $this->uid = $result['id'];
        }
    }

    public function add() {
        if (!$this->auth()) return;

        $params = $_POST;
        $result = $this->main->add_record($this->uid, $params);

        echo json_encode(array(
            'status' => 200,
            'msg' => 'success'
        ));
    }

    public function search() {
        if (!$this->auth()) return;

        $kw = $_GET['kw'];

        $result = $this->main->search($this->uid, $kw);

        echo json_encode(array(
            'status' => 200,
            'data' => $result
        ));
    }

    private function auth() {
        if (!$this->isLogin) {
            // 判断是否为ajax请求
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(array(
                    'status' => 302,
                    'url' => BASE_URL . '?f=user_login'
                ));
            } else {
                header('Location: ' . BASE_URL . '?f=user_login');
            }
            return false;
        }
        return true;
    }
}
