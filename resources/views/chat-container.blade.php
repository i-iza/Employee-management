<div class="card">
    <div class="card-header" style="background-color: #2C3128; color: #FFFFFF;">
        <h5 class="mb-0">Chatbox</h5>
    </div>
    <div class="card-body" id="chat-container" data-user-id="{{ auth()->user()->id }}">
        <div class="messages-container" style="max-height: 300px; overflow-y: auto;">
            @foreach($messages->filter(function ($message) {
                return $message->to_user_id == auth()->user()->id || $message->from_user_id == auth()->user()->id;
            })->sortBy('created_at') as $message)
                <div class="message">
                @if($message->from_user_id == auth()->user()->id)
                        <span style="color: #A6B695;">You to {{ $message->toUser->name }}:</span>
                        <div class="message-content">{{ $message->decryptedChatMessage }}</div>
                    @else
                        <div style="color: #7EA951;">{{ $message->fromUser->name }} to You:</div>
                        <div class="message-content">{{ $message->decryptedChatMessage }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">
        <form id="chat-form">
            @csrf
            <div class="form-group mb-0">
                <div class="input-group">
                    <select name="to_user_id" id="to_user_id" class="form-control" style="width: 20%;">
                        <option value="">Select Recipient</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="chat_message" class="form-control" placeholder="Type your message..." style="width: 60%;">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" style="background-color: #7EA951; border-color: #7EA951; color: #FFFFFF;">Send</button>
                    </div>
                </div>
                <div class="alert alert-danger mt-2" id="error-alert" style="display: none" role="alert"></div>
                <div class="alert alert-success mt-2" id="success-alert" style="display: none" role="alert"></div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Submit the chat form using AJAX
        $('#chat-form').submit(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '{{ route("send.message") }}',
                data: $(this).serialize(),
                success: function (response) {
                    // Clear the input field after sending the message
                    $('#chat-form input[name="chat_message"]').val('');

                    $('#success-alert').text('Message sent successfully.').show();

                    setTimeout(function () {
                        $('#success-alert').hide();
                    }, 5000);
                },
                error: function (error) {
                    $('#error-alert').text('An error occurred.').show();
                    setTimeout(function () {
                        $('#error-alert').hide();
                    }, 5000);
                    console.log(error);
                }
            });
        });

        // Fetch and display new messages every 5 seconds
        setInterval(function () {
        $.ajax({
            type: 'GET',
            url: '{{ route("get.messages") }}',
            success: function (response) {
                var messagesContainer = $('.messages-container');
                var currentUserId = $('#chat-container').data('user-id');
                var messagesHtml = '';

                $.each(response.messages, function (index, message) {
                    messagesHtml += '<div class="message">';
                    if (message.from_user_id == currentUserId) {
                        messagesHtml += '<span style="color: #A6B695;">You to ' + message.to_user.name + ':</span>';
                        messagesHtml += '<div class="message-content">' + message.chat_message + '</div>';
                    } else {
                        messagesHtml += '<div style="color: #7EA951;">' + message.from_user.name + ' to You:</div>';
                        messagesHtml += '<div class="message-content">' + message.chat_message + '</div>';
                    }
                    messagesHtml += '</div>';
                });
                messagesContainer.html(messagesHtml);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }, 5000);
    });
</script>
