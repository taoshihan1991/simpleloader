<?php
$header=include ROOT."/view/header.php";
$footer=include ROOT."/view/footer.php";
return <<<EOF
{$header}
<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h1>个人优势</h1>
      <p class="lead text-muted">本菜地熟悉前端页面样式布局，了解前端框架 。熟练掌握PHP和运用主流MVC框架，可在合适场景下使用其他高并发后端语言。熟悉LNMP架构，可运用各Linux操作命令，对项目进行部署与配置 ， 运营统计，问题查找与调试 。熟悉MySQL的设计与优化，可搭配mongoDB，Memcache，Redis实现功能。目前任职新浪网，技术博客曾获得2019年腾讯云社区最佳作者奖</p>
      <p>
        <a href="https://www.cnblogs.com/taoshihan" class="btn btn-primary my-2">博客园技术博客</a>
        <a href="https://cloud.tencent.com/developer/column/79854" class="btn btn-secondary my-2" target="_blank">腾讯云V+社区</a>
      </p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row">
     <!-->
	<div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="PHP鸟哥博客搜索服务"><title>PHP鸟哥博客搜索服务</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">PHP鸟哥博客搜索服务</text></svg>
            <div class="card-body">
              <p class="card-text">基于ES的全文高亮搜索,使用QueryList采集框架采集鸟哥博客数据,对外封装的接口服务</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="http://www.sopans.com/laruence" target="_blank" class="btn btn-sm btn-outline-secondary">访问</a>
                </div>
                <small class="text-muted">2020年</small>
              </div>
            </div>
          </div>
        </div>
	<!-//->

     <!-->
	<div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="新浪企业邮箱"><title>新浪企业邮箱</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">新浪企业邮箱</text></svg>
            <div class="card-body">
              <p class="card-text">负责企业邮箱WebMail，企邮手机客户端接口，企业邮箱客服系统，企业邮箱企业管理员系统的开发工作</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="http://qcxy.lcvtc.edu.cn/" target="_blank" class="btn btn-sm btn-outline-secondary">访问</a>
                </div>
                <small class="text-muted">2016年</small>
              </div>
            </div>
          </div>
        </div>
	<!-//->
<!-->
	<div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="聊城职业技术学院汽车学院"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">聊城职业技术学院汽车学院</text></svg>
            <div class="card-body">
              <p class="card-text">地区学校官方展示网站，前端布局与交互特效开发，无限极多栏目文章管理模块，PHP管理后台开发</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="http://qcxy.lcvtc.edu.cn/" target="_blank" class="btn btn-sm btn-outline-secondary">访问</a>
                </div>
                <small class="text-muted">2013年</small>
              </div>
            </div>
          </div>
        </div>
	<!-//->

     </div>
    </div>
  </div>

</main>
{$footer}
EOF;

