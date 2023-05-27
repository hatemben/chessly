<?php

namespace ChessGame\Chess;

use ChessGame\BoardGame\GameObserver;

class ChessObserver extends GameObserver {
    public function update(string $event, $data): void {
        parent::update($event, $data);

        switch ($event) {
            case 'check':
                echo "Check! Player $data is in check!";
                break;
            case 'checkmate':
                echo "Checkmate! Player $data wins!";
                break;
            // Add other chess specific events here...
        }
    }
}
