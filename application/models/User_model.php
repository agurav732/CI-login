<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $first_name
	 * @param mixed $last_name
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($first_name,$last_name, $email, $password) {
		
		$data = array(
			'first_name'   => $first_name,
			'last_name'   => $last_name,
			'email'      => $email,
			'password'   => $this->hash_password($password),
			'created_at' => date('Y-m-j H:i:s'),
		);
		
		return $this->db->insert('users', $data);
		
	}

	public function update_user($first_name,$last_name, $email,  $dept, $avatar) {
		$id = $_SESSION['user_id'];
	
		$data = array(
			'first_name'   => $first_name,
			'last_name'   => $last_name,
			'email'      => $email,
			'dept'      => $dept,
			'avatar'      => $avatar,
	
			'updated_at' => date('Y-m-j H:i:s'),
		);

		$this->db->where('id', $id);
		return $this->db->update('users', $data);
		
	}
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user($username) {
		
		$this->db->select('email');
		$this->db->from('users');
		$this->db->where('email', $username);
		$user_name = $this->db->get()->row('email');
		
		return $user_name;
		
	}

		public function resolve_user_login($username, $password) {
		
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('email', $username);
		$hash = $this->db->get()->row('password');
		
		return $this->verify_password_hash($password, $hash);
		
	}
	
	/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($username) {
		
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('email', $username);

		return $this->db->get()->row('id');
		
	}



	
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {
		
		$this->db->from('users');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
		
	}

		public function get_dept() {
		
		// $this->db->from('dept');
		
		// return $this->db->get()->row();
	$query = $this->db->query("SELECT * FROM dept where 1");

	$dept_array = array();

foreach ($query->result() as $row)
{
		
		array_push($dept_array,$row->dept_name);
		 
     
}
return $dept_array;
		
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}
	
}
