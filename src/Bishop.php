<?php

require_once('IFigure.php');

class Bishop extends Figure {
    protected array $icon = ["\u{265D}", "\u{2657}"];

    public function canMove(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool {
        $diff_row = abs($to_row - $from_row);
        $diff_col = abs($to_col - $from_col);
        if ($diff_col != $diff_row) {
            return false;
        }
        $step_col = ($to_col - $from_col) / $diff_col;
        $step_row = ($to_row - $from_row) / $diff_row;
        $start_col = $from_col;
        $start_row = $from_row;
        while ($start_col != $to_col || $start_row != $to_row) {
            $item = $board->getItem($start_row, $start_col);
            if ($item && $item !== $this) {
                return false;
            }
            $start_col += $step_col;
            $start_row += $step_row;
        }
        return true;
    }
}