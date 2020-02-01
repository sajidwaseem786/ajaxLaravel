<?php

namespace App\Http\Controllers;
use Pusher\Pusher;
use Illuminate\Http\Request;

use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Notifications\DatabaseNotification;


class NotificationController extends Controller
{
    public function notify()
    {
        $options = array(
                        'cluster' => env('PUSHER_APP_CLUSTER'),
                        'encrypted' => true
                        );
        $pusher = new Pusher(
                            env('PUSHER_APP_KEY'),
                            env('PUSHER_APP_SECRET'),
                            env('PUSHER_APP_ID'), 
                            $options
                        );
        





      
        $letter=collect(['title'=>'New Update','body'=>'Some One Commented on your Post!']);

$pusher->trigger('notify-channel', 'App\\Events\\Notify', $letter);

       
   

    }
    public function notification(){

    	return view('notification');
    }
}