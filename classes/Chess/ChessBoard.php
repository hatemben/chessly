<?php

namespace ChessGame\Chess;
use Exception;
use ChessGame\BoardGame\Player;

class ChessBoard {
    private $board;
    private $factory;
    private static $instance = null;

    private function __construct(array $players) {
        $this->factory = new ChessPieceFactory();
        $this->board = [];
        
        // Define the pieces layout for each player
        $piecesLayout = ['Rook', 'Knight', 'Bishop', 'Queen', 'King', 'Bishop', 'Knight', 'Rook'];
        
        for ($i = 0; $i < 8; $i++) {
            for ($j = 0; $j < 8; $j++) {
                if ($i == 1) {
                    $this->board[$i][$j] = $this->factory->create('Pawn', 'black', $players[1], $j, $i);
                } elseif ($i == 0) {
                    $this->board[$i][$j] = $this->factory->create($piecesLayout[$j], 'black', $players[1], $j, $i);
                } elseif ($i == 6) {
                    $this->board[$i][$j] = $this->factory->create('Pawn', 'white', $players[0], $j, $i);
                } elseif ($i == 7) {
                    $this->board[$i][$j] = $this->factory->create($piecesLayout[$j], 'white', $players[0], $j, $i);
                } else {
                    $this->board[$i][$j] = null;
                }
            }
        }
    }

    public static function getInstance(array $players) {
        if (self::$instance == null) {
            self::$instance = new ChessBoard($players);
        }
        
        return self::$instance;
    }

    public function getPieceAt($position): ?ChessPiece {
        return $this->board[$position[0]][$position[1]];
    }

    public function movePiece($from, $to): void {
        $piece = $this->getPieceAt($from);
        if ($piece && $piece->isValidMove($from, $to)) {
            $this->board[$to[0]][$to[1]] = $piece;
            $this->board[$from[0]][$from[1]] = null;
            $piece->setHasMoved(true);
        } else {
            throw new Exception("Invalid move");
        }
    }

    public function forceMovePiece($from, $to): void {
        $piece = $this->getPieceAt($from);
        $this->board[$to[0]][$to[1]] = $piece;
        $this->board[$from[0]][$from[1]] = null;
        $piece->setHasMoved(true);
    }
    

    public function render() {
        $letters = range('A', 'H');
    
        echo "  ";
        foreach($letters as $letter) {
            echo ' '.$letter.' ';
        }
        echo "\n";
    
        foreach ($this->board as $rowKey => $row) {
            echo ($rowKey + 1)." ";
            foreach ($row as $cell) {
                echo '['.($cell ? $cell->getName()[0] : ' ').']';
            }
            echo "\n";
        }
    }
    
    

    public function getGameState(): array {
        // Implement this method
        return [];
    }

    public function getScores(): array {
        // Implement this method
        return [];
    }

    public function isOver(): bool {
        // Implement this method
        return false;
    }

    public function removePiece($x, $y): void {
        $this->board[$y][$x] = null;
    }
}
