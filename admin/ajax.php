<?php
session_start();

if (!isset($_GET['act'])) {
echo "非法请求";
}

if ($_GET['act'] === 'login') {
    $credentials = json_decode(file_get_contents('../data/admin_credentials.json'), true);
    if ($_POST['username'] === $credentials['username'] && md5(md5($_POST['password'].'xiaocat').'xiaocat') === $credentials['password']) {
        $_SESSION['admin'] = true;
        echo "1";
    } else {
        echo "2";
    }
}

if ($_GET['act'] === 'change') {
    if (!isset($_SESSION['admin'])) {
        echo "2";
        exit();
    } else {
        $credentials = json_decode(file_get_contents('../data/admin_credentials.json'), true);
        $newUsername = $_POST['newUsername'];
        $newPassword = md5(md5($_POST['newPassword'].'xiaocat').'xiaocat');
        $credentials['username'] = $newUsername;
        $credentials['password'] = $newPassword;
        file_put_contents('../data/admin_credentials.json', json_encode($credentials));
        echo "1";
        exit();
    }
}

if ($_GET['act'] === 'set') {
    if (!isset($_SESSION['admin'])) {
        echo "2";
        exit();
    } else {
        $data = array(
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'keyword' => $_POST['keyword'],
            'foot' => $_POST['foot'],
            'bq' => $_POST['bq'],
            'cdn' => $_POST['cdn'],
            'css' => $_POST['css'],
            'gg' => $_POST['gg']
        );
        file_put_contents('../data/data.json', json_encode($data));
        echo "1";
        exit();
        $data = json_decode(file_get_contents('../data/data.json'), true);
    }
}
?>