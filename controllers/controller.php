<?php
Class Controller {
    public function __construct() {
    }

    final protected function load_view($file, $data=array()) {
        include_once V_PATH . 'view' . EXT;
        $view = new View;
        $view->init($file, $data);
    }

    final protected function load_model($model_name) {
        include M_PATH . 'model' . EXT;
        $_mPath = M_PATH . $model_name . EXT;
        if (file_exists($_mPath)) {
            include $_mPath;
            $_m_name = ucfirst($model_name);
            $new_m = new $_m_name;

            return $new_m;
        } else {
            trigger_error('Load file ' . $model_name . ' failed!');
            return;
        }
    }
}
