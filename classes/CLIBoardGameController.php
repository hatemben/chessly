<?php

namespace ChessGame;

use Exception;
use ChessGame\BoardGame\BoardGame;
use ChessGame\BoardGame\Player;

class CLIBoardGameController {
    private $game;
    private $players;

    public function __construct(BoardGame $game, array $players) {
        $this->game = $game;
        $this->players = $players;
    }

    public function start(): void {
        while (!$this->game->isOver()) {
            $this->game->getBoard()->render();
            $currPlayer = $this->game->getPlayers()[$this->game->getCurrentPlayerIndex()];
            echo "Current Player: " . $currPlayer->getName() . " (" . $currPlayer->getColor() . ")\n";
    
            $input = $this->getInput();

            if ($input == 'undo') {
                $this->game->undoLastMove();
                continue;
            }
    
            // Try to make the move
            try {
                $moveMade = $this->game->makeMove($currPlayer, ['from' => $input['from'], 'to' => $input['to']]);
                if (!$moveMade) {
                    echo "Invalid move, please try again.\n";
                }
            } catch (Exception $e) {
                echo "Invalid move, please try again.\n";
            }
        }
    }
    
    public function getInput() {
        echo "Enter move (source and destination) or type 'undo': ";
        $input = trim(fgets(STDIN));
        if ($input == 'undo') {
            return 'undo';
        }
        if (!preg_match('/^[A-H][1-8]\s[A-H][1-8]$/', $input)) {
            echo "Invalid input. Please use the format 'E2 E4' or type 'undo'.\n";
            return $this->getInput();
        }
        return [
            'from' => $this->convertCoordinates(substr($input, 0, 2)),
            'to' => $this->convertCoordinates(substr($input, 3, 2))
        ];
    }    
    
     private function convertCoordinates(string $coord): array {
        // Convert 'A2' style coordinates to [1, 0] style
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $letter = $coord[0];
        $number = $coord[1];
        $x = array_search($letter, $letters);
        $y = (int)$number - 1;
        return [$y, $x];
    } 

    private function getMoveFromUser(): array {
        // Read user input
        return [];
    }

    private function endGame(): void {
        // Print the game result
    }
}
