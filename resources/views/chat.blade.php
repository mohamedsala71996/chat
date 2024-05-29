<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<link rel="stylesheet" href="{{ asset('assets/css/chat.css') }}">



<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="margin-left:10px;">
        <div class="col-xs-12 col-md-12">
        	<div class="panel panel-default">
                <div class="panel-heading top-bar">
                    <div class="col-md-8 col-xs-8">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat - {{ $receiver->name }}</h3>
                    </div>
                    <div class="col-md-4 col-xs-4" style="text-align: right;">
                        <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
                        <a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>
                    </div>
                </div>
                <div class="panel-body msg_container_base" id="chat_area">
                    @foreach($messages as $message)
                        <div class="row msg_container ">
                            <div class="col-md-2 col-xs-2 avatar">
                                <img src="{{ asset($message->send->photo) }}" class="img-responsive">
                            </div>
                            <div class="col-md-10 col-xs-10">
                                <div class="messages base_sent">
                                    <p>{{ $message->message }}</p>
                                    <time datetime="{{ $message->created_at }}">{{ $message->send->name }} • {{ $message->created_at->diffForHumans() }}</time>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" name="message" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="btn-chat">Send</button>
                        </span>
                    </div>
                </div>
    		</div>
        </div>
    </div>
    
</div>

<script>
$('#btn-chat').click(function() {
    let message = $('#btn-input').val();
    if (message.trim() === '') return; // Prevent empty messages

    $.post("/chat/{{ $receiver->id }}", 
    {
        message: message,
        receiver_id: "{{ $receiver->id }}" // Ensure the receiver ID is included
    },
    function(data, status) {
        console.log("Data: " + data + "\nStatus: " + status);
        
        // Get current time
        let now = dayjs();
        let relativeTime = now.fromNow();

        let SenderMessage = '' +
            '<div class="row msg_container ">' +
                '<div class="col-md-2 col-xs-2 avatar">' +
                    '<img src="{{ asset(auth()->user()->photo) }}" class="img-responsive ">' +
                '</div>' +
                '<div class="col-xs-10 col-md-10">' +
                    '<div class="messages msg_receive">' +
                        '<p>' + message + '</p>' +
                        '<time datetime="' + now.toISOString() + '">'+data.name+' ' + relativeTime + '</time>' +
                    '</div>' +
                '</div>' +
            '</div>';

        $('#chat_area').append(SenderMessage);
        $('#btn-input').val(''); // Clear the input field after sending
    });
});

// Optional: Handle 'Enter' key press to send message
$('#btn-input').keypress(function(e) {
    if (e.which === 13) {
        $('#btn-chat').click();
    }
});

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('47995e10bc1f452c241b', {
    cluster: 'eu'
});

var channel = pusher.subscribe("chat{{ auth()->user()->id }}");
channel.bind('ChatSent', function(data) {
    // Get current time
    let now = dayjs();
    let relativeTime = now.fromNow();

    let receiverMessage = '<div class="row msg_container base_sent">' +
                             '<div class="col-md-10 col-xs-10">' +
                                 '<div class="messages ">' +
                                     '<p>' + data.message + '</p>' +
                                     '<time datetime="' + now.toISOString() + '">'+data.name+' ' + relativeTime + '</time>' +
                                 '</div>' +
                             '</div>' +
                             '<div class="col-md-2 col-xs-2 avatar">' +
                                 '<img src="{{ asset($receiver->photo) }}" class=" img-responsive ">' +
                             '</div>' +
                         '</div>';

    $('#chat_area').append(receiverMessage);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
<script>
    dayjs.extend(dayjs_plugin_relativeTime);
</script>


<script src="{{ asset('assets/js/chat.js') }}"></script>