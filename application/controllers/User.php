<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class User extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->library(array('session'));
            $this->load->helper(array('url'));
            $this->load->model('user_model');
        }

        public function index() {

        }

        public function register() {
            $this->load->view('user/register/register');
        }

        public function register_user() {
            $this->load->helper('form');
            
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if($this->user_model->create_user($username,$email,$password)){
                echo "Insert user succesfully";
            }else{
                echo "Insert user failed";
            }
        }

        public function view_login(){
            $this->load->view('user/login/login'); //ini sama kayak kita ngopy file login.html kedalam sini, makanya di action form bisa langsun manggil nama fungsi yang ada di dalam sini
        }

        public function login_user(){
             $this->load->helper('form');

            $email = $this->input->post('email'); // "input" ini untuk ngambil inputan dari view
            $password = $this->input->post('password');

            if($this->user_model->resolve_user_login($email,$password)){
                $user_id = $this->user_model->get_id_from_username($email,$password);
                $user = $this->user_model->getUser($user_id);

                $_SESSION['user_id'] = (int) $user_id;
                $_SESSION['username'] = (string) $user->name;
                $_SESSION['email'] = (string) $user->email;

                echo "Login Success";
            }else{
                echo "Login failed";
            }
        }
    }
?>