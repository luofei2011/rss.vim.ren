<?php
Class Model {
    public function __construct() {
    }

    protected function query($query = "") {
        if (IS_DEBUG) {
            $dbc = mysqli_connect('localhost', 'root', '', 'rss_vim_ren');
        } else {
    	    $dbc = mysqli_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS, SAE_MYSQL_DB);
        }
        $result = mysqli_query($dbc, $query);
        $data = array();

        while($row = @mysqli_fetch_assoc($result)) {
            array_push($data, $row);
        }

        mysqli_close($dbc);

        return (count($data) == 1 && is_array($data)) ? $data[0] : $data;
    }
}
