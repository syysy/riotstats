DELIMITER //
CREATE PROCEDURE updateRank(
    IN _id TEXT,
    IN _queueType TEXT,
    IN _tier TEXT,
    IN _rank TEXT,
    IN _leaguePoints INT,
    IN _wins INT,
    IN _losses INT,
)
BEGIN
    UPDATE rank
    SET
        tier = _tier,
        rank = _rank,
        leaguePoints = _leaguePoints,
        wins = _wins,
        losses = _losses
    WHERE id = _id;
END //
DELIMITER ;