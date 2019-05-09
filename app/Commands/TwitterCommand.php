<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'twitter';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arrParcentDays = $this->getArrParcentDays();

        $parcent = $this->getKeyFromArrParcentDays($arrParcentDays);

        if(is_null($parcent)){
            return false;
        }

        $message = $this->createMessage($parcent);

        $this->tweet($message);
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }

    private function getArrParcentDays(): array {
        date_default_timezone_set('Asia/Tokyo');
        $nowYear = date('Y');
        $startYear = strtotime("{$nowYear}-01-01 00:00:00");
        $oneYearTimestamp = strtotime($nowYear+1 . '-01-01 00:00:00')- $startYear;
        $oneParcentSec = $oneYearTimestamp/100;

        $arrParcentDays=[];
        for($i=0;$i<=100;$i++) {
            $arrParcentDays[$i] = $startYear+$oneParcentSec*$i;
        }
        return $arrParcentDays;
    }

    private function getKeyFromArrParcentDays($arrParcentDays): ?int{
        $arrParcentDayFlip = array_flip($arrParcentDays);
        $nowTime = time();
        foreach($arrParcentDayFlip as $key => $value) {
            if(isset($arrParcentDayFlip[$nowTime])) {
                return $arrParcentDayFlip[$nowTime];
            }
        }
        return null;
    }

    private function createMessage($parcent): string {
        $nowYear = date('Y');
        $nextYear = date('Y',strtotime('+ 1 year'));
        $message = "{$nowYear}年の{$parcent}%が終了しました。\n";
        $arrYearAsciiArt = getYearAsciiArt();

        $arrAsciiArtMsg = [];

        foreach(str_split($nowYear) as $key => $value){
            if($value === $nextYear[$key]) {
                $arrAsciiArtMsg[] = $arrYearAsciiArt[$value];
            }else{
                $arrAsciiArtMsg[] = createAsciiArt($key,$parcent);
            }
        }

        $maxlineNum = 6;
        for($i=0;$i < $maxlineNum;$i++) {
            $message .=   $arrAsciiArtMsg[0][$i] . "" . $arrAsciiArtMsg[1][$i] . "" . $arrAsciiArtMsg[2][$i] . "" . $arrAsciiArtMsg[3][$i] . "\n";
        }
        return $message;
    }

    private function tweet($message) {
        $twitter = new TwitterOAuth(env('CONSUMER_KEY'),env('CONSUMER_SECRET'),env('ACCESS_TOKEN'),env('ACCESS_TOKEN_SECRET'));
        $twitter->post("statuses/update", ["status" => $message]);
    }

    private function createAsciiArt ($parcent,$key,$arrYearAsciiArt):array{
        $yearAsciiArt = [];
        $maxlineNum = 6;
        $oneMemo = 100/$maxlineNum;

        for($i=0;$i<$maxlineNum;$i++) {
            if($i < floor($parcent/$oneMemo)) {
                $yearAsciiArt[] = $arrYearAsciiArt[$key+1][$i];
            }else{
                $yearAsciiArt[] = $arrYearAsciiArt[$key][$i];
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
