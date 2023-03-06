<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container" id="app">
        <h2 class="text-center">ChatGPT</h2>
        {{-- <form action="/chat" method="POST">
            @csrf
            <input type="text" name="prompt">
            <button type="submit">Send</button>
        </form>
        <div id="chat">
        </div> --}}

        <div id="chatgpt-form">
            <form>
                @csrf
                <input type="text" id="chatgpt-text" name="chatgpt-text" placeholder="Type your message here...">
                <button type="submit" id="chatgpt-submit">Send</button>
            </form>
        </div>
        
        <div id="message-container"></div>



    </div>
    <script>
        $('#chatgpt-form form').submit(function(event) {
            event.preventDefault();
            var messageInput = $('#chatgpt-text').val();
            if (messageInput !== '') {
                $('#message-container').append('<div class="request-message">' + messageInput + '</div>');
                $('#chatgpt-text').val('');
                $.ajax({
                    url: '{{ route('chatgpt.api') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: messageInput
                    },
                    success: function(response) {
                        var postDescriptionApi = response.choices[0].text;
                        var jsonTextRemove = postDescriptionApi.replace(/^\s+/, '');
                        var htmlString = jsonTextRemove.replace(/\n/g, '<br>');
                        var message = htmlString.split(' ');
                        var i = 0;
                        var delay = 50; // delay between each character
                        var timeoutDelay = 1000; // delay between each response
                        var heading = '<div class="response-heading">' + messageInput + '</div>';
                        var typing = setInterval(function() {
                            if (i === 0) {
                                $('#message-container').append(heading);
                            }
                            $('#message-container').append(message[i] + ' ');
                            i++;
                            if (i === message.length) {
                                clearInterval(typing);
                                setTimeout(function() {
                                    $('#message-container').append('<br>');
                                    $('#message-container').scrollTop($('#message-container')[0].scrollHeight);
                                }, timeoutDelay);
                            }
                        }, delay);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('Error:', errorThrown);
                    }
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
