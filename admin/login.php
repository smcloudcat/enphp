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
        <a href="index.php"> 小猫咪PHP加密系统后台 </a>
      </div>
            <div class="layui-form-item">
                <div class="layui-input-wrap">
                    <div class="layui-input-prefix">
                        <i class="layui-icon layui-icon-username"></i>
                    </div>
                    <input type="text" name="username" value="" lay-verify="required" placeholder="用户名" lay-reqtext="请填写用户名" autocomplete="off" class="layui-input" lay-affix="clear">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-wrap">
                    <div class="layui-input-prefix">
                        <i class="layui-icon layui-icon-password"></i>
                    </div>
                    <input type="password" name="password" value="" lay-verify="required" placeholder="密码" lay-reqtext="请填写密码" autocomplete="off" class="layui-input" lay-affix="eye">
                </div>
            </div>
            <div class="layui-form-item">
                <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
            </div>
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="login">登录</button>
                

                
            </div>
        </div>
    </form>

<script src="<?php echo $data['cdn']; ?>layui.js"></script>
<script>

    layui.use('form', function(){
        var form = layui.form;


        form.on('submit(login)', function(data){
            
            $.ajax({
                url: 'ajax.php?act=login', 
                type: 'POST',
                data: data.field, 
                success: function(res){
                    if(res === "1"){
                        // 登录成功
                        layer.msg("登录成功", {icon: 1});
                        setTimeout(function() {
                    window.location.href = "index.php";
                    }, 1500); 
                    } else {
                        layer.msg("登录失败", {icon: 2});
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