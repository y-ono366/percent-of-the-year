<?php

namespace App\Services;
class MessageService
{
    public $asciiArtMaxRow = 6;

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
                $arrAsciiArtMsg[] = $this->createScrollNumOfAsciiArt($num,$parcent,$arrYearAsciiArt);
            }
        }

        for($i=0;$i < $this->asciiArtMaxRow;$i++) {
            $message .=   $arrAsciiArtMsg[0][$i] . "" . $arrAsciiArtMsg[1][$i] . "" . $arrAsciiArtMsg[2][$i] . "" . $arrAsciiArtMsg[3][$i] . "\n";
        }
        return $message;
    }

    private function createScrollNumOfAsciiArt ($num,$parcent,$arrYearAsciiArt):array{
        $yearAsciiArt = [];
        $oneMemo = 100/$this->asciiArtMaxRow;
        $nextYearRow = ceil($this->asciiArtMaxRow - ($parcent/$oneMemo));
        $nowYearRow = 0;
        $firstFlg = true;

        for($row=0;$row<$this->asciiArtMaxRow;$row++) {
            // 次の年の数値を入れるか判定
            if($row < floor($parcent/$oneMemo)) {
                $nextNum = ((int)$num === 9)? 0:(int)$num+1;
                $yearAsciiArt[] = $arrYearAsciiArt[$nextNum][$nextYearRow];
                $nextYearRow++;
            }else{
                // 次の年と感覚を開ける
                if($firstFlg && $parcent !== 0) {
                    $yearAsciiArt[] = "";
                    $firstFlg = false;
                }
                $yearAsciiArt[] = $arrYearAsciiArt[$num][$nowYearRow];
                $nowYearRow++;
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
                " ┏┓ ",
                " ┃┃ ",
                " ┃┃ ",
                " ┃┃ ",
                " ┃┃ ",
                " ┗┛ ",
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
