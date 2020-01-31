<?php
require_once('config.php');
require_once('class.task.php');

$res = NULL;
$resStr = '';

$task = new Task(SQL());

if(!isset($_REQUEST['act'])){
	
}elseif($_REQUEST['act']=='add'){
	
}elseif($_REQUEST['act']=='edit'){
	
}

# Re render List
list($tskObj, $deep)=LoopTask::generate($task->getList());

echo($tskObj->toHTML(true));
echo('Max depth: '.$depp);
?>