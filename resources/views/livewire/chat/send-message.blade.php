<div>
    {{-- The whole world belongs to you. --}}

    @if ($selectedConversation)
        <form wire:submit.prevent='sendMessage' action="" method="POST">
            <div class="chatbox_footer">
                @csrf
                <div class="custom_form_group">
                    <input wire:model='body' type="text" name="message" class="control" placeholder="Type a message...">
                    <button type="submit" class="send">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
