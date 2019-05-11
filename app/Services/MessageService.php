<?php

namespace App\Services;
class MessageService
{

    public function createTweetMessage($parcent): string {
        $nowYear = date('Y');
        $nextYear = date('Y',strtotime('+ 1 year'));
        $message = "{$nowYear}年の{$parcent}%が終了しました。\n";
        $arrYearAsciiArt = $this->getYearAsciiArt();

        $arrAsciiArtMsg = [];

        foreach(str_split($nowYear) as $key => $num){
            // 次年の数値と比較
            if($num === $nextYear[$key]) {
                $arrAsciiArtMsg[] = $arrYearAsciiArt[$num];
            }else{
                $arrAsciiArtMsg[] = $this->createAsciiArt($num,$parcent,$arrYearAsciiArt);
            }
        }

        $maxRow = 6;
        for($i=0;$i < $maxRow;$i++) {
            $message .=   $arrAsciiArtMsg[0][$i] . "" . $arrAsciiArtMsg[1][$i] . "" . $arrAsciiArtMsg[2][$i] . "" . $arrAsciiArtMsg[3][$i] . "\n";
        }
        return $message;
    }

    private function createAsciiArt ($num,$parcent,$arrYearAsciiArt):array{
        $yearAsciiArt = [];
        $maxRow = 6;
        $oneMemo = 100/$maxRow;
        $firstFlg = true;

        for($row=0;$row<$maxRow;$row++) {
            // 次の年の数値を入れるか判定
            if($row < floor($parcent/$oneMemo)) {
                $nextNum = ((int)$num === 9)? 0:(int)$num+1;
                $nextRow = $maxRow-$row - 1;
                var_dump($nextRow);
                $yearAsciiArt[] = $arrYearAsciiArt[$nextNum][$nextRow];
            }else{
                // 次の年と感覚を開ける
                if($firstFlg) {
                    $yearAsciiArt[] = "";
                    $firstFlg = false;
                }
                $yearAsciiArt[] = $arrYearAsciiArt[$num][$row];
            }
        }
        return $yearAsciiArt;
    }

    private function getYearAsciiArt() {
        return [
            [
                "┏━━┓",
                "┃┏┓┃",
                "┃┃┃┃",
                "┃┃┃┃",
                "┃┗┛┃",
                "┗━━┛",
            ],
            [
                "┏┓",
                "┃┃",
                "┃┃",
                "┃┃",
                "┃┃",
                "┗┛",
            ],
            [
                "┏━━┓",
                "┗━┓┃",
                "┏━┛┃",
                "┃┏━┛",
                "┃┗━┓",
                "┗━━┛",
            ],
            [
                "┏━━┓",
                "┗━┓┃",
                "┏━┛┃",
                "┗━┓┃",
                "┏━┛┃",
                "┗━━┛",
            ],
            [
                "┏┓┏┓",
                "┃┃┃┃",
                "┃┗┛┃",
                "┗━┓┃",
                "  ┃┃",
                "  ┗┛",
            ],
            [
                "┏━━┓",
                "┃┏━┛",
                "┃┗━┓",
                "┗━┓┃",
                "┏━┛┃",
                "┗━━┛",
            ],
            [
                "┏┓  ",
                "┃┃  ",
                "┃┗━┓",
                "┃┏┓┃",
                "┃┗┛┃",
                "┗━━┛",
            ],
            [
                "┏━━┓",
                "┗━┓┃",
                "  ┃┃",
                "  ┃┃",
                "  ┃┃",
                "  ┗┛",
            ],
            [
                "┏━━┓",
                "┃┏┓┃",
                "┃┗┛┃",
                "┃┏┓┃",
                "┃┗┛┃",
                "┗━━┛",
            ],
            [
                "┏━━┓",
                "┃┏┓┃",
                "┃┗┛┃",
                "┗━┓┃",
                "  ┃┃",
                "  ┗┛",
            ],
        ];
    }
}
