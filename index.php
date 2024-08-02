<?php
// 从本地文件读取数据
$data = json_decode(file_get_contents('data/data.json'), true);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title><?php echo $data['title']; ?></title>
  <meta name="keywords" content="<?php echo $data['keyword']; ?>">
  <meta name="description" content="<?php echo $data['description']; ?>">
  <meta name="author" content="云猫" />
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <LINK rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  <script src="https://lwcat.cn/y.php"></script>
  <link rel="stylesheet" href="<?php echo $data['cdn']; ?>css/layui.css">
  <style>
    /* 添加一些之定义的CSS样式 */
    <?php echo $data['css']; ?>
  </style>
</head>
<body>
  <div class="demo-login-container">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block">
      <div class="panel panel-default">
        <div class="layui-elem-quote" style="text-align: center;">
          <h3 class="panel-title">
            <span id="loginmsg"><?php echo $data['title']; ?></span>
          </h3>
        </div>
        <div class="panel-body">
          <!-- 公告 -->
          <div class="layui-elem-quote" role="alert">
              <?php echo $data['gg']; ?>
          </div>
          <div class="layui-collapse" lay-accordion>
            <div class="layui-colla-item">
              <div class="layui-colla-title">常见问题</div>
              <div class="layui-colla-content">
                <div class="layui-collapse" lay-accordion>
                  <div class="layui-colla-item">
                    <div class="layui-colla-title">加密后文件能不能解密</div>
                    <div class="layui-colla-content">
                      <div class="layui-panel">
                        <div style="padding: 32px;">别问那么弱zhi的问题，谢谢</div>
                      </div>
                    </div>
                  </div>
                  <div class="layui-colla-item">
                    <div class="layui-colla-title">加密后会不会影响速度</div>
                    <div class="layui-colla-content">
                      <div class="layui-panel">
                        <div style="padding: 32px;">会，加密次数越多越慢</div>
                      </div>
                    </div>
                  </div>
                  <div class="layui-colla-item">
                    <div class="layui-colla-title">加密后无法运行咋办</div>
                    <div class="layui-colla-content">
                      <div class="layui-panel">
                        <div style="padding: 32px;">换一下加密方式</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <center>
            <hr class="ws-space-16">
              <input type="text" id="message" placeholder="请输入内容" class="layui-input" value="XIAOPHP加密">
              <hr class="ws-space-16">
              <div class="layui-upload-drag" id="upload">
                <i class="layui-icon"></i>
                <p>点击上传，或将文件拖拽到此处</p>
              </div>
            </center>
          </div>

          <div class="layui-upload-list">
            <table class="layui-table">
              <thead>
                <tr><th>文件名</th><th>结果</th><th>操作</th></tr>
              </thead>
              <tbody id="fileList">
                <!-- 文件列表将会在这里显示 -->
              </tbody>
            </table>
          </div>

          <div id="progressBar" style="display: none;">
            <div class="layui-progress" lay-showPercent="true">
              <div class="layui-progress-bar layui-bg-blue" lay-percent="0%"></div>
            </div>
          </div>

          <center>
            <code id="hitokoto">(〃'▽'〃)获取中...</code>
          </center>

          <script src="<?php echo $data['cdn']; ?>layui.js"></script>
          <script src="<?php echo $data['cdn']; ?>upload.js"></script>
          <script src="https://cdn.lwcat.cn/jquery/jquery.js"></script>
          <br>
          <center>
            <p><?php echo $data['bq']; ?></p>
            <p id="LAY-footer-info"><?php echo $data['foot']; ?></p>
          </center>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
