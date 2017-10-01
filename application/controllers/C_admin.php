<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

class C_admin extends CI_Controller {

	function __construct()
  {
    parent::__construct();
		 $this->load->model('M_admin');
		 $this->load->model('M_mataKuliah');
		 $this->load->helper('url_helper');
  }

	public function index()
	{

		if(!isset($_SESSION['username'])){
          redirect('admin/login');
        }
				else {

				$data['title'] = "Manajemen Posting - Admin";
        $array1 = $this->M_mataKuliah->getMataKuliah();
				$array2 = $this->M_dosen->getDosen();
        $data['matkul'] = $array1;
				$data['dosen'] = $array2;

		$this->load->view('admin/templates/header',$data);
		$this->load->view('admin/index',$data);
		$this->load->view('admin/templates/footer');
	}
	}

	public function logout(){
		session_destroy();
		redirect('admin/login');
	}

	public function login(){
		$this->load->helper('form');
    $this->load->library('form_validation');

		$data['title'] = "Halaman login";

		$this->form_validation->set_rules('username', 'Username', 'required');
	  $this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == FALSE)  {

     $this->load->view('admin/login', $data);

      }
			else {
        $isLogin = $this->M_admin->login_admin_authen();
        if (!$isLogin){
          echo "Username/Password salah";
        }
				else{
					$_SESSION['username'] = $this->input->post('username');

					 redirect('/admin');
					//  echo var_dump(isset($_SESSION['username']));
				}


	}
}
}

?>
