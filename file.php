<?php 
include_once 'config.php';
if (empty($_GET['f'])) exit;
if (preg_match('/^([0-9]+)\/([0-9]+)\/([0-9]+)\/(.+)$/', $_GET['f'],$r)){
	$user_id=$r[1];
	$project_id=$r[2];
	$task_id=$r[3];
	$file_name=$r[4];
	$file_data=$db->Execute('SELECT * FROM files WHERE user_id=? AND project_id=? AND task_id=? AND file=?',array($user_id,$project_id,$task_id,$file_name))->fields;
	$file_pach=ROOT.FILES.$user_id.'/'.$project_id.'/'.$task_id.'/'.$file_data['name'];
	if ($file_data && file_exists($file_pach)){
		$filetype = filetype ( $file_pach );
		$filesize = filesize ( $file_pach ) ;
		$f = fopen ( $file_pach , 'r' ) ;
		$data = fread ( $f , $filesize ) ;	
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: ".$file_data['type']);
		//header("Content-Disposition: attachment; filename=\"".$file_name."\";");
		header("Content-Transfer-Encoding:­ binary");
		header("Content-Length: ".$filesize);
		print ( $data ) ;
		exit();
	}
}else{
	exit;
}
?>