<?php

class RankEntity {
    public string $tier;
    public string $rank;
    public int $leaguePoints;
    public int $wins;
    public int $losses;
    public string $queueType;

    public function __construct(string $tier, string $rank, int $leaguePoints, int $wins, int $losses, string $queueType) {
        $this->tier = $tier;
        $this->rank = $rank;
        $this->leaguePoints = $leaguePoints;
        $this->wins = $wins;
        $this->losses = $losses;
        $this->queueType = $queueType;
    }
    
}
?>
