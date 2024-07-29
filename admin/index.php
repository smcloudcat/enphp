<?php $data = json_decode(file_get_contents('../data/data.json'), true);?>
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
    <link rel="stylesheet" href="<?php echo $data['cdn']; ?>css/layui.css">
    <script src="https://cdn.lwcat.cn/jquery/jquery.js"></script>
    <link rel="stylesheet" href="https://cdn.lwcat.cn/enphp/admin.css">
</head>
<body>
    <form class="layui-form" id="loginForm">
        <div class="demo-login-container">
            <div class="login-header">
                <a href="index.php"> 小猫咪PHP加密系统后台 </a>
            </div>
            <div class="login-header">
                <a href="set.php">基本设置</a>&nbsp;&nbsp;&nbsp; 
                <a href="change.php">修改密码</a>&nbsp;&nbsp;&nbsp; 
                <a href="file.php">管理文件</a>
            </div>
            <center>
                <div id="version-info"></div>
            </center>
        </div>
    </form>
    <script src="<?php echo $data['cdn']; ?>layui.js"></script>
    <script>
        $(document).ready(function() {
            const currentVersion = '<?php echo $version; ?>';
            const updateUrl = 'https://lwcat.cn/jm/update.php';

            $.ajax({
                url: updateUrl,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.version === currentVersion) {
                        $('#version-info').html(`当前版本：${currentVersion}<br>最新版本：${response.version}<br>当前已是最新版本`);
                    } else {
                        $('#version-info').html(`当前版本：${currentVersion}<br>最新版本：${response.version}<br>有新版本哦，请参考更新内容来考虑是否更新<br>本次更新内容：<br>${response.new}<br><a class='btn btn-primary' href='${response.url}'>下载最新版本</a>`);
                    }
                },
                error: function() {
                    $('#version-info').html("请求服务器失败，请联系作者");
                }
            });
        });
    </script>
</body>
</html>