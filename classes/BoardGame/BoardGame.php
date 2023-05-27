<?php

namespace ChessGame\BoardGame;

abstract class BoardGame {
    abstract public function getGameState(): array;
    abstract public function getScores(): array;
    abstract public function makeMove(Player $player, array $move);
    abstract public function isOver(): bool;
    protected $board;
    protected $players;
    protected $currentPlayerIndex;
    private $observers = [];

    public function __construct(array $players) {
        $this->players = $players;
        $this->currentPlayerIndex = 0;
    }

    public function getBoard() {
        return $this->board;
    }

    public function removePiece($x, $y) {
        unset($this->board[$y][$x]);
    }

    public function addObserver(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer $observer) {
        $this->observers = array_filter($this->observers, function($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    protected function notifyObservers(string $event, $data): void {
        foreach ($this->observers as $observer) {
            $observer->update($event, $data);
        }
    }
}
