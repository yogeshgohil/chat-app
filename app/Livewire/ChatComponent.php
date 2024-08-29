<?php

namespace App\Livewire;

use App\Events\MessageSendEvent;
use App\Models\Message;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatComponent extends Component
{
    public $user;
    public $sender_id;
    public $receiver_id;
    public $message = '';
    public $messages = [];
    public function render()
    {
        return view('livewire.chat-component');
    }

    public function mount($user_id)
    {
        $this->sender_id = auth()->id();
        $this->receiver_id = $user_id;
        $this->user = User::whereId($user_id)->first();
        $messages = Message::where(function ($query) {
            $query->where('sender_id', $this->sender_id)
                ->where('receiver_id', $this->receiver_id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->receiver_id)
                ->where('receiver_id', $this->sender_id);
        })->with('sender:id,name', 'receiver:id,name')->get();
        foreach ($messages as $msg) {
            $this->convertToMessage($msg);
        }
        // dd($user_id);
    }

    public function sendMessage()
    {
        $chatMessage = new Message();
        $chatMessage->sender_id = $this->sender_id;
        $chatMessage->receiver_id = $this->receiver_id;
        $chatMessage->message = $this->message;
        $chatMessage->save();
        $this->convertToMessage($chatMessage);
        broadcast(new MessageSendEvent($chatMessage));

        $this->message = '';
    }

    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenForMessage($event)
    {
        $chatMessage = Message::whereId($event['message']['id'])->with('sender:id,name', 'receiver:id,name')->first();
        $this->convertToMessage($chatMessage);
    }
    public function convertToMessage($msg)
    {
        $this->messages[] = [
            'id' => $msg->id,
            'sender' => $msg->sender->name,
            'message' => $msg->message,
            'receiver' => $msg->receiver->name
        ];
    }
}
