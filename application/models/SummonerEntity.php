<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH
.DIRECTORY_SEPARATOR
.'models'
.DIRECTORY_SEPARATOR."RankEntity.php";

class SummonerEntity {

    // infos du compte
    public string $accountId;
    public int $profileIconId;
    public string $name;
    public string $id;
    public string $puuid;
    public int $level;
    public string $region;

    // ranks
    public RankEntity $soloq;
    public RankEntity $flex;


    public function __construct(string $name, string $region) {
        $requestModel = new RequestModel();
  
        $data = $requestModel->getSummonerByName($name, $region);
        
        // summoner's informations
        $this->accountId = $data['accountId'];
        $this->profileIconId = $data['profileIconId'];
        $this->name = $data['name'];
        $this->id = $data['id'];
        $this->puuid = $data['puuid'];
        $this->level = $data['summonerLevel'];
        $this->region = $region;

        // summoner's ranks
        $data = $requestModel->getRankById($this->id, $this->region);
        foreach ($data as $rank) {
            $rankBis = new RankEntity(
                $rank["tier"],
                $rank["rank"],
                $rank["leaguePoints"],
                $rank["wins"],
                $rank["losses"],
                $rank["queueType"]
            );
            if ($rank["queueType"] == "RANKED_SOLO_5x5") {
                $this->soloq = $rankBis;
            } elseif ($rank["queueType"] == "RANKED_FLEX_SR") {
                $this->flex = $rankBis;
            }
        }
        
        if (!isset($this->soloq)) {
            $this->soloq = new RankEntity("UNRANKED", "", 0, 0, 0, "RANKED_SOLO_5x5");
        }
        if (!isset($this->flex)) {
            $this->flex = new RankEntity("UNRANKED", "", 0, 0, 0, "RANKED_FLEX_SR");
        }
    }

    public function getLastGames(int $nbrOfGames) {
        $requestModel = new RequestModel();
        $gamesId = $requestModel->getLastGames($this->puuid, $this->region, $nbrOfGames);
        
        $games = array();
        foreach ($gamesId as $gameId) {
            $gamedata = $requestModel->getMatchById($gameId);

            $bansBlue = array();
            $bansRed = array();

            foreach ($gamedata["info"]["teams"][0]["bans"] as $data) {
                $bansBlue->append($data["championId"]);
            }
            foreach ($gamedata["info"]["teams"][1]["bans"] as $data) {
                $bansRed->append($data["championId"]);
            }

            $stringBansBlue = implode(", ", $bansBlue);
            $stringBansRed = implode(", ", $bansRed);

            $game = new GameEntity(
                $gamedata["metadata"]["matchId"],
                $gamedata["info"]["gameDuration"],
                $gamedata["info"]["gameMode"],
                $bansBlue,
                $bansRed
            );
            $games->append($game);
        }

        return $games;

    }
}
?>
