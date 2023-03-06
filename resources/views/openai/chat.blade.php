<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container" id="app">
        <h2 class="text-center">ChatGPT</h2>
        <form action="/chat" method="POST">
            @csrf
            <input type="text" name="prompt">
            <button type="submit">Send</button>
        </form>
        <div id="chat">
        </div>

    </div>
    <script>
        $(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/chat',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('#chat').append('<p class="loading">Loading...</p>');
                    },
                    success: function(response) {
                        $('.loading').remove();
                        
                        var responseText = response.response;
                        var message = responseText.split(' ');
                        var i = 0;
                        var delay = 30; // delay between each character
                        var timeoutDelay = 900; // delay between each response
                        var typing = setInterval(function() {
                            $('#chat').append(message[i] + ' ');
                            i++;
                            if (i === message.length) {
                                clearInterval(typing);
                                setTimeout(function() {
                                    $('#chat').append('<br>');
                                    $('#chat').scrollTop($('#chat')[0]
                                        .scrollHeight);
                                }, timeoutDelay);
                            }
                        }, delay);
                        
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>
