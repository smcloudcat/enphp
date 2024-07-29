layui.use(['upload', 'element'], function(){
  var upload = layui.upload;
  var element = layui.element;
  var uploadInst = upload.render({
    elem: '#upload',
    url: 'api.php',
    accept: 'file',
    exts: 'php',
    before: function(obj){
      $('#progressBar').show();
    },
    progress: function(n, elem){
      element.progress('progressBar', n + '%');
    },
    done: function(res){
      console.log(res);
      $('#fileList').append('<tr><td>'+res.filename+'</td><td>'+res.result+'</td><td><a href="'+res.url+'" target="_blank">下载</a></td></tr>');
      $('#progressBar').hide();
    },
    error: function(){
      $('#progressBar').hide();
    },
    data: {
      xiaophp: function() {
        return $('#message').val();
      }
    }
  });
});