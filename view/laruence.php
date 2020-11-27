<?php
$header=include ROOT."/view/header.php";
$footer=include ROOT."/view/footer.php";
$html= <<<EOF
{$header}
<style>
.container em{
color: #e83e8c;
       word-wrap: break-word;
       font-style: normal;
}

.container div{
	line-height:2;
}
</style>
<main role="main">
<section class="jumbotron text-center">
<div class="container">
<h1>PHP鸟哥博客搜索服务</h1>
<p class="lead text-muted">
	鸟哥的博客搜索功能不支持全文搜索，也不支持中文分词搜索，现在这个搜索服务可以解决这个问题.基于Elasticsearch的全文高亮搜索功能,数据采集自鸟哥博客,文章版权归鸟哥所有.
</p>

<form class="" action="/laruence">
<div class="row">
    <div class="col-sm-6 mb-1">
<input type="text" name="q" class="form-control mr-3" value="{$q}"/>
	</div>

    <div class="col-sm-6 text-left mb-1">
<button type="submit" class="btn btn-primary mr-1">搜索一下</button>
<a class="btn btn-secondary" href='/laruence?all'>查看全部</a>
	</div>

	<div class="col-sm-12 text-left mb-1">
	热点词：<a href="/laruence?q=PHP7">PHP7</a>
	<a href="/laruence?q=内存">内存</a>

	</div>

  </div>
<p>

</form>
</p>
</div>
</section>
<div class="container">
EOF;
foreach($list['hits']['hits'] as $r){
	$desc='';
	$contents=$r['highlight']['content'];
	foreach($contents as $c){
		$desc.=$c;
	}
	$title=isset($r['highlight']['title'][0]) ? $r['highlight']['title'][0] : $r['_source']['title'];
	$html.=<<<EOF
		<h2 class="mt-3"><a href="{$r['_source']['link']}" target="_blank">{$title}</a></h2>
		<div class="mt-2 mb-5" >{$desc}</div>
		EOF;
}
$html.=<<<EOF
</div>
</main>
{$footer}
EOF;

return $html;
