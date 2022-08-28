<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;

class SendMessage extends Component
{
    public $auth_id;
    public $selectedConversation;
    public $receiverInstance;
    public $body;

    protected $listeners = [
        'updateSendMessage',
    ];

    public function updateSendMessage(Conversation $conversation, User $receiver)
    {
        // dd($conversation, $receiver);
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;
    }

    public function sendMessage()
    {
        // dd($this->body);
        if ($this->body == null) {
            return null;
        }

        $createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiverInstance->id,
            'body' => $this->body,
        ]);

        $this->selectedConversation->last_time_message = $createdMessage->created_at;
        $this->selectedConversation->save();

        // refresh chatbox messages
        $this->emitTo('chat.chatbox', 'pushMessage', $createdMessage->id);

        // refresh chatlist
        $this->emitTo('chat.chat-list', 'refresh');

        $this->reset('body');
    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
