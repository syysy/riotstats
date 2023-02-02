<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RequestModel extends CI_Model {

    private string $api_key = "RGAPI-335e34d5-3bb6-4880-8012-6fc1b1eacb54";
	

    public function __construct() {
        parent::__construct();
    }

	public function transformRegion(string $region): string {
		if (in_array($region, array("BR1", "LA1", "LA2", "NA1"))) {
			return "americas";
		} elseif (in_array($region, array("EUN1", "EUW1", "TR1", "RU"))) {
			return "europe";
		} elseif (in_array($region, array("JP1", "KR"))) {
			return "asia";
		} elseif (in_array($region, array("OC1"))){
			return "sea";
		}
		throw new ErrorException("La region n'existe pas");
	}

    private function request(string $api_url) {		
        $data = array('key1' => 'value1', 'key2' => 'value2');
		
        $options = array(
			'https' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data)
			)
		);
		
        $context  = stream_context_create($options);	
		
        try {
			$result = file_get_contents($api_url, false, $context);
			$result = json_decode($result, true);
		} catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}

        return $result;
    }

    public function getSummonerByName(string $name, string $region) {
		$name = str_replace(' ', '', $name);
		$api_url = 'https://'.$region.'.api.riotgames.com/lol/summoner/v4/summoners/by-name/'.$name.'?api_key='.$this->api_key;

        return $this->request($api_url);
    }

	public function getRankById(string $id, $region) {
		$api_url = 'https://'.$region.'.api.riotgames.com/lol/league/v4/entries/by-summoner/'.$id.'?api_key='.$this->api_key;

		return $this->request($api_url);
	}

	public function getLastGameByPuuid(string $puuid, string $region, int $nbrOfGames) {
		$region = $this->transformRegion($region);
		$api_url = 'https://'.$region.'.api.riotgames.com/lol/match/v5/matches/by-puuid/'.$puuid.'/ids?start=0&count='.strval($nbrOfGames);

		return $this->request($api_url);
	}

	public function getMatchById(string $matchId, string $region) {
		$region = $this->transformRegion($region);
		$api_url = "https://".$region.".api.riotgames.com/lol/match/v5/matches/".$matchId;

		return $this->request($api_url);
	}

}

?>