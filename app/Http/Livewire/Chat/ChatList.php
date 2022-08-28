<?php

namespace App\Http\Livewire\Chat;

use App\Models\User;
use App\Models\Conversation;

use Livewire\Component;

class ChatList extends Component
{
    public $auth_id;
    public $conversations;
    public $receiverInstance;
    public $name;
    public $selectedConversation;

    protected $listeners = [
        'chatUserSelected',
        'refresh' => '$refresh',
    ];

    // listener to handle user/conversation selection
    public function chatUserSelected(Conversation $conversation, $receiverId)
    {
        // dd($conversation, $receiverId);
        $this->selectedConversation = $conversation;
        $this->receiverInstance = User::find($receiverId);
        // $this->name = $this->receiverInstance->name;

        $this->emitTo('chat.chatbox', 'loadConversation', $this->selectedConversation, $receiverId);

        $this->emitTo('chat.send-message', 'updateSendMessage', $this->selectedConversation, $receiverId);
    }

    // Helper function to get chat user instance
    public function getChatUserInstance(Conversation $conversation, $request)
    {
        $this->auth_id = auth()->user()->id;

        // get selected conversation
        if ($conversation->sender_id == $this->auth_id) {
            $this->receiverInstance = User::firstWhere('id', $conversation->receiver_id);
        } else {
            $this->receiverInstance = User::firstWhere('id', $conversation->sender_id);
        }

        if (isset($request)) {
            return $this->receiverInstance->$request;
        }
    }

    public function mount()
    {
        $this->auth_id = auth()->user()->id;
        $this->conversations = Conversation::where('sender_id', $this->auth_id)
            ->orWhere('receiver_id', $this->auth_id)
            ->orderBy('last_time_message', 'DESC')
            ->get();
    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
