<?php
require_once './vendor/autoload.php';
initTools();
$dir ='C:/WWW/tools//tools/media/aaaa/bbbb/cccc/';
$dir ='C:/WWW/tools//tools/media/';
/*$top_menu=getDirParent($dir);
dump($top_menu);*/

$res= getPublicPath(true);
//dump($res);






die;
new \admintools\tools\tools\ToolDb();
$res =DB::query('SELECT * FROM tools_core_config where name =%s and value = %l ','test','1');
dump($res);die;
$res =toolsConfig('test1');
dump($res);








