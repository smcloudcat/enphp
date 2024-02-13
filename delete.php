<?php
// 获取请求中的密码
$password = isset($_GET['password']) ? $_GET['password'] : '';

// 检查密码是否正确
if ($password !== '123456') {
    $response = array(
        'code' => 2,
        'msg' => '密码错误'
    );
    echo json_encode($response);
    exit;
}

// 指定要删除的文件夹路径
$folderPath = 'enphp/';

// 检查文件夹是否存在
if (!file_exists($folderPath) || !is_dir($folderPath)) {
    $response = array(
        'code' => 2,
        'msg' => '文件夹不存在'
    );
    echo json_encode($response);
    exit;
}

// 扫描文件夹并删除其中的文件
$files = glob($folderPath . '/*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

// 返回成功的 JSON 响应
$response = array(
    'code' => 1,
    'msg' => '删除成功'
);
echo json_encode($response);