<?php
/**
 * 用于接收js文件发送过来的数据，保存到数据库，可以去除重复数据
 * 时间：2018-8-31
 **/
if(isset($_POST['Keywords'])&&trim($_POST['Keywords'])!=''){
  if(!file_exists("keywords.db3")){
    $db=new SQLite3("keywords.db3",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
    $db->exec("CREATE TABLE IF NOT EXISTS keywords (keywords varchar(256),tag varchar(256),querykeyword varchar(256),language varchar(256),posttime INTEGER)");
    $db->exec("create index if not exists indextime on keywords (posttime desc)");
    $db->exec("create UNIQUE index if not exists indexkeywords on keywords (keywords)");
    $db->close();
  }
  $db=new SQLite3("keywords.db3",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
  $title=$db->escapeString($_POST['Keywords']);
  $querykeyword = $db->escapeString($_POST['Searchby']);
  $language = $db->escapeString($_POST['Language']);
  $tag=getTags($title);
  $sql="insert into keywords values ('{$title}','{$tag}','{$querykeyword}','{$language}',".time().")";
  $db->exec($sql);
  $db->close();
}
/**按空格区分的语种，比如英文/俄语等
 * @param unknown_type $title
 * @return string
**/
function getTags($title){
	$tag="";
	$tags=explode(" ",$title);
	foreach($tags as $t){
		$t=trim($t);
		if($t)$tag.=",".$t;
	}
	if($tag)$tag=substr($tag,1);//*/
	return $tag;
}
?>
