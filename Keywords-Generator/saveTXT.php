<?php
/**
 * 接收js提交过来的数据，保存在TXT中，注意该方法无法去重
 * 时间：2018-8-31
 **/
if(isset($_POST['Keywords'])&&trim($_POST['Keywords'])!=''){
  if(file_exists('keywords.txt')) $str = file_get_contents('keywords.txt') else $str = '';
  $str .= "\r\n".$_POST['keywords'];
  file_put_contents('keywords.txt',$str);
}
?>
