<?php
/*
* (c) Suresh Kumar 
*
* Suresh Kumar<skamrani2002@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

class Jira{

	private $app_url;
	private $username;
	private $password;
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
			$this->setAppUrl($settings['app_url']);
			$this->setUsername($settings['username']);
			$this->setPassword($settings['password']);
			
		} 
		
		}
		
		/*Setter*/
		public function setAppUrl($app_url){
			$this->app_url = $app_url;
			return $this;
		}
		public function setUsername($username){
			$this->username = $username;
			return $this;
		}
		public function setPassword($password){
			$this->password = $password;
			return $this;
		}
		
		
		/***Getters*****/
		public function getAppUrl(){
			return $this->app_url;
		}
		public function getUsername(){
			return $this->username;
		}
		public function getPassword(){
			return $this->password;
		}
		public function getCredential(){
			return $this->getUsername().":".$this->getPassword();
		}
		
		
		
		/*Create on JIRA via API*/
		public function createProject($data){
			return $this->request('project',$data);
		}
		public function createIssue($data){
			return $this->request('issue',$data);
		}
		public function addComments($data,$issue_id){
			return $this->request("issue/$issue_id/comment",$data);
		}
		/*Get json of project write it in file */
		
		public function request($get_item,$data){
		$jdata = json_encode($data);
			try {
				$ch = curl_init($this->getAppUrl().'/rest/api/latest/'.$get_item);
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
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jdata);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
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