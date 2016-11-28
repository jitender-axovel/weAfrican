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
    	return $this->whereSenderId($input['senderId'])->whereReceiverId($input['receiverId'])->where('id', '>', $input['id'])->orderBy('id','asc')->get();
    }

    public function apiGetUserAllMessages($input)
    {
    	return  $this->where(['sender_id' => $input['senderId'], 'receiver_id' => $input['receiverId']])->orWhere(['sender_id' => $input['receiverId'], 'receiver_id' => $input['senderId']])->skip($input['index'])->limit($input['limit'])->get();
    }

    public function apiGetChatUsers($input)
    {
        $senderIds = $this->where('receiver_id', $input['userID'])->pluck('sender_id', 'id')->toArray();
        $receiverIds = $this->where('sender_id', $input['userID'])->pluck('receiver_id', 'id')->toArray();

        $userIds = array_unique (array_merge ($senderIds, $receiverIds));

        $response = array();
        $object = array();

        foreach ($userIds as $key => $id) {
            $message = $this->where(['sender_id' => $id, 'receiver_id' => $input['userID']])->orWhere(['sender_id' => $input['userID'], 'receiver_id' => $id])->orderBy('id', 'DESC')->first();

            $object['message'] = $message->message;
            if ($message->sender_id == $input['userID']) {
                $object['userName'] = $message->receiver->full_name;
                $object['avatar'] = $message->receiver->image;
                $object['role'] = 'sender';
            } else {
                $object['userName'] = $message->sender->full_name;
                $object['avatar'] = $message->sender->image;
                $object['role'] = 'receiver';
            }

            $response[] = $object;
        }
        return $response;
    }

   
}