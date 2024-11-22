<?php

require_once('IFigure.php');

class King extends Figure {
    protected array $icon = ["\u{265A}", "\u{2654}"];
    public function canMove(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool {

        $rowDiff = abs($from_row - $to_row);
        $colDiff = abs($from_col - $to_col);
        return ($rowDiff <= 1 && $colDiff <= 1) && !($rowDiff === 0 && $colDiff === 0);

        return $this->canMove($from_row, $from_col, $to_row, $to_col, $board);
    }
}