<?php

namespace ChessGame\BoardGame;

interface Observer {
    public function update(string $event, $data): void;
}

class GameObserver implements Observer {
    public function update(string $event, $data): void {
        echo "Game Observer: Detected event '$event'\n";
        // Perform some actions based on the event and associated data
    }
}
