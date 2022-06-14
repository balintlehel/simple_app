<?php

namespace Chatter\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function output()
    {
        $output = [];
        $output['body'] = $this->body;
        $output['user_id'] = $this->user_id;
        $output['user_uri'] = '/user/' . $this->user_id;
        $output['created_at'] = $this->created_at;
        $output['image_url'] = $this->image_url;
        $output['message_id'] = $this->message_id;
        $output['message_uri'] = '/messages/' . $this->id;

        return $output;
    }
}