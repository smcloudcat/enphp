<?php
session_start();
    $version = file_get_contents('../version.txt');
    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit();
    }
    ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>小猫咪PHP加密系统</title>
    <!-- 引入layui框架 -->
    <link rel="stylesheet" href="../layui/css/layui.css">
    <script src="https://cdn.lwcat.cn/jquery/jquery.js"></script>
    <link rel="stylesheet" href="../layui/css/admin.css">
</head>
<body>
            <form class="layui-form" id="loginForm">
        <div class="demo-login-container">
            <div class="login-header">
        <a href="index.php"> 小猫咪PHP加密系统后台 </a>
      </div>
     <div class="login-header"><a href="set.php">基本设置</a>&nbsp;&nbsp;&nbsp; <a href="change.php">修改密码</a> &nbsp;&nbsp;&nbsp; <a href="file.php">管理文件</a></div>
     
     <center>
                        
<?php
$url = "https://lwcat.cn/jm/update.php"; 
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($status_code == 200) {
    $json = json_decode($response, true);
        if ($json['version'] == $version) {
            echo "当前版本".$version."<br>最新版本：".$json['version']."<br>当前已是最新版本";
        } else{
            echo "当前版本：".$version."<br>最新版本：".$json['version']."<br>有新版本哦，请参考更新内容来考虑是否更新<br>本次更新内容：<br>".$json['new']."<br><a class='btn btn-primary' href='".$json['url']."'>下载最新版本</a>";
    }
} else {
    echo "请求服务器失败，请联系作者";
}
?>
                        
                    </center>

        </div>
    </form>

<script src="../layui/layui.js"></script>
</body>
</html>