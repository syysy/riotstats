<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
    <?php include 'style.css'; ?>
    </style>    
    <title>Riot Stats</title>
</head>
<body>
    <div class="title">
        <h1>Bienvenue sur Riot Stats !</h1>
        <a href="<?= site_url('guilde/index') ?>" class ="mode" > Mode Guilde </a>
    </div>

<p> Veuillez indiquer la region dans laquelle vous souhaitez rechercher ainsi que le nom du joueur. </p>
<form action="<?= site_url('home/summoner')?>" method="post">
    <div>
        <select name="region">
            <option value="euw1">EUW</option>
            <option value="eun1">EUNE</option>
            <option value="na1">NA</option>
            <option value="kr">KR</option>
            <option value="br1">BR</option>
            <option value="jp1">JP</option>
            <option value="la1">LAN</option>
            <option value="la2">LAS</option>
            <option value="oc1">OCE</option>
            <option value="tr1">TR</option>
            <option value="ru">RU</option>
        </select>
        <input type="text" name="summoner" placeholder="Nom d'utilisateur">
        <input type="submit" value="Rechercher">
    </div>
</form>



<div>
    <p>Joueurs favoris -</p>
    <div class ="player_card">
        <div class="player_card-header">
            <div class="player_card_header_title">
                <h3 class="player_card-title"><?= $summonerInfo[0]['name']?></h3>
                <img class="img_pp" src="https://ddragon.leagueoflegends.com/cdn/12.21.1/img/profileicon/<?= $summonerInfo[0]['profileIconId'] ?>.png" alt="">
            </div>
            <div class="player_card_header_info">
                <p><?= " ",$summonerInfo[0]['region'] ?></p> 
                <p>lvl.<?= $summonerInfo[0]['level']?></p>
            </div>
        </div>
        <div class="player_card-body" style="display : flex; gap: 15px;">
            <div>
                <h4 class="player_card-text">Classé solo</h4>
                <p class="player_card-text">Rang : <?= $summonerRanks[0]['tier']," ", $summonerRanks[0]['rank']," ", $summonerRanks[0]['leaguePoints']," lp"?></p>
                <p class="player_card-text">Nombre de parties jouées : <?= $summonerRanks[0]['wins'] + $summonerRanks[0]['losses'] ?></p>
                <p class="player_card-text">Nombre de victoires : <?= $summonerRanks[0]['wins'] ?> </p>
                <p class="player_card-text">Nombre de défaites <?= $summonerRanks[0]['losses'] ?> </p>
            </div>  
            <div>
                <h4 class="player_card-text">Ranked Flex </h4>
                <p class="player_card-text">Rang : <?= $summonerRanks[1]['tier']," ", $summonerRanks[1]['rank']," ", $summonerRanks[1]['leaguePoints']," lp"?></p>
                <p class="player_card-text">Nombre de parties jouées : <?= $summonerRanks[1]['wins'] + $summonerRanks[1]['losses'] ?></p>
                <p class="player_card-text">Nombre de victoires : <?= $summonerRanks[1]['wins'] ?> </p>
                <p class="player_card-text">Nombre de défaites <?= $summonerRanks[1]['losses'] ?> </p>
            </div>
            <div>
                <h4><a href="">Update</a></h4>
            </div>
        </div>
    </div>
    <li>Player 2</li>
    <li>Player 3</li>
    <li>Player 4</li>
    <li>Player 5</li>
</div>
</body>
</html>