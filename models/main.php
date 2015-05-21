<?php
date_default_timezone_set("PRC");
Class Main extends Model {
    public function get_user_id($username) {
        $result = $this->query("SELECT id FROM `user` WHERE username='$username' or email='$username'");
        return $result;
    }

    public function get_user_info($username) {
        $result = $this->query("SELECT * FROM `user` WHERE username='$username' or email='$username'");
        return $result;
    }

    public function is_user_exist($username, $password)  {
    	$query = "SELECT * FROM `user` WHERE username='$username' OR email='$username' AND password='$password'";
        $result = $this->query($query);

        return $result;
    }

    public function check_exist($username) {
        return $this->query("SELECT * FROM `user` WHERE username='$username' or email='$username'");
    }

    public function insert_into_user($username, $password) {
        $query = "INSERT INTO `user` values('', '$username', '$password', '', '')";
        $result = $this->query($query);

        return $result;
    }

    public function add_record($uid, $post) {
        $title = $post['title'];
        $url = $post['url'];
        $tags = $post['tags'];
        $des = $post['description'];

        $query = "INSERT INTO `rss` values('', '$uid', '$title', '$url', '$tags', '$des')";

        return $this->query($query);
    }

    public function search($uid, $kw) {
	    $query = "SELECT * FROM `rss` WHERE uid='$uid' and title LIKE '%$kw%' or tags LIKE '%$kw%' or description LIKE '%$kw%'";

        $result = $this->query($query);
        $result = is_array($result) ? $result : array();

        return $result;
    }

    public function insert_into_item($data, $uid) {
        $name = $data['itemName'];
        $unit = $data['itemUnit'];
        $frequency = $data['itemFrequency'];
        $query = "INSERT INTO items values('', '$uid', '$name', '$unit', '$frequency')";
        $result = $this->query($query);

        // 得到最近插入记录的id
        $query = "SELECT max(id) FROM items";
        $result = $this->query($query);
        $id = $result["max(id)"];
        return array(
        	'id' => $id,
            'frequency' => $frequency,
            'name' => $name,
            'uid' => $uid,
            'unit' => $unit
        );
    }

    public function update_item($data, $uid) {
        $id = $data['id'];
        $name = $data['itemName'];
        $unit = $data['itemUnit'];
        $frequency = $data['itemFrequency'];
        $query = "UPDATE items set name='$name', unit='$unit', frequency='$frequency' WHERE id=$id AND uid=$uid";
        $result = $this->query($query);

        return $result;
    }

    public function query_run($data, $uid) {
        # 按照时间段进行选择
        if (isset($data['query']) && $data['query']) {
            $start = date('Y-m-d H:i:s', strtotime($data['query']));
            $end = date('Y-m-d H:i:s');
        # 根据时间范围进行选择，如果不选择时间就默认为当天
        } else {
            $start = $data['start'] ? date('Y-m-d H:i:s', strtotime($data['start'])) : date('Y-m-d 00:00:00');
            $end = $data['end'] ? date('Y-m-d H:i:s', strtotime($data['end'])) : date('Y-m-d 23:59:59');
        }
    	$query = "SELECT * FROM run WHERE uid='$uid' AND time >= '$start' AND time <= '$end'";
        $result = $this->query($query);
        $result = is_array($result) ? $result : array();
        return $result;
    }

    public function query_run_new($data, $uid) {
        $query = "SELECT * FROM run WHERE uid=$uid";
        $result = $this->query($query);

        return $result;
    }

    public function get_items_by_name($username = "admin", $uid) {
        $query = "SELECT * FROM items WHERE uid='$uid'";
        $result = $this->query($query);
        return $result;
    }

    public function save_run($data, $uid) {
        $content = join(',', $data);
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO run values('', '$date', '$content', '$uid')";
        $result = $this->query($query);
        return $result;
    }

    public function remove_line($id) {
        $query = "DELETE FROM items WHERE id='$id'";
        $this->query($query);
        return $result;
    }
}
