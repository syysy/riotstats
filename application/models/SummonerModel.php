<?php 


class SummonerModel extends CI_Model {
    
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }
    
        public function getSummoner($name, $region) {
            $this->db->select('*');
            $this->db->where('name', $name);
            $this->db->where('region', $region);
            $this->db->from('summoner');
            $summonerInfo = $this->db->get();
            if ($this->db->affected_rows() == 0) {
                return false;
            }
			$res = $summonerInfo->result_array();
			// get the summoner's ranks
			$this->db->select('*');
			$this->db->where('id', strval($res[0]['id']).'1');
			$this->db->or_where('id', strval($res[0]['id']).'2');
			$this->db->from('rank');
			$summonerRanks = $this->db->get();
			$res2 = $summonerRanks->result_array();
            return array($res,$res2);
        }
    
        public function addSummoner($summoner) {
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
            return array($data1, array($data2, $data3));
        }

        public function updateSummoner($summoner) {
            $sql = 'CALL updateRank(?, ?, ?, ?, ?, ?, ?)';
			$q = $this->db->query($sql, array($summoner->id.'1', $summoner->soloq->queueType, $summoner->soloq->tier, $summoner->soloq->rank, $summoner->soloq->leaguePoints, $summoner->soloq->wins, $summoner->soloq->losses));
			$q = $this->db->query($sql, array($summoner->id.'2', $summoner->flex->queueType, $summoner->flex->tier, $summoner->flex->rank, $summoner->flex->leaguePoints, $summoner->flex->wins, $summoner->flex->losses));
        }
}
