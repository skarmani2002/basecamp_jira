<?php 
ini_set('max_execution_time', 500);
include "Basecamp.php";
$auth = array(
	"app_name"  			=> "APP NAME",
	"app_contact"  			=> "abc@gmail.com",
	"basecamp_account_id"   => "122222222",
	"basecamp_username"   	=> "abc@gmail.com",
	"basecamp_password"   	=> "*****",
);
$basecamp = new Basecamp($auth);

//print_r($basecamp->getProject());
//print_r($basecamp->getTodoLists());

//print_r($basecamp->getPeoples());

//get todo things 
$project_read =file_get_contents("project_files/projects.json");
$project_json = json_decode($project_read);

$create_arr = array();

// First Create key of project in existing json 
/*foreach($project_json as $key=>$value){
	$project_id = $value->id;
	$res= $basecamp->getAllTodos($project_id);
	$basecamp->writeFile($res,"todos_$project_id.json");
	sleep(1);
}


// Get comments things 
foreach($project_json as $key=>$value){
	$project_id = $value->id;
	$res = getComments($project_id,$basecamp);
	echo "<pre>";
	print_r($res);
	echo "</pre>";
	exit();
	$basecamp->writeFile(json_encode($res),"comments_$project_id.json");
}

function getComments($project_id,$basecamp){
	 $response=array();
	for($i=1;$i<=50;$i++){
		$resp= $basecamp->getTopics($i,$project_id);
		if($resp ==false){
			break;
		}else{
		$response[] = json_decode($resp,true);
		}
	}
	return $response;
}*/
//End of Fetching comments


// Function that sum up all comments of tods in one array

foreach($project_json as $key=>$value){
	$project_id = $value->id;
	$project_read =file_get_contents("project_files/todos_$project_id.json");
	$project_json = json_decode($project_read);
	$my_array = array();
	foreach($project_json as $key=>$value){
		$my_array[] =json_decode($basecamp->getSingleTodo($project_id,$value->id),true);
	}
	$basecamp->writeFile(json_encode($my_array),"finaltodo_$project_id.json");
	sleep(1);
	
}


?>
