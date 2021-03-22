<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class User extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('user_model');
		
	}
	
	
	public function index() {
		

		
	}
	
	/**
	 * register function.
	 * 
	 * @access public
	 * @return void
	 */
	public function register() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		// $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('first_name', 'First_name', 'required');
		$this->form_validation->set_rules('last_name', 'Last_name', 'required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/register/register', $data);
			$this->load->view('footer');
			
		} else {
			
			// set variables from the form
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->user_model->create_user($first_name,$last_name, $email, $password)) {
				
				// user creation ok
				$user_id = $this->user_model->get_user_id_from_username($email);
				$user    = $this->user_model->get_user($user_id);
				
				// set session user datas
				$_SESSION['user_id']      = (int)$user->id;
				$_SESSION['username']     = $user->email;
				$_SESSION['logged_in']    = (bool)true;
				$_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
				$_SESSION['is_admin']     = (bool)$user->is_admin;
				
					header("Location: dashboard");
				
			} else {
				
				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';
				
				// send error to the view
				$this->load->view('header');
				$this->load->view('user/register/register', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}

	public function update_user() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		// $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('first_name', 'First_name', 'required');
		$this->form_validation->set_rules('last_name', 'Last_name', 'required');
		// $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		// $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {

			// echo "1";
			
			// validation not ok, send validation errors to the view
			$user_id = $_SESSION['user_id'];
					// $data->error = 'Username Not Found. Please Signup';
		
			$user    = $this->user_model->get_user($user_id);
			$data->first_name = $user->first_name;
			$data->last_name = $user->last_name;
			$data->password = $user->password;
			$data->email = $user->email;
			$data->avatar = $user->avatar;
			$data->dept = $user->dept;
			$data->id = $user->id;
		 
			

			$this->load->view('header');
				$this->load->view('user/login/dashboard', $data);
			$this->load->view('footer');
			
		} else {
			// echo "2";

			// print_r($_POST);

					$user_id = $_SESSION['user_id'];
					// $data->error = 'Username Not Found. Please Signup';
		
			$user    = $this->user_model->get_user($user_id);
		// 	print_r($user);
		// echo	$ava = $user->avatar;
		// echo $_FILES['avatar']['name'];
			// die();
			
			// set variables from the form
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$dept = $this->input->post('dept');
			$email    = $this->input->post('email');
			
			
		
			if($_FILES['avatar']['name']!="" ) {
			$avatar= $_FILES['avatar']['name'];
			$avatar1= $_FILES['avatar']['tmp_name'];
			 move_uploaded_file($avatar1,"images/$avatar");
			}
			else{

				if($user->avatar==""){
					$avatar = "avatar.jpg";
				}
				else{
                     $avatar = $user->avatar;   

				}

				

			}
		

			 
			
			if ($this->user_model->update_user($first_name,$last_name, $email,  $dept, $avatar)) {
				// echo "3";
				// user creation ok
				// $this->load->view('header');
				// $this->load->view('user/login/dashboard', $data);
				// $this->load->view('footer');
				header("Location: dashboard");
				
			} else {
				// echo "4";
				
				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';
				
				// send error to the view
				// $this->load->view('header');
				// $this->load->view('user/register/register', $data);
				// $this->load->view('footer');
				
			}
			
		}
		
	}
		
	/**
	 * login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function login() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		// $this->form_validation->set_rules('username', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/login/login');
			$this->load->view('footer');
			
		} else {
			
			// set variables from the form
			$username = $_SESSION['user_name'];
			$password = $this->input->post('password');
			
			if ($this->user_model->resolve_user_login($username, $password)) {
				
				$user_id = $this->user_model->get_user_id_from_username($username);
				$user    = $this->user_model->get_user($user_id);
				
				// set session user datas
				$_SESSION['user_id']      = (int)$user->id;
				$_SESSION['username']     = $user->email;
				$_SESSION['logged_in']    = (bool)true;
				$_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
				$_SESSION['is_admin']     = (bool)$user->is_admin;
				
				
				
				// user login ok
				// $this->load->view('header');
				// $this->load->view('user/login/dashboard', $data);
				// $this->load->view('footer');

				header("Location: dashboard");
				
			} else {
				
				// login failed
				$data->error = 'Wrong  password.';
				
				// send error to the view
				$this->load->view('header');
				$this->load->view('user/login/login', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}

	public function check_email_id() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
          $this->form_validation->set_rules('email', 'Email', 'required');
		// $this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/login/login');
			$this->load->view('footer');
			
		} else {
			
			// set variables from the form
			$username = $this->input->post('email');
			// $password = $this->input->post('password');
			
			if ($this->user_model->resolve_user($username)) {
				
				$_SESSION['user_name']     = $username;
				
				// user login ok
				$this->load->view('header');
					$this->load->view('user/login/login1');
				$this->load->view('footer');
				
				
			} else {
				
				// login failed
				$data->error = 'Username Not Found. Please Signup';
				$data->username = $this->input->post('email');
				// send error to the view
				$this->load->view('header');
				$this->load->view('user/register/register', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}

	public function dept() {
		$data = new stdClass();
		$dept = $this->user_model->get_dept();
		echo json_encode($dept);
    }

	public function dashboard() {
            if(!isset($_SESSION['user_id'])){
				header("Location: login");
			}
			$data = new stdClass();
			$user_id = $_SESSION['user_id'];

		
					// $data->error = 'Username Not Found. Please Signup';
		
			$user    = $this->user_model->get_user($user_id);
			$data->first_name = $user->first_name;
			$data->last_name = $user->last_name;
			$data->password = $user->password;
			$data->email = $user->email;
			$data->id = $user->id;
			$data->avatar = $user->avatar;
			$data->dept = $user->dept;
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
			$this->load->view('header');
				$this->load->view('user/login/dashboard',$data);
				$this->load->view('footer');

	}
	
	/**
	 * logout function.
	 * 
	 * @access public
	 * @return void
	 */
	public function logout() {
		
		// create the data object
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			
			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			// user logout ok
			$this->load->view('header');
			$this->load->view('user/logout/logout_success', $data);
			$this->load->view('footer');
			
		} else {
			
			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect('/');
			
		}
		
	}
	
}
