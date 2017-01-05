<?php
ini_set('max_execution_time', 500);
include "Jira.php";
include "functions.php";
$auth = array(
	"app_url"  				=> "https://abc.atlassian.net",
	"username"   			=> "abc@gmail.com",
	"password"   			=> "****",
);

$jira = new Jira($auth);
//$create_project = create_project($jira);

$create_issues = create_issues($jira);


//dd($create_project);
//print_r($jira->createProject($create_project));

$new_issue = array(
	'fields' => array(
		'project' => array('name' => 'Admin Section Rebuilding'),
		'summary' => 'Test4 via REST',
		'description' => 'Description of issue goes here.',
		'issuetype' => array('name' => 'Task'),
	)
);
//print_r($jira->createIssue($new_issue));

// Create New Prjoect 


/*
function create_issue($issue) {
	return post_to('issue', $issue);
}

function post_to($resource, $data) {
	$jdata = json_encode($data);
	$ch = curl_init();
		curl_setopt_array($ch, array(
		CURLOPT_POST => 1,
		CURLOPT_URL => JIRA_URL . '/rest/api/latest/' . $resource,
		CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
		CURLOPT_POSTFIELDS => $jdata,
		CURLOPT_SSL_VERIFYPEER=>false,
		CURLOPT_HTTPHEADER => array('Content-type: application/json'),
		CURLOPT_RETURNTRANSFER => true
	));
	
	$result = curl_exec($ch);
	curl_close($ch);
	return json_decode($result);
}

function create_issue($issue) {
	return post_to('issue', $issue);
}
function add_comment($issue) {
	return post_to('issue/AD-12/comment', $issue);
}

/*$new_issue = array(
	'fields' => array(
		'project' => array('key' => 'AD'),
		'summary' => 'Test2 via REST',
		'description' => 'Description of issue goes here.',
		'issuetype' => array('name' => 'Bug'),
	)
);*/
//$new_comment =array('body'=>"This is test comment of task");

//$result = add_comment($new_comment);
//$result = create_issue($new_issue);
//var_dump($result);

/*if (property_exists($result, 'errors')) {
	echo "Error(s) creating issue:\n";
	var_dump($result);
} else {
	echo "New issue created at " . JIRA_URL ."/browse/{$result->key}\n";
}*/
//namespace JiraApi;
/*include("src/JiraApi/Jira.php");
$config = array('username'=>'suresh.kumar@centricsource.com','password'=>'amrani87','host'=>'vegatech.atlassian.net');

$issue = new Jira($config);
/*$query->project = 'AD';
$query->summary = 'REST EXAMPLE';
$query->description = 'Creating an issue via REST API';
$query->issuetype = 'Bug';
*/
/*$data = array(
 
'fields' => array('project' => array('key' => 'AD',),
			'summary' => 'This is summary',
			'description' => 'This is description',
			"issuetype" => array(	"self" => "xxxx",
									"id" => "xxxx",
									"description" => "xxxxx",
									"iconUrl" => "xxxxx",
									"name" => "xxxx",
									"subtask" => false),
			),
	);

$array = $issue->createIssue($data);
$response = json_decode($array);
print_r($response);
*/
?>