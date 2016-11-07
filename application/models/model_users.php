<?php 

class Model_Users extends CI_Model 
{
	public function register()
	{

		$salt = $this->salt();

		$password = $this->makePassword($this->input->post('password'), $salt);

		$insert_data = array(
			'username' => $this->input->post('username'),
			'password' => $password,
			'salt' => $salt,
			'name' => $this->input->post('fullName'),
			'contact' => $this->input->post('contact')
		);

		$this->db->insert('users', $insert_data);
	}

	public function salt()
	{
		return password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
	}

	public function makePassword($password = null, $salt = null)
	{
		if($password && $salt) {
			return hash('sha256', $password.$salt);
		}
	}

	public function validate_username() 
	{
		$username = $this->input->post('username');
		$sql = "SELECT * FROM users WHERE username = ?";
		$query = $this->db->query($sql, array($username));
		return ($query->num_rows() == 1) ? true: false; 
	}


	public function fetchDataByUsername($username = null) 
	{
		if($username) {
			$sql = "SELECT salt FROM users WHERE username = ?";
			$query = $this->db->query($sql, array($username));
			$result = $query->row_array();

			return ($query->num_rows() == 1) ? $result : false;
			return $result;
		}
	}

	public function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$userData = $this->fetchDataByUsername($username);

		if($userData) {
			$password = $this->makePassword($password, $userData['salt']);	

			$sql = "SELECT * FROM users WHERE username = ? AND password = ?";
			$query = $this->db->query($sql, array($username, $password));
			$result = $query->row_array();

			return ( $query->num_rows() == 1 ) ? $result['id'] : false;
		} // /if
		else {
			return false;
		} // /else
	}

	public function fetchUserData($userId = null)
	{
		if($userId) {
			$sql = "SELECT * FROM users WHERE id = ?";
			$query = $this->db->query($sql, array($userId));
			$result = $query->row_array();

			return $result;
		}
	}

	public function usernameExists($userId = null) 
	{
		if($userId) {
			$sql = "SELECT * FROM users WHERE username = ? AND id != ?";
			$query = $this->db->query($sql, array($this->input->post('username'), $userId));
			return ($query->num_rows() >= 1) ? true : false;
		}
	}

	public function getUserDataById($userId) {
		$sql = "SELECT * FROM users WHERE id = ?";
		$query = $this->db->query($sql, array($userId));
		return $query->row_array();
	}

	public function validCurrentPassword($userId = null) 
	{
		if($userId) {

			$getUserDataById = $this->getUserDataById($userId);
			$salt = $getUserDataById['salt'];
			$currentPassword = $this->makePassword($this->input->post('currentPassword'), $salt);

			return ($currentPassword == $getUserDataById['password']) ? true : false;
		}
	}

	public function update($userId) 
	{
		if($userId) {
			$update_data = array(
				'username' => $this->input->post('username'),
				'name' => $this->input->post('fullName'),
				'contact' => $this->input->post('contact'),
			);

			$this->db->where('id', $userId);
			$query = $this->db->update('users', $update_data);

			return ($query === true) ? true : false;
		}
	}

	public function changepassword($userId) 
	{	
		$salt = $this->salt();

		$password = $this->makePassword($this->input->post('password'), $salt);

		$update_data = array(
			'password' => $password,
			'salt' => $salt
		);

		$this->db->where('id', $userId);
		$query = $this->db->update('users', $update_data);
		return ($query === true) ? true : false;
	}

}