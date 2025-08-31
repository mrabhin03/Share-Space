<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Space extends CI_Controller {
	protected  $DeviceID='';
	public function userData(){
		$userID = get_cookie("UserID");

        if ($userID) {
            return $userID;
        } else {
            $newID = $this->generateRandomID(10);
            $expire = 60 * 60 * 24 * 365 * 10;
            set_cookie("UserID", $newID, $expire);
            return $newID;
        }
	}
	private function generateRandomID($length = 10) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->DeviceID=$this->userData();
	}

	public function index()
	{
		// if ($this->session->has_userdata('Code')) {
		// 	redirect('Space/Hub');
		// }
		$this->load->view('index');
	}

	public function create(){
		$Code=$data['Code']=$this->codeGenerate();
		$sesssionV = array(
			'Code' 	=> 	$Code,
			'Host' 	=> 	true,
		);
		$this->session->set_userdata($sesssionV);
		$this->db->insert('thespace', array(
			'SpaceCode' => $Code,
			'HostID'	=> $this->DeviceID
		));
		$this->db->insert('connects', array(
			'SpaceCode' => 	$Code,
			'DeviceID'	=> 	$this->DeviceID,
			'Num'		=>	0
		));
		$this->load->view('createSpace',$data);
	}

	public function join(){
		$Code = $this->input->get('Code');
		$data['Code'] = $Code;
		$data['Error']=$this->input->get('Wrong');
		$this->load->view('joinSpace',$data);
	}
	
	public function SetAll(){
		$Code = $this->input->get('Code');
		if (isset($Code)){
			redirect('Space/Hub');
		}else{
			redirect('Space');
		}
	}
	public function SetAll2(){
		$Code = $this->input->get('Code');
		if (isset($Code)){
			$dbData=$this->db->select()->from('thespace')->where('SpaceCode',$Code)->get();
			if ($dbData->num_rows()==0){
				redirect('Space/Join?Wrong=Space Not Found');
			}
			$query = $this->db->query("SELECT NOW() as server_now");
			$serverTime = $query->row()->server_now;
			$startTime = new DateTime($dbData->row()->Created_On);
			$currentTime = new DateTime($serverTime);
			$diffMinutes = ($currentTime->getTimestamp() - $startTime->getTimestamp()) / 60;

			if ($diffMinutes > 10) {
				redirect('Space/Join?Wrong=Space Time Out');
			}
			$data = array(
				'Code' => $Code,
				'Host' => false
			);
			$count=$this->db->select()->from('connects')->where('SpaceCode',$Code)->where('DeviceID', $this->DeviceID)->get()->num_rows();
			if($count==0){
				$this->db->insert('connects', array(
					'SpaceCode' => 	$Code,
					'DeviceID'	=> 	$this->DeviceID,
					'Num'		=>	$this->db->select()->from('connects')->where('SpaceCode',$Code)->get()->num_rows()
				));
			}
			$this->session->set_userdata($data);
			redirect('Space/Hub');
		}else{
			redirect('Space');
		}
	}


	public function hub(){
		$Code=0;
		if ($this->session->has_userdata('Code')) {
			$Code= $this->session->userdata('Code');
		}
		if($Code==0){
			redirect('Space/Join?Wrong=Session time out');
		}

		$dbData=$this->db->select()->from('thespace')->where('SpaceCode',$Code)->get();
		if ($dbData->num_rows()==0){
			redirect('Space/Join?Wrong=Space Not Found');
		}
		$data['HostID']=$dbData->row()->HostID;
		$data['DeviceID']=$this->DeviceID;
		$data['Code']=$Code;
		$this->load->view('hub',$data);
	}


	public function SentMessage(){
		$Msg = $this->input->post('msg');
		$Code= $this->session->userdata('Code');
		$this->db->insert('msg', array(
			'SpaceCode' => 	$Code,
			'DeviceID'	=> 	$this->DeviceID,
			'Msg'		=>	$Msg,
		));
	}


	public function getmsg() {
		$Code= $this->session->userdata('Code');
        $this->db->select('msg.*, connects.*'); 
		$this->db->from('msg');
		$this->db->join(
			'connects',
			'msg.SpaceCode = connects.SpaceCode AND msg.DeviceID = connects.DeviceID',
			'inner'
		);
		$this->db->where('msg.SpaceCode', $Code);
		$query = $this->db->get();
        $result = $query->result_array();
		header('Content-Type: application/json');
        echo json_encode($result);
    }

	public function Logout(){
		$this->session->sess_destroy();
		redirect('Space');
	}

	public function codeGenerate(){
		while(true){
			$letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4);
			$numbers = substr(str_shuffle('0123456789'), 0, 4);
			$code = str_shuffle($letters . $numbers);
			$code = substr($code, 0, 4) . '-' . substr($code, 4);

			$dbData=$this->db->select()->from('thespace')->where('SpaceCode',$code)->get();
			if ($dbData->num_rows()==0){
				return $code;
			}
		}
	}

}
