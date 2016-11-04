<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserConversation extends Model
{
	protected $fillable = ['sender_id', 'receiver_id', 'message'];

    public function sender()
    {
        return $this->belongsTo('App\User','sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User','receiver_id', 'id');
    }

    public function apiPostUserMessage($input)
    {
    	$conversation = new UserConversation();

    	$conversation->sender_id = $input['senderId'];
    	$conversation->receiver_id = $input['receiverId'];
    	$conversation->message = $input['message'];
    	$conversation->save();

    	return $conversation;
    }

    public function apiGetUserMessage($input)
    {
    	return $this->whereSenderId($input['senderId'])->whereReceiverId($input['receiverId'])->orderBy('id','desc')->first();
    }

    public function apiGetUserAllMessages($input)
    {
    	return  $this->where(['sender_id' => $input['senderId'], 'receiver_id' => $input['receiverId']])->orWhere(['sender_id' => $input['receiverId'], 'receiver_id' => $input['senderId']])->skip($input['index'])->limit($input['limit'])->get();
    }
}