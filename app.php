<?php
    class Game {

        public function addSpareBonusPoints($frame, $nextFrame) {
            $frame->setPoints($frame->getPoints()+$nextFrame->getFirstScore());
        }

        public function addStrikeBonusPoints($frame, $nextFrame) {
            $frame->setPoints($frame->getPoints()+$nextFrame->getFirstScore()+$nextFrame->getSecoundScore());
        }

//TO DO: input can't be null
        public function roll($howManyKnockedDown) {
            if($howManyKnockedDown == 0) {
                echo "How many pins knocked down? [0-10] : ";
                $score = fgets(STDIN);
                    
                while($score<0 || $score>10) {
                    echo "Score must be between 0 and 10, please try again: ";
                    $score = fgets(STDIN);
                }         
                return $score;
            } else {
                echo "How many pins knocked down? [0-".(10-$howManyKnockedDown)."] : ";
                $score = fgets(STDIN);
                while($score<0 || $score>(10-$howManyKnockedDown)) {
                    echo "Score must be between 0 and ".(10-$howManyKnockedDown).", please try again: ";
                    $score = fgets(STDIN);
                }         
                return $score;
            }
            
        }

        public function printScore($frame) {
            echo "---\n";
            echo "\033[36m ".$frame->getPointsToPrint()."  \033[0m \n";
            echo "---\n";
        }

        public function printScoreTable($frame) {
            $scoreToPrint = array($frame->getFirstScore(), $frame->getSecoundScore());
            echo "___\n";
            echo $scoreToPrint[0].$scoreToPrint[1];
            echo "---\n";
            echo "\033[36m ".$frame->getPointsToPrint()."  \033[0m \n";
            echo "___\n";
        }
    }

    class Frame extends Game {

        private $firstScore;
        private $secoundScore;
        private $points;
        private $pointsToPrint;

        //firstScore
        public function setFirstScore() {
            $this->firstScore = Game::roll(0);
        }

        public function getFirstScore() {
            return $this->firstScore;
        }

        //secoundScore
        public function setSecoundScore($howManyKnockedDown) {
            $this->secoundScore = Game::roll($howManyKnockedDown);
        }

        public function setSecoundScoreToZero() {
            $this->secoundScore = "0\n";
        }

        public function getSecoundScore() {
            return $this->secoundScore;
        }

        //points
        public function setPoints($points) {
            $this->points = $points;
        }

        public function getPoints() {
            return $this->points;
        }

        //points to print
        public function setPointsToPrint($pointsToPrint) {
            $this->pointsToPrint = $pointsToPrint;
        }

        public function getPointsToPrint() {
            return $this->pointsToPrint;
        }


        public function runFrame($frame) {
            $frame->setFirstScore();

            if ($frame->getFirstScore() == 10) {
                echo "STRIKE!!!\n";
                $frame->setSecoundScoreToZero();
                $frame->setPoints($frame->getFirstScore());
            } else {
                $frame->setSecoundScore($frame->getFirstScore());

                if($frame->getFirstScore() + $frame->getSecoundScore() == 10) {
                    echo "SPARE!\n";
                }
                $frame->setPoints($frame->getFirstScore() + $frame->getSecoundScore());
            }
        }

        public function runBonusFrame($frame) {
            $frame->setFirstScore();
            $frame->setSecoundScoreToZero();
            $frame->setPoints($frame->getFirstScore() + $frame->getSecoundScore());
        }

        public function updatePointsWithBonuses($frame, $nextFrame) {
            if($frame->getFirstScore() == 10) {
                Game::addStrikeBonusPoints($frame, $nextFrame);

            } elseif($frame->getFirstScore() + $frame->getSecoundScore() == 10) {
                Game::addSpareBonusPoints($frame, $nextFrame);
            }else {
                
            }
        }

    }


    // GAME STARTS

    $frame0 = new Frame();
    $frame1 = new Frame();
    $frame2 = new Frame();
    $frame3 = new Frame();
    $frame4 = new Frame();
    $frame5 = new Frame();
    $frame6 = new Frame();
    $frame7 = new Frame();
    $frame8 = new Frame();
    $frame9 = new Frame();
    $bonusFrame;


    //FIRST TURN
    Frame::runFrame($frame0);
    $frame0->setPointsToPrint($frame0->getPoints());

    Game::printScore($frame0);

    //SECOUND TURN
    Frame::runFrame($frame1);
    Frame::updatePointsWithBonuses($frame0, $frame1);

    $frame0->setPointsToPrint($frame0->getPoints());
    $frame1->setPointsToPrint($frame0->getPointsToPrint()+$frame1->getPoints());

    Game::printScore($frame1);

    //THIRD TURN
    Frame::runFrame($frame2);
    Frame::updatePointsWithBonuses($frame1, $frame2);
    
    $frame0->setPointsToPrint($frame0->getPoints());
    $frame1->setPointsToPrint($frame0->getPointsToPrint()+$frame1->getPoints());
    $frame2->setPointsToPrint($frame1->getPointsToPrint()+$frame2->getPoints());
    
    Game::printScore($frame2);

    //FOURTH TURN
    Frame::runFrame($frame3);
    Frame::updatePointsWithBonuses($frame2, $frame3);

    $frame0->setPointsToPrint($frame0->getPoints());
    $frame1->setPointsToPrint($frame0->getPointsToPrint()+$frame1->getPoints());
    $frame2->setPointsToPrint($frame1->getPointsToPrint()+$frame2->getPoints());
    $frame3->setPointsToPrint($frame2->getPointsToPrint()+$frame3->getPoints());

    Game::printScore($frame3);

    //FIFTH TURN
    Frame::runFrame($frame4);
    Frame::updatePointsWithBonuses($frame3, $frame4);

    $frame0->setPointsToPrint($frame0->getPoints());
    $frame1->setPointsToPrint($frame0->getPointsToPrint()+$frame1->getPoints());
    $frame2->setPointsToPrint($frame1->getPointsToPrint()+$frame2->getPoints());
    $frame3->setPointsToPrint($frame2->getPointsToPrint()+$frame3->getPoints());
    $frame4->setPointsToPrint($frame3->getPointsToPrint()+$frame4->getPoints());
    
    Game::printScore($frame4);

    //SIXTH TURN
    Frame::runFrame($frame5);
    Frame::updatePointsWithBonuses($frame4, $frame5);

    $frame0->setPointsToPrint($frame0->getPoints());
    $frame1->setPointsToPrint($frame0->getPointsToPrint()+$frame1->getPoints());
    $frame2->setPointsToPrint($frame1->getPointsToPrint()+$frame2->getPoints());
    $frame3->setPointsToPrint($frame2->getPointsToPrint()+$frame3->getPoints());
    $frame4->setPointsToPrint($frame3->getPointsToPrint()+$frame4->getPoints());
    $frame5->setPointsToPrint($frame4->getPointsToPrint()+$frame5->getPoints());
    
    Game::printScore($frame5);

    //SEVENTH TURN
    Frame::runFrame($frame6);
    Frame::updatePointsWithBonuses($frame5, $frame6);

    $frame0->setPointsToPrint($frame0->getPoints());
    $frame1->setPointsToPrint($frame0->getPointsToPrint()+$frame1->getPoints());
    $frame2->setPointsToPrint($frame1->getPointsToPrint()+$frame2->getPoints());
    $frame3->setPointsToPrint($frame2->getPointsToPrint()+$frame3->getPoints());
    $frame4->setPointsToPrint($frame3->getPointsToPrint()+$frame4->getPoints());
    $frame5->setPointsToPrint($frame4->getPointsToPrint()+$frame5->getPoints());
    $frame6->setPointsToPrint($frame5->getPointsToPrint()+$frame6->getPoints());
    
    Game::printScore($frame6);

    //EIGHTH TURN
    Frame::runFrame($frame7);
    Frame::updatePointsWithBonuses($frame6, $frame7);

    $frame0->setPointsToPrint($frame0->getPoints());
    $frame1->setPointsToPrint($frame0->getPointsToPrint()+$frame1->getPoints());
    $frame2->setPointsToPrint($frame1->getPointsToPrint()+$frame2->getPoints());
    $frame3->setPointsToPrint($frame2->getPointsToPrint()+$frame3->getPoints());
    $frame4->setPointsToPrint($frame3->getPointsToPrint()+$frame4->getPoints());
    $frame5->setPointsToPrint($frame4->getPointsToPrint()+$frame5->getPoints());
    $frame6->setPointsToPrint($frame5->getPointsToPrint()+$frame6->getPoints());
    $frame7->setPointsToPrint($frame6->getPointsToPrint()+$frame7->getPoints());
    
    Game::printScore($frame7);

    //NINTH TURN
    Frame::runFrame($frame8);
    Frame::updatePointsWithBonuses($frame7, $frame8);

    $frame0->setPointsToPrint($frame0->getPoints());
    $frame1->setPointsToPrint($frame0->getPointsToPrint()+$frame1->getPoints());
    $frame2->setPointsToPrint($frame1->getPointsToPrint()+$frame2->getPoints());
    $frame3->setPointsToPrint($frame2->getPointsToPrint()+$frame3->getPoints());
    $frame4->setPointsToPrint($frame3->getPointsToPrint()+$frame4->getPoints());
    $frame5->setPointsToPrint($frame4->getPointsToPrint()+$frame5->getPoints());
    $frame6->setPointsToPrint($frame5->getPointsToPrint()+$frame6->getPoints());
    $frame7->setPointsToPrint($frame6->getPointsToPrint()+$frame7->getPoints());
    $frame8->setPointsToPrint($frame7->getPointsToPrint()+$frame8->getPoints());

    Game::printScore($frame8);

    //TENTH TURN
    Frame::runFrame($frame9);
    Frame::updatePointsWithBonuses($frame8, $frame9);

    $frame0->setPointsToPrint($frame0->getPoints());
    $frame1->setPointsToPrint($frame0->getPointsToPrint()+$frame1->getPoints());
    $frame2->setPointsToPrint($frame1->getPointsToPrint()+$frame2->getPoints());
    $frame3->setPointsToPrint($frame2->getPointsToPrint()+$frame3->getPoints());
    $frame4->setPointsToPrint($frame3->getPointsToPrint()+$frame4->getPoints());
    $frame5->setPointsToPrint($frame4->getPointsToPrint()+$frame5->getPoints());
    $frame6->setPointsToPrint($frame5->getPointsToPrint()+$frame6->getPoints());
    $frame7->setPointsToPrint($frame6->getPointsToPrint()+$frame7->getPoints());
    $frame8->setPointsToPrint($frame7->getPointsToPrint()+$frame8->getPoints());
    $frame9->setPointsToPrint($frame8->getPointsToPrint()+$frame9->getPoints());

    Game::printScore($frame9);
    
    echo "END OF THE GAME\n";

    if($frame9->getFirstScore() == 10 || ($frame9->getFirstScore()+$frame9->getSecoundScore() == 10)) {
        echo "BONUS ROLL!!!\n";
        $bonusFrame = new Frame();
        Frame::runBonusFrame($bonusFrame);

        $frame9->setPointsToPrint($frame9->getPointsToPrint()+$bonusFrame->getPoints());
        Game::printScore($frame9);
        echo "THE END\n";
    }

    //PRINTING SCORE TABLE

    Game::printScoreTable($frame0);
    Game::printScoreTable($frame1);
    Game::printScoreTable($frame2);
    Game::printScoreTable($frame3);
    Game::printScoreTable($frame4);
    Game::printScoreTable($frame5);
    Game::printScoreTable($frame6);
    Game::printScoreTable($frame7);
    Game::printScoreTable($frame8);
    Game::printScoreTable($frame9);

?>