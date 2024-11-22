<?php

require_once('IFigure.php');

class Knight extends Figure {
    protected array $icon = ["\u{265E}", "\u{2658}"];

    public function canMove(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool {
        $diff_row = abs($from_row - $to_row);
        $diff_col = abs($from_col - $to_col);
        return $diff_row == 2 && $diff_col == 1 || $diff_row == 1 && $diff_col == 2;
    }

}