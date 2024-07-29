<?php
/**
 小猫咪文件管理器系统
 BY：云猫
 **/
error_reporting(0);
session_start();
$folder = "../enphp";

function scanFiles($dir) {
    $files = [];
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            $files = array_merge($files, scanFiles($path));
        } else {
            $files[] = $path;
        }
    }
    return $files;
}

// 修改文件显示顺序
function sortFilesByTime($a, $b) {
    return filemtime($b) - filemtime($a);
}

$files = scanFiles($folder);
usort($files, 'sortFilesByTime');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
} else {
    if (isset($_GET['delete'])) {
        $filename = $_GET['delete'];
        $filepath = $filename;
        if (!isset($_GET['confirmed'])) {
            if (file_exists($filepath) && !is_dir($filepath)) {
                echo '<script>
                        var confirmed = confirm("确定要删除吗？");
                        if (confirmed) {
                            window.location.href="?delete=' . $filename . '&confirmed=1";
                        }
                      </script>';
            } else if (is_dir($filepath)) {
                echo '<script>
                        var confirmed = confirm("确定要删除整个文件夹吗？");
                        if (confirmed) {
                            window.location.href="?delete=' . $filename . '&confirmed=1";
                        }
                      </script>';
            }
            exit();
        }
        if (file_exists($filepath) && !is_dir($filepath)) {
            unlink($filepath);
            echo '<script type="text/javascript">alert("删除成功啦～刷新页面即可");</script>';
        } else if (is_dir($filepath)) {
            deleteDirectory($filepath);
            echo '<script type="text/javascript">alert("删除成功啦～刷新页面即可");</script>';
        }
    }
}

function deleteDirectory($dir) {
    if (!file_exists($dir) || !is_dir($dir)) {
        return false;
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (is_dir($dir . '/' . $item)) {
            deleteDirectory($dir . '/' . $item);
        } else {
            unlink($dir . '/' . $item);
        }
    }
    rmdir($dir);
    return true;
}
?>
<?php $data = json_decode(file_get_contents('../data/data.json'), true);?>
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
                <a href="index.php">小猫咪PHP加密系统后台</a>
            </div>
            <div class="login-header">
                <a href="set.php">基本设置</a>&nbsp;&nbsp;&nbsp;
                <a href="change.php">修改密码</a>
            </div>
            <p><center><span style="color: red;">文件删除将不能再恢复，请慎重操作</span></center></p>
            <p><center>一键清除接口：http://域名/delete.php?username=账号&password=密码</center></p>
            <br>
            <p><center><a class="layui-btn layui-btn-danger" href='delete.php'>删除全部文件</a></center></p>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>文件路径</th>
                        <th>下载</th>
                        <th>删除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['admin'])) {
                        foreach ($files as $file) {
                            echo '<tr>';
                            echo '<td>' . $file . '</td>';
                            echo '<td><a class="layui-btn layui-btn-primary" href="'. $file . '" target="_blank">下载</a></td>';
                            echo '<td><a class="layui-btn layui-btn-danger" href="?delete=' . $file . '">删除</a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </form>
    <script src="<?php echo $data['cdn']; ?>layui.js"></script>
</body>
</html>