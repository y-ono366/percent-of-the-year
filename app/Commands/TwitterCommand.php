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

        $this->twitterAuth();
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
        $message = date('Y') . '年の' . $parcent . '%が終了しました。';
        return $message;
    }

    private function twitterAuth() {
        $to = new TwitterOAuth(env('CONSUMER_KEY'),env('CONSUMER_SECRET'),env('ACCESS_TOKEN'),env('ACCESS_TOKEN_SECRET'));
        $user = $to->get('account/verify_credentials');
        var_dump($user);
    }
}
