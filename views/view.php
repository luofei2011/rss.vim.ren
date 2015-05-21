<?php
class View {
    public function init($file, $data) {
        $content = $this->fetch($file, $data);
        echo $content;
    }

    public function fetch($file, $data) {
        ob_start();
        extract($data);
        include V_PATH . $file . EXT;
        $content = ob_get_contents();
        ob_clean();
        return $content;
    }
}
