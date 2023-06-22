<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\HostAppointments;
use Illuminate\Support\Facades\Mail;
use App\Mail\WakeUpGuestItsMeetingTime;
use App\Mail\WakeUpHostItsMeetingTime;
class MetingTimeNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wakeupitsyourmeetingtime:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $current_date = date("Y-m-d H:i");
        $current_date = strtotime($current_date);
        $duration_in_minutes = '15';
        $requied_time = date('Y-m-d H:i', strtotime('+'.$duration_in_minutes.' minutes',$current_date));
        $send_to = HostAppointments::where([['start','<=',$requied_time],['mail_send_status','=',0]])->get();
        foreach($send_to as $s){
            $guest_name = $s['guest_name'];
            $guest_email  = $s['guest_email'];
            $host = User::find($s['host_id']);
            $host_email = $host['email'];
            $host_name = $host['first_name'];
            $meeting_link = $s['join_link'];
            $meeting_start_time = $s['start'];
            Mail::to($host_email)->send(new WakeUpHostItsMeetingTime($host_name,$guest_name,$meeting_link,$meeting_start_time));
            Mail::to($guest_email)->send(new WakeUpGuestItsMeetingTime($guest_name,$host_name,$meeting_link,$meeting_start_time));
            HostAppointments::where("_id", $s['id'])->update(["mail_send_status" => 1]);
        }
        return Command::SUCCESS;
    }
}
