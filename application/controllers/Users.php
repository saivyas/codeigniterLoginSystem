<?php 
 
class Users extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('model_users');
	}

	public function register()
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|is_unique[users.username]'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|matches[passwordAgain]'
			),
			array(
				'field' => 'passwordAgain',
				'label' => 'Password Again',
				'rules' => 'required'
			),
			array(
				'field' => 'fullName',
				'label' => 'Name',
				'rules' => 'required'
			),
			array(
				'field' => 'contact',
				'label' => 'Contact',
				'rules' => 'required|integer'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_message('is_unique', 'The {field} already exists');
		$this->form_validation->set_message('integer', 'The {field} must be number');		
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if($this->form_validation->run() === true) {

			$this->model_users->register();

			$validator['success'] = true;
			$validator['messages'] = 'Successfully Registered';
		}
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($validator);

	}

	public function login()
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|callback_validate_username'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);		
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if($this->form_validation->run() === true) {

			$login = $this->model_users->login();

			if($login) {

				$this->load->library('session');

				$newdata = array(
	        'user_id'  => $login,	        
	        'logged_in' => TRUE
				);

				$this->session->set_userdata($newdata);

				$validator['success'] = true;
				$validator['messages'] = 'index.php/dashboard';					
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = 'Incorrect username/password combination';	
			} // /else
		} 
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($validator);

	}

	public function validate_username()
	{
		$username = $this->model_users->validate_username();

		if($username === true) {
			return true;
		} 
		else {
			$this->form_validation->set_message('validate_username', 'The {field} does not exists');
			return false;
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		header('location: ../../');
	}

	public function update() {
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|callback_username_exists'
			),
			array(
				'field' => 'fullName',
				'label' => 'Name',
				'rules' => 'required'
			),
			array(
				'field' => 'contact',
				'label' => 'Contact',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);		
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if($this->form_validation->run() === true) {
			$this->load->library('session');
			$userId = $this->session->userdata('user_id');

			$update = $this->model_users->update($userId);

			if($update) {				

				$validator['success'] = true;
				$validator['messages'] = 'Successfully Updated';					
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = 'Incorrect username/password combination';	
			} // /else
		} 
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($validator);

	}

	public function username_exists()
	{
		$this->load->library('session');
		$userId = $this->session->userdata('user_id');

		$username_exists = $this->model_users->usernameExists($userId);

		if($username_exists === false) {
			return true;
		} 
		else {
			$this->form_validation->set_message('username_exists', 'The {field} value already exists');
			return false;
		}

	}

	public function changepassword()
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'currentPassword',
				'label' => 'Current Password',
				'rules' => 'required|callback_validCurrentPassword'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|matches[passwordAgain]'
			),
			array(
				'field' => 'passwordAgain',
				'label' => 'Password Again',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);		
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if($this->form_validation->run() === true) {
			$this->load->library('session');
			$userId = $this->session->userdata('user_id');

			$changepassword = $this->model_users->changepassword($userId);

			if($changepassword) {				
				$validator['success'] = true;
				$validator['messages'] = 'Successfully Updated';					
			}			
		} 
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($validator);
	}

	public function validCurrentPassword()
	{
		$this->load->library('session');
		$userId = $this->session->userdata('user_id');

		$password_exists = $this->model_users->validCurrentPassword($userId);

		if($password_exists === true) {
			return true;
		} 
		else {
			$this->form_validation->set_message('validCurrentPassword', 'The {field} value is invalid');
			return false;
		}

	}

	

}