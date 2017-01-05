<?php
/*
* (c) Suresh Kumar 
*
* Suresh Kumar<skamrani2002@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

class Basecamp{

	private $app_name;
	private $app_contact;
	private $basecamp_account_id;
	private $basecamp_username;
	private $basecamp_password;
	/**
	 * Class constructor method sets authentication credentials.
	 *
	 * @access  public
	 * @param   array/string
	 * @return  null
	 */

	public function __construct($settings) {

		// If using the api key only, you'll need to use the authentication
		// setter methods after you have instantiated the class object.
		
		if(is_array($settings)){
			$this->setAppName($settings['app_name']);
			$this->setAppContact($settings['app_contact']);
			$this->setAccountId($settings['basecamp_account_id']);
			$this->setUserName($settings['basecamp_username']);
			$this->setPassword($settings['basecamp_password']);
		} 
		
		}
		
		/*Setter*/
		public function setAppName($app_name){
			$this->app_name = $app_name;
			return $this;
		}
		public function setAppContact($app_contact){
			$this->app_contact = $app_contact;
			return $this;
		}
		public function setAccountId($basecamp_account_id){
			$this->basecamp_account_id = $basecamp_account_id;
			return $this;
		}
		public function setUserName($basecamp_username){
			$this->basecamp_username = $basecamp_username;
			return $this;
		}
		public function setPassword($basecamp_password){
			$this->basecamp_password = $basecamp_password;
			return $this;
		}
		
		/***Getters*****/
		public function getAppName(){
			return $this->app_name;
		}
		public function getAppContact(){
			return $this->app_contact;
		}
		public function getAccountId(){
			return $this->basecamp_account_id;
		}
		public function getUserName(){
			return $this->basecamp_username;
		}
		public function getPassword(){
			return $this->basecamp_password;
		}
		
		public function getBasecampUrl(){
			return "https://basecamp.com/".$this->getAccountId()."/api/v1";
		}
		
		public function getCredential(){
			return $this->getUserName().":".$this->getPassword();
		}
		
		public function getHelloHeader(){
			return "User-Agent:".$this->getAppName(). "(".$this->getAppContact().")";
		}
		
		/*Get json of project write it in file */
		
		public function getProject(){
			$res = $this->request('projects.json');
			return $this->writeFile($res,'projects.json');
		}
		
		public function getTodoLists($project_id=null) {
			return $this->request("/projects/$project_id/todolists.json");
			//return $this->writeFile($res,'todos.json');
		}	
		
		public function getAllTodos($project_id=null) {
			return $res= $this->request("projects/$project_id/todos.json");
			 $res= $this->request("projects/todos.json");
			return $this->writeFile($res,'alltodo.json');
		}	
		public function getSingleTodo($project_id,$todo_id){
			return $res= $this->request("projects/$project_id/todos/$todo_id.json");
		}
		
		public function getTopics($i,$project_id){
			$res= $this->request("projects/$project_id/topics.json?page=$i");
			
			if(count(json_decode($res,1))==0) {
				return false;
			}else{
				return $res;
			}
			
			
			/*if(!empty($res)){
				return $this->writeFile($res,"topics_$i.json");
			}*/
			
		}
		public function getPeoples(){
			$res = $this->request('people.json');
			return $this->writeFile($res,'people.json');
		}
		public function getComments(){
		//https://basecamp.com/{userid}/api/v1/projects/{project_id}/messages/{msg_id}.json
			$res = $this->request("/projects/2903787/todos/200383013/comments.json");
			print_r($res);
			return $this->writeFile($res,'comments.json');
		}
		
		
		
		public function writeFile($data,$file_name){
			$fp = fopen("project_files/$file_name", 'w');
			fwrite($fp,($data));
			fclose($fp);
		}
		
		public function request($get_item){
			try {
				$ch = curl_init($this->getBasecampUrl()."/".$get_item);
				curl_setopt($ch, CURLOPT_USERPWD, $this->getCredential());
				//curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array($this->getHelloHeader()));
				$response = curl_exec($ch);
				$errno = curl_errno($ch);
				$error = curl_error($ch);
				
				curl_close($ch);
				return $response;
			} catch(Exception $e) {
				trigger_error(sprintf('Curl failed with error #%d: %s',$e->getCode(), $e->getMessage()),E_USER_ERROR);
			}
	}
	
}