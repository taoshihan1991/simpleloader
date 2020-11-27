<?php
return <<<EOF
<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#">返回顶部</a>
    </p>
    <p>基于NGINX+PHP高性能框架SWOOLE HTTP SERVER+SEBSOCKET运行</p>
	<div id="memInfo">
    <p>内存:{$sysinfo[0]}</p>
    <p>{$sysinfo[1]}</p>
	</div>
	<p id="uptime"></p>
    <p>最简路由框架 <a href="https://github.com/taoshihan1991/simpleloader" target="_blank">SimpleLoader</a>，power by <a href="https://www.cnblogs.com/taoshihan" target="_blank">陶士涵的菜地</a></p>
  </div>
</footer>

<script>
    var GOFLY_URL="https://gofly.sopans.com";
    var GOFLY_KEFU_ID="kefu2";
    var GOFLY_BTN_TEXT="与我交流 Chat with me";
</script>
<script src="https://gofly.sopans.com/static/js/gofly-front.js"></script>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script type="text/javascript">
            if ("WebSocket" in window){
               var ws = new WebSocket("ws://115.159.28.111:9505/sysinfo");
               ws.onopen = function(){
			setInterval(function(){
				ws.send("heart beat");
			},6000);
               };
                
               ws.onmessage = function (e) { 
			var data=JSON.parse(e.data);
			console.log(data);
			var html="<p>内存:"+data[0]+"</p><p>"+data[1]+"</p>";
			$("#memInfo").html(html);
               };
                
               ws.onclose = function(){ 
               };
	      var ws1 = new WebSocket("ws://115.159.28.111:9505/uptime");
               ws1.onopen = function(){
			setInterval(function(){
				ws1.send("heart beat");
			},1000);
               };
                
               ws1.onmessage = function (e) { 
			var data=JSON.parse(e.data);
			console.log(data);
			var html="运行:"+data[0];
			$("#uptime").html(html);
               };
                
               ws1.onclose = function(){ 
               };

            }
      </script>
</html>

EOF;

