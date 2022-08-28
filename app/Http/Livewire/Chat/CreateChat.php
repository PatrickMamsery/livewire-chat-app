<?php

namespace App\Http\Livewire\Chat;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class CreateChat extends Component
{
    public $users;
    public $message = 'Hi how are you?';

    public function checkConversation($receiverId)
    {
        // get conversations of the current user with user listed
        $checkedConversation = Conversation::where('sender_id', auth()->user()->id)
            ->where('receiver_id', $receiverId)
            ->orWhere('sender_id', $receiverId)
            ->where('receiver_id', auth()->user()->id)
            ->get();

        // if there is no conversation, create one
        if (count($checkedConversation)  == 0) {
            // dd('no conversation');

            $createdConversation = Conversation::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $receiverId,
                'last_time_message' => now(),
            ]);

            $createdMessage = Message::create([
                'conversation_id' => $createdConversation->id,
                'sender_id' => auth()->user()->id,
                'receiver_id' => $receiverId,
                'body' => $this->message,
            ]);

            $createdConversation->last_time_message = $createdMessage->created_at;
            $createdConversation->save();

            dd('saved');

        } else if(count($checkedConversation) >= 1) {
            dd('conversation found');
        }
    }
    
    public function render()
    {
        $this->users = User::where('id', '!=', auth()->user()->id)->get();
        return view('livewire.chat.create-chat');
    }
}
