<?php
Class Nice extends Controller {
    public $uid = null;
    public $isLogin = false;
    public $username = null;
    public $post_data = null;

    
    public function __construct() {
        $this->main = $this->load_model('main');

        if (Session::get('token')) {
            $this->isLogin = true;
        }
        $this->username = Session::get('username');
        $result = $this->main->get_user_id($this->username);
        if ($result)
            $this->uid = $result['id'];
    }

    public function index() {
        $data = array();
        $data['userInfo'] = array(
            'isLogin' => $this->isLogin,
            'username' => $this->username
        );
        $this->load_view('head', array (
            'title' => '首页',
            'head_title' => '首页',
            'need_back' => false
        ));
        $this->load_view('index', $data);
        $this->load_view('foot');
    }

    public function add() {
        $this->load_view('head', array (
            'title' => '添加记录',
            'head_title' => '添加记录',
            'need_back' => true,
            'rightNav' => array(
                'url' => '/?f=search',
                'label' => '搜索'
            )
        ));
        $this->load_view('add');
        $this->load_view('foot');
    }

    public function search() {
        $this->load_view('head', array (
            'title' => '搜索记录',
            'head_title' => '搜索记录',
            'need_back' => true,
            'rightNav' => array(
                'url' => '/?f=add',
                'label' => '添加'
            )
        ));
        $this->load_view('search');
        $this->load_view('foot');
    }

    public function user_center() {
        $data = array();
        $data['userInfo']['isLogin'] = $this->isLogin;

        if ($this->isLogin) {
            $info = $this->main->get_user_info($this->username);
            $data['userInfo'] = array(
                'isLogin' => $this->isLogin,
                'username' => $this->username,
                'email' => $info['email'],
                'phone' => $info['phone'],
                'sex' => '',
            );
        }

        $this->load_view('user_center', $data);
    }

    public function user_login() {
        if ($this->isLogin) {
            $this->index();
            return;
        }

        $this->load_view('head', array (
            'title' => '登录',
            'head_title' => '登录',
            'need_back' => true
        ));
        $this->load_view('login');
        $this->load_view('foot');
    }

    public function login() {
        $uInfo = $_POST;
        $username = strip_tags($uInfo['username']);
        $password = md5($uInfo['pwd']);

        $result = NULL;
        if ($username && $password) {
            $result = $this->main->is_user_exist($username, $password);
        } else {
            header('Location: ' . BASE_URL . '?f=user_login');
        }

        if ($result) {
            Session::set('username', $username);
            Session::set('token', md5($username . "poised-flw.com"));
            header('Location: ' . BASE_URL);
        } else {
            header('Location: ' . BASE_URL . '?f=user_login');
        }
    }

    public function register() {
        return;
        $uInfo = (array)json_decode($this->post_data);
        $username = strip_tags($uInfo['username']);
        $password = md5($uInfo['password']);

        $result = NULL;
        if ($username && $password) {
            $result = $this->main->check_exist($username);
        }

        if (!$result) {
            $this->main->insert_into_user($username, $password);
        } else {
            $result = $this->main->is_user_exist($username, $password);

            if (!$result) {
                echo "fail";
                return false;
            }
        }

        Session::set('username', $username);
        Session::set('token', md5($username . "poised-flw.com"));
        echo "success";
    }

    public function logout() {
        Session::destory();
        header('location: ' . BASE_URL);
    }
}
