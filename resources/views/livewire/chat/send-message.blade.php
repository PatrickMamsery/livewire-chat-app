<div>
    {{-- The whole world belongs to you. --}}

    <form action="" method="POST">
        <div class="chatbox_footer">
            @csrf
            <div class="custom_form_group">
                <input type="text" name="message" class="control" placeholder="Type a message...">
                <button type="submit" class="send">
                    <i class="bi bi-send"></i>
                </button>
            </div>
        </div>
    </form>
</div>
