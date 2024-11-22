<?php

require_once('color.php');
require_once('IFigure.php');
require_once('Board.php');

class Pawn extends Figure {
    protected array $icon = ["\u{265F}", "\u{2659}"];
    public function canMove(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool {
        $direction = $this->getColor() === Color::White ? 1 : -1;
        if ($from_col !== $to_col) {
            return false;
        }
        $as_two_step_row = $this->getColor() === Color::White ? 1 : 6;
        $available = [$from_row + $direction];
        if ($as_two_step_row) {
            $available[] = $from_row + $direction * 2;
        }
        if (!in_array($to_row, $available)) {
            return false;
        }
        $ix = $from_row;
        while ($ix != $to_row) {
            $item = $board->getItem($ix, $from_col);
            if ($item && $item != $this) {
                return false;
            }
            $ix += $direction;
        }
        return true;
    }

    public function canAttack(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool {
        $diff_row = abs($to_row - $from_row);
        $diff_col = abs($to_col - $from_col);
        return $diff_col === 1 && $diff_row === 1;
    }
}