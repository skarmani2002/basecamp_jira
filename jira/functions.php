<?php
/*
* (c) Suresh Kumar 
*
* Suresh Kumar<skamrani2002@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
//include "Jira.php";
/*Debug function*/
function dd($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

// Create Project
function create_project($jira){
//read json file
$project_read =file_get_contents("../project_files/projects.json");
$project_json = json_decode($project_read);
$create_arr = array();
$count=1;
$append_arr = array();
// First Create key of project in existing json 
	foreach($project_json as $key=>$value){
			$append_arr['AD'.$count]['key']=  'AD'.$count;
			$append_arr['AD'.$count]['id']=  $value->id;
			$append_arr['AD'.$count]['name']=  $value->name;
			$append_arr['AD'.$count]['description']=  $value->description;
			$append_arr['AD'.$count]['archived']=  $value->archived;
			$append_arr['AD'.$count]['is_client_project']=  $value->is_client_project;
			$append_arr['AD'.$count]['created_at']=  $value->created_at;
			$append_arr['AD'.$count]['updated_at']=  $value->updated_at;
			$append_arr['AD'.$count]['trashed']=  $value->trashed;
			$append_arr['AD'.$count]['color']=  $value->color;
			$append_arr['AD'.$count]['draft']=  $value->draft;
			$append_arr['AD'.$count]['template']=  $value->template;
			$append_arr['AD'.$count]['last_event_at']=  $value->last_event_at;
			$append_arr['AD'.$count]['starred']=  $value->starred;
			$append_arr['AD'.$count]['url']=  $value->url;
			$append_arr['AD'.$count]['app_url']=  $value->app_url;
			
			$count++;
	}
	
	//$newJsonString = json_encode($append_arr);
	//file_put_contents('../project_files/projects.json', $newJsonString);

	foreach($project_json as $key=>$value){
			dd($value);
			//$create_arr['id']=$value->id;
			$create_arr['key']=$value->key;
			$create_arr['name']=$value->name;
			$create_arr['projectTypeKey']='business';
			$create_arr['description']=$value->description;
			$create_arr['url']=$value->url;
			$create_arr['lead']="admin";
			print_r($jira->createProject($create_arr));
			
			sleep(1);
			//return $create_arr;
	}
}

//Read json file of tods
function create_issues($jira){
	$project_read =file_get_contents("../project_files/projects.json");
	$project_json = json_decode($project_read);
	foreach($project_json as $key=>$value){
		$issue_read =file_get_contents("../project_files/finaltodo_$value->id.json");
		$project_json = json_decode($issue_read);
		
		$create_issue_array = array();
		foreach($project_json as $key=>$values){
		 
				$create_issue_array = array('fields' => 
						array('project' => array('key' => $value->key),
							'summary' => $values->content,
							//'description' => $values->todolist->description,
							'issuetype' => array('name' => 'Task'),
							)
					);
				$res = $jira->createIssue($create_issue_array);
				if($res){
					$result = json_decode($res);
					foreach($values->comments as $mycomment){
						print_r($jira->addComments(array('body'=>$mycomment->content),$result->key));
						
					}
				}
				sleep(1);
		}
	}
	
}
function getProjectKeyBaseId($id=null){
	$project_read =file_get_contents("../project_files/projects.json");
	$project_json = json_decode($project_read);
	foreach($project_json as $key=>$value){
			if($value->id==$id){
				return $value->key;
			}
	}
}
?>