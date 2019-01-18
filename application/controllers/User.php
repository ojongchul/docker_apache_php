<?php
header('Content-Type: application/json');
class User extends CI_Controller {
	public function index()
	{
		echo 'unAuthorize Access';
	}

	public function getUserList()
	{
		$api= array(
			"result" => 1,
			"msg" => "성공"
		);
		$cont = true;
		$result = 1;
		$msg = "성공";

		$pageno = $this->input->post('pageno');
		$pagelength= $this->input->post('pagelength');

		// 페이징을 위해 offset 계산
		if($pageno > 0) {
			$offset = ($pageno -1) * $pagelength;
		} else {
			$offset = 0;
		}

		$query = $this->db->get('member_list', $pagelength, $offset);
		if ($query->num_rows() > 0)
		{
			$result = 1;
			$msg = "정상";

			$results = $query->result();
			$datas = [];
			foreach ($query->result() as $row)
			{
				$data['idx'] = $row->idx;
				$data['email'] = $row->email;
				$data['name'] = $row->name;
				$data['phone'] = $row->phone;
				$data['affiliate'] = $row->affiliate;
				$datas[] = $data;
			}
			$api['data'] = $datas; // add user information
		} else {
			$result = -1;
			$msg = "데이터 출력 실패";
		}

		$api['msg'] = $msg;
		$api['result'] = $result;
		echo json_encode($api);
	}

	public function getUserInfo()
	{
		$api= array(
			"result" => 1,
			"msg" => "성공"
		);
		$cont = true;
		$result = 1;
		$msg = "성공";

		$idx= $this->input->post('idx');

		if(!injectCheck($idx)) {
			$result = -1; // validate return fail
			$cont = false; 
			$msg = "입력값 체크 실패";
		}

		if($cont) {
			$query = $this->db->get_where('member_list', array('idx' => $idx));
			if ($query->num_rows() > 0)
			{
				$results = $query->result();
				$data['email'] = $results[0]->email;
				$data['name'] = $results[0]->name;
				$data['phone'] = $results[0]->phone;
				$data['affiliate'] = $results[0]->affiliate;
				$api['data'] = $data; // add user information
			} else {
				$result = -1;
				$msg = "계정 조회 실패";
			}
		}

		$api['msg'] = $msg;
		$api['result'] = $result;
		echo json_encode($api);
	}

	public function removeAccount()
	{
		$api = array(
			"result" => 1,
			"msg" => "성공"
		);
		$cont = true;
		$result = 1;
		$msg = "성공";

		$value = $this->input->post(NULL);
		$email = $value['email'];
		$password= $value['password'];

		// check id exist
		$idcheck = json_decode($this->idcheck($email), true);
		if($idcheck['result'] === 1) { // id exists
			$cont = true; 
		} else {
			$result = -1; // id exists
			$cont = false;
			$msg = "ID 없음";
		}

		if($cont) {
			// validate value
			if(!injectCheck($email)) {
				$result = -1; // validate return fail
				$cont = false; 
				$msg = "email 입력값 체크 실패";
			}
		}

		if($cont) {
			// check password
			$pwcheck = json_decode($this->passwordcheck($email, $password), true);
			if($pwcheck['result'] === 1) { // password correct
				$cont = true; 
			} else {
				$result = -1; // id exists
				$cont = false;
				$msg = "password 미일치";
			}
		}

		if($cont) {
			// move user infomation to deleted table
			$SQL = "INSERT INTO `member_list_deleted` (email, password, regdate, name, affiliate, phone, eventagree) SELECT email, password, regdate, name, affiliate, phone, eventagree FROM `member_list` where email = '".$email."'";
			$query = $this->db->query($SQL);
			$this->db->delete('member_list', array('email' => $email));
		}
		$api['msg'] = $msg;
		$api['result'] = $result;
		echo json_encode($api);
	}

	public function editPassword()
	{
		$api= array(
			"result" => 1,
			"msg" => "성공"
		);
		$cont = true;
		$result = 1;
		$msg = "성공";

		$value = $this->input->post(NULL);
		$email = $value['email'];
		$password_old = $value['password_old'];
		$password_new = $value['password_new'];

		// validate value
		if(!injectCheck($email) || !injectCheck($password_old) || !injectCheck($password_new)) {
			$result = -1; // validate return fail
			$cont = false; 
			$msg = "email, password 입력값 체크 실패";
		}

		if($cont) {
			// check id exist
			$idcheck = json_decode($this->idcheck($email), true);
			if($idcheck['result'] === 1) { // id exists
				$cont = true; 
			} else {
				$result = -1; // id exists
				$cont = false;
				$msg = "ID 없음";
			}
		}

		if($cont) {
			// check password
			$pwcheck = json_decode($this->passwordcheck($email, $password_old), true);
			if($pwcheck['result'] === 1) { // password correct
				$cont = true; 
			} else {
				$result = -1;
				$cont = false;
				$msg = "password 미일치";
			}
		}

		if($cont) {
			$data = array(
				'password' => $password_new,
			);
			$this->db->where('email', $email);
			$this->db->update('member_list', $data);
		}

		$api['msg'] = $msg;
		$api['result'] = $result;
		echo json_encode($api);
	}

	// edit member info except password
	public function editAccount()
	{
		$api= array(
			"result" => 1,
			"msg" => "성공"
		);
		$cont = true;
		$result = 1;
		$msg = "성공";

		$value = $this->input->post(NULL);
		$email = $value['email'];
		$name  = $value['name'];
		$phone = $value['phone'];
		$password = $value['password'];

		if($cont) {
			// validate value
			if(injectCheck($email) && injectCheck($name) && injectCheck($phone)) {
			} else { 
				$result = -1; // validate return fail
				$cont = false; 
				$msg = "email, name 입력값 체크 실패";
			}
		}

		if($cont) {
			// check id exist
			$idcheck = json_decode($this->idcheck($email), true);
			if($idcheck['result'] === 1) { // id exists
				$cont = true; 
			} else {
				$result = -1; // id exists
				$cont = false;
				$msg = "ID 없음";
			}
		}


		if($cont) {
			// check password
			$pwcheck = json_decode($this->passwordcheck($email, $password), true);
			if($pwcheck['result'] === 1) { // password correct
				$cont = true; 
			} else {
				$result = -1;
				$cont = false;
				$msg = "password 미일치";
			}
		}

		if($cont) {
			$data = array(
				'name' => $name,
				'phone' => $phone,
			);
			$this->db->where('email', $email);
			$this->db->update('member_list', $data);

		}
		$api['msg'] = $msg;
		$api['result'] = $result;
		echo json_encode($api);
	}

	public function signUp()
	{
		$api= array(
			"result" => 1,
			"msg" => "성공"
		);
		$cont = true;
		$result = 1;
		$msg = "성공";

		$value = $this->input->post(NULL);
		
		if(!$value['email'] || !$value['name'] || !$value['password'] || !$value['phone']) {
			$result = -1;
			$cont = false;
			$msg = "입력값 오류";
		}

		if($cont) {
			$email = $value['email'];
			$name  = $value['name'];
			$password = $value['password'];
			$regdate = date("Y-m-d H:i:s");
			$affiliate = $value['affiliate'];
			$phone = $value['phone'];
			$event = $value['event'];

			$idcheck = json_decode($this->idcheck($email), true);
			if($idcheck['result'] === 0) { 
				$cont = true; 
			} else {
				$result = -1; // id exists
				$cont = false;
				$msg = "ID 중복";
			}

			if(injectCheck($email) && injectCheck($name) && injectCheck($affiliate) && injectCheck($phone)) {
			} else { 
				$cont = false; 
				$result = -1; // validate return fail
				$msg = "email, name, affiliate, phone 입력값 체크 실패";
			}

			if($cont) {
				$data = array(
					'email' => $email,
					'name' => $name,
					'password' => $password,
					'regdate' => $regdate,
					'affiliate' => $affiliate,
					'phone' => $phone,
					'eventagree' => $event
				);
				$this->db->insert('member_list', $data);
			}
		}

		$api['msg'] = $msg;
		$api['result'] = $result;
		echo json_encode($api);
	}

	private function idcheck($id)
	{
		$api= array(
			"result" => 1,
			"msg" => "성공"
		);
		$cont = true;
		$result = 1;
		$msg = "성공";

		if(!$id) {
			$result = -1;
			$msg = "입력값이 없음";
		}
		if(injectCheck($id)) {
			$query = $this->db->get_where('member_list', array('email' => $id));
			if ($query->num_rows() > 0)
			{
				$result = 1;
				$msg = "이미 사용중인 ID";
			} else {
				$result = 0;
				$msg = "미사용 ID";
			}
		} else {
			$cont = false;
			$result = -1;
			$msg = "입력값 체크 실패";
		}
		$api['msg'] = $msg;
		$api['result'] = $result;
		return json_encode($api);
	}

	private function passwordcheck($id, $password)
	{
		$api= array(
				"result" => 1,
				"msg" => "성공"
				);
		$cont = true;
		$result = 1;
		$msg = "성공";

		if(injectCheck($id)) { 
			$cont = true;
		} else {
			$cont = false;
			$result = -1;
			$msg = "이메일 입력값 체크 실패";
		}
		/*
		if(strlen($password) != 64) {
			$cont = false;
			$result = -1;
			$msg = "비밀번호 오류";
		}
		*/

		if($cont) {
			$query = $this->db->get_where('member_list', array('email' => $id, 'password' => $password));
			if ($query->num_rows() > 0)
			{
				$result = 1;
				$msg = "정상 비밀번호";
			} else {
				$result = -1;
				$msg = "비밀번호 확인 실패";
			}
		}
		$api['msg'] = $msg;
		$api['result'] = $result;
		return json_encode($api);
	}
}

function injectCheck($value) {
	$rtn = true;
	$value = urldecode($value);
    $chars = [ "<", ">", "\\", "'", "\""];
	for($i=0; $i<count($chars);$i++) {
		if(strpos($value, $chars[$i]) !== false) {
			$rtn = false;
			break;
		}
	}
	return $rtn;
}
?>

