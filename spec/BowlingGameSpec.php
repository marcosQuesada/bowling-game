<?php

require_once __DIR__ . '/../lib/BowlingGame.php';

class DescribeBowlingGame extends \PHPSpec\Context
{
    function before()
    {
        $this->game = $this->spec(new BowlingGame);
    }
    
    function itScoresZeroForAGutterGame()
    {
        $this->rollMany(20, 0);
        $this->score()->should->be(0);
    }
    
    function itScoresTheSumOfRollsWhenNoStrikesOrSparesAreMade()
    {
        $this->rollMany(20, 1);
        $this->score()->should->be(20);
    }
    
    function itCountsOneBonusRollForASpare()
    {
        $this->rollSpare();
        $this->game->roll(2);  // 10 + 2 + 2 
        $this->rollMany(17, 0);
        $this->score()->should->be(14);
    }
    
    function itCountsTwoBonusRollForAStrike()
    {
        $this->rollStrike();
        $this->game->roll(5);
        $this->game->roll(2);  // 10 + 5 + 2 + 5 + 2
        $this->rollMany(17, 0);
        $this->score()->should->be(24);
    }
    
    function itCountsTwoBonusRollForAStrikeEvenIfTheyAreStrikes()
    {
        $this->rollStrike();  // 10 + 10 + 5 = 25
        $this->rollStrike();  // 10 + 5 + 2  = 17
        $this->game->roll(5); // + 5
        $this->game->roll(2); // + 2
        $this->rollMany(14, 0);
        $this->score()->should->be(49);
    }
    
    function itScores300ForAPerfectGame()
    {
        $this->rollMany(12, 10);
        $this->score()->should->be(300);
    }
    
    function rollSpare()
    {
        $this->game->roll(5);
        $this->game->roll(5);
    }
    
    function rollStrike()
    {
        $this->game->roll(10);
    }
    
    function rollMany($times, $pins)
    {
        while ($times-- > 0) {
            $this->game->roll($pins);
        }
    }
    
    function score()
    {
        return $this->game->score();
    }
}