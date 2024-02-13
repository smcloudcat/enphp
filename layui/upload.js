layui.use(['upload', 'element'], function(){
              var upload = layui.upload;
              var element = layui.element;

              // 执行实例
              var uploadInst = upload.render({
                elem: '#upload', // 绑定元素
                url: 'api.php', // 上传接口
                accept: 'file', // 只允许上传文件类型
                exts: 'zip', // 限制文件后缀
                before: function(obj){
                  // 显示进度条
                  $('#progressBar').show();
                },
                progress: function(n, elem){
                  // 更新进度条
                  element.progress('progressBar', n + '%');
                },
                done: function(res){
                  // 上传完毕回调
                  console.log(res);
                  $('#fileList').append('<tr><td>'+res.filename+'</td><td>'+res.result+'</td><td><a href="'+res.url+'" target="_blank">下载</a></td></tr>');
                  // 隐藏进度条
                  $('#progressBar').hide();
                },
                error: function(){
                  // 请求异常回调
                  // 隐藏进度条
                  $('#progressBar').hide();
                }
              });
            });