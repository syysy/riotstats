<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH
.DIRECTORY_SEPARATOR
.'models'
.DIRECTORY_SEPARATOR."SummonerEntity.php";

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
        $this->load->model('RequestModel');
	}

	public function index(){
		$this->load->view('home');
	}

	public function summoner() {
		$name = $this->input->post('summoner');
		$region = $this->input->post('region');

		// Check if the summoner already exists	in the database
		$this->db->select('*');
		$this->db->where('name',$name);
		$this->db->from('summoner');
		$summonerInfo = $this->db->get();

		// If the summoner doesn't exist in the database, we add it
		if ($this->db->affected_rows() == 0){
			$summoner = new SummonerEntity($this->input->post('summoner'), $this->input->post('region'));
			// Add summoner to database
			$data1 = array(
				'id' => $summoner->id,
				'accountId' => $summoner->accountId,
				'profileIconId' => $summoner->profileIconId,
				'name' => $summoner->name,
				'puuid' => $summoner->puuid,
				'level' => $summoner->level,
				'region' => $summoner->region,
			);
			$this->db->insert('summoner', $data1);
			// Add summoner's ranks to database
			$data2 = array(
				'id' => ($summoner->id.'1'),
				'tier' => $summoner->soloq->tier,
				'rank' => $summoner->soloq->rank,
				'leaguePoints' => $summoner->soloq->leaguePoints,
				'wins' => $summoner->soloq->wins,
				'losses' => $summoner->soloq->losses,
				'queueType' => $summoner->soloq->queueType,
			);
			$this->db->insert('rank', $data2);
			$data3 = array(
				'id' => ($summoner->id.'2'),
				'tier' => $summoner->flex->tier,
				'rank' => $summoner->flex->rank,
				'leaguePoints' => $summoner->flex->leaguePoints,
				'wins' => $summoner->flex->wins,
				'losses' => $summoner->flex->losses,
				'queueType' => $summoner->flex->queueType,
			);
			$this->db->insert('rank', $data3);
		}
		// We transform the result of the query into an array 
		$summonerInfo = $summonerInfo->result_array();
		// if the summoner wasn't found in the database the result is empty so we have to get the summoner's info from the API -> data1 from the if statement
		if (sizeof($summonerInfo) == 0) {
			$summonerInfo = array($data1);
		}
		// We get the summoner's ranks from the database
		$this->db->select('*');
		$this->db->where('id', strval($summonerInfo[0]['id']).'1');
		$this->db->or_where('id', strval($summonerInfo[0]['id']).'2');
		$this->db->from('rank');
		$summonerRanks = $this->db->get();
		// We transform the result of the query into an array
		$summonerRanks = $summonerRanks->result_array();
		// Load all information in the view
		$this->load->view('home', array('summonerInfo' => $summonerInfo, 'summonerRanks' => $summonerRanks));
	}	

	public function guilde(){
		$this->load->view('guilde');
	}

}

?>