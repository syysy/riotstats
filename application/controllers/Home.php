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
		$this->load->model('SummonerModel');
	}

	public function index(){
		$this->load->view('home');
	}

	public function summoner() {
		$name = $this->input->post('summoner');
		$region = $this->input->post('region');
		// Check if the summoner already exists in the database
		// on récupère les infos du summoner en deux variables
		list($summonerInfo, $summonerRanks) = $this->SummonerModel->getSummoner($name, $region);
		// If not, add it
		if ($summonerInfo == false) {
			$summoner = new SummonerEntity($name, $region);
			list($summonerInfo, $summonerRanks) = $this->SummonerModel->addSummoner($summoner);
		}
		// Load all information in the view
		$this->load->view('home', array('summonerInfo' => $summonerInfo, 'summonerRanks' => $summonerRanks));
	}	
	
	public function update($name,$region){
		$summoner = new SummonerEntity($name, $region);
		$this->SummonerModel->updateSummoner($summoner);
		$summonerInfo = array(
			'id' => $summoner->id,
			'accountId' => $summoner->accountId,
			'profileIconId' => $summoner->profileIconId,
			'name' => $summoner->name,
			'puuid' => $summoner->puuid,
			'level' => $summoner->level,
			'region' => $summoner->region,
		);
		$summonerRanks = array(
			$data2 = array(
				'id' => ($summoner->id.'1'),
				'tier' => $summoner->soloq->tier,
				'rank' => $summoner->soloq->rank,
				'leaguePoints' => $summoner->soloq->leaguePoints,
				'wins' => $summoner->soloq->wins,
				'losses' => $summoner->soloq->losses,
				'queueType' => $summoner->soloq->queueType,
			),
			$data3 = array(
				'id' => ($summoner->id.'2'),
				'tier' => $summoner->soloq->tier,
				'rank' => $summoner->soloq->rank,
				'leaguePoints' => $summoner->soloq->leaguePoints,
				'wins' => $summoner->soloq->wins,
				'losses' => $summoner->soloq->losses,
				'queueType' => $summoner->soloq->queueType,
			),
		);
		$this->load->view('home', array('summonerInfo' => array($summonerInfo), 'summonerRanks' => $summonerRanks));
	}
	public function guilde(){
		$this->load->view('guilde');
	}

}

?>