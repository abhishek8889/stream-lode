<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\Messages;

class MessageChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user,Message $message)
    {
       return $message->reciever_id = $user->reciever_id;
    }
}
