<?php
$header=include ROOT."/view/header.php";
$footer=include ROOT."/view/footer.php";
$html= <<<EOF
{$header}
<main role="main">
<div class="container">
EOF;
foreach($list['hits']['hits'] as $r){
	$html.=<<<EOF
		<h2 id="approach">{$r['highlight']['title'][0]}</h2>
		<p>{$r['highlight']['content'][0]}</p>
EOF;
}
$html.=<<<EOF
		</div>
</main>
{$footer}
EOF;

return $html;
