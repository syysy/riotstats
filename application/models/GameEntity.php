<?php

class GameEntity {
    public String $matchID;
    public Int $gameDuration;
    public String $gameMode;
    public string $bansBlue;
    public string $bansRed;

    public function __construct($matchID, $gameDuration, $gameMode, $bansBlue, $bansRed) {
        $this->matchID = $matchID;
        $this->gameDuration = $gameDuration;
        $this->gameMode = $gameMode;
        $this->bansBlue = $bansBlue;
        $this->bansRed = $bansRed;
    }
}

?>
