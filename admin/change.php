<?php
session_start();
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
           <div class="login-header"><a href="file.php">管理文件</a>&nbsp;&nbsp;&nbsp; <a href="set.php">基本设置</a>  </div>
            <div class="layui-form-item">
                <div class="layui-input-wrap">
                    <div class="layui-input-prefix">
                        <i class="layui-icon layui-icon-username"></i>
                    </div>
                    <input type="text" name="newUsername" value="" lay-verify="required" placeholder="新账号" lay-reqtext="请填写新账号" autocomplete="off" class="layui-input" lay-affix="clear">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-wrap">
                    <div class="layui-input-prefix">
                        <i class="layui-icon layui-icon-password"></i>
                    </div>
                    <input type="password" name="newPassword" value="" lay-verify="required" placeholder="新密码" lay-reqtext="请填写新密码" autocomplete="off" class="layui-input" lay-affix="eye">
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="login">修改</button>
            </div>
        </div>
    </form>

<script src="../layui/layui.js"></script>
<script>

    layui.use('form', function(){
        var form = layui.form;
        form.on('submit(login)', function(data){
            
            $.ajax({
                url: 'ajax.php?act=change', 
                type: 'POST',
                data: data.field, 
                success: function(res){
                    if(res === "1"){
                        // 登录成功
                        layer.msg("修改成功", {icon: 1});
                    } else {
                        layer.msg("登录失败", {icon: 2});
                         setTimeout(function() {
                     window.location.href = "login.php";
                    }, 1500); 
                    }
                },
                error: function(){
                    layer.msg('An error occurred while processing your request.', {icon: 2});
                }
            });
            return false; 
        });
    });
</script>
</body>
</html>