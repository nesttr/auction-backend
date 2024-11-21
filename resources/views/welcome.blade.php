<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deneme</title>
</head>
<body>
<style>
    .history {
    }

    .image {
        width: 100px;
        height: 100px;
    }
</style>
<div class="history">
    <img src="/{{ $auction->pigeon->images[0]->path }}" class="image" alt=""/>
    <h3>{{ $auction->pigeon->code }}</h3>
    <p>Ana Adı : {{ $auction->pigeon->mother_name }}</p>
    <p>Baba Adı : {{ $auction->pigeon->father_name }}</p>
    <hr>
    <h3>Geçmiş</h3>
    <ul class="history-list">

    </ul>
    <form action="javascript:void(0)">
        <input type="text" name="bid">
        <button type="submit">Pey Ver</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type="module">
    import {io} from "https://cdn.socket.io/4.8.0/socket.io.esm.min.js";

    const jwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzMyMjE4MzczLCJleHAiOjE3MzIyMjE5NzMsIm5iZiI6MTczMjIxODM3MywianRpIjoicVFXWW9OYlJDazA4d2loZCIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.44mKrfh1Ny4FNbUNHgUl0JZpmCMfc9CR7E4cBxSBOnI";
    const uuid = "{{ $auction->uuid }}"
    const url = "ws://127.0.0.1:3000";
    const socket = io(url);

    socket.emit('subscribe', uuid);

    socket.on('history', (data) => {
        console.log( data);
        let html = "";
        for (let k of data) {
            html += `<li>${k.bid} - ${k.register_number}</li>`;
        }
        $(".history-list").html(html);
    });

    $("button[type=submit]").click(() => {
        const bid = $("input[name=bid]").val();
        $.ajax({
            url: "{{ route('auction.bid', ["uuid" => $auction->uuid]) }}",
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${jwt}`,
            },
            data: {
                bid:bid
            },
            success: function (response) {
            },
            error: function (xhr, status, error) {
                console.log(error.message)
            }
        });
    });

</script>
</body>
</html>
