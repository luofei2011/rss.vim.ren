<?php
include_once "config.php";
$params = $_GET;

// 首先加载session类
include_once LIB_PATH . 'session' . EXT;
new Session;

// 得到默认的Controller
$params['c'] = isset($params['c']) ? $params['c'] : 'nice';

// 得到需要调用的function
$params['f'] = isset($params['f']) ? $params['f'] : 'index';

// 其他的参数按照key为参数名，value为参数值的形式使用

// 加载核心控制器
include_once C_PATH . 'controller' . EXT;

// 根据Controller名加载控制器
$_c = C_PATH . $params['c'] . EXT;
if (file_exists($_c)) {
    require_once $_c;
} else {
    trigger_error('Load Controller ' . $params['c'] . ' failed!');
    return;
}

// 根据参数c得到控制器类名，需要首字母大写
$_c_name = ucfirst($params['c']);
$new_c = new $_c_name;

// 得到调用的函数名
$action = $params['f'];
// 得到调用的参数, 以数组的方式存储。后面传参
$args = array();
foreach($params as $key => $param) {
    if ($key !== 'f' && $key !== 'c') {
        array_push($args, $param);
    }
}
if ($action) {
    if (method_exists($new_c, $action)) {
        // 完成函数调用及参数传递
        call_user_func_array(array($new_c, $action), $args);
    }
}
