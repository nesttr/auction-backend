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
    <input type="text" name="token" value="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzMyMzcyMDU1LCJleHAiOjE3MzIzNzU2NTUsIm5iZiI6MTczMjM3MjA1NSwianRpIjoiMURiaElRYUNwY2hleVJnVyIsInN1YiI6IjUiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.NUgldYVL1QzMgMNXPKttup-YEtUNk7Un6zHiMQgyDg8">
    <hr>
    <img src="/{{ $auction->pigeon->images[0]->path }}" class="image" alt=""/>
    <h3>{{ $auction->pigeon->code }}</h3>
    <p>Ana Adı : {{ $auction->pigeon->mother_name }}</p>
    <p>Baba Adı : {{ $auction->pigeon->father_name }}</p>
    <hr>
    <h3>Geçmiş</h3>
    <ul class="history-list">

    </ul>
    <p id="demo" style="font-size: 25px; text-align: center;"></p>
    <div id="pageTimer"></div>
    <form action="javascript:void(0)">
        <input type="text" name="bid">
        <button type="submit" id="bid">Pey Ver</button>
    </form>
    <br/>
    <form action="javascript:void(0)">
        <input type="text" name="automatic-bid">
        <button type="submit" id="automatic-bid">Otomatik Pey Ver</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/countdown.js') }}"></script>
<script>
    const endDate = new Date('{{ $auction->end_date->format('Y-m-d H:i:s') }}');
    countdown('#demo', endDate, function () {
        console.log('done');
    })
</script>
<script type="module">
    import {io} from "https://cdn.socket.io/4.8.0/socket.io.esm.min.js";

    const jwt = $('input[name=token]').val()
    const uuid = "{{ $auction->uuid }}"
    const url = "ws://localhost:3000";
    const socket = io(url);

    socket.emit('subscribe', uuid);

    socket.on('history', (data) => {
        let html = "";
        for (let k of data) {
            html += `<li>${k.bid} - ${k.register_number}</li>`;
        }
        $(".history-list").html(html);
    });
    $('#bid').click(() => {
        const bid = $("input[name=bid]").val();
        $.ajax({
            url: "{{ route('auction.bid', ["uuid" => $auction->uuid]) }}",
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${jwt}`,
            },
            data: {
                bid: bid
            },
            success: function () {
                $("input[name=bid]").val('')
            }
        });
    });
    $("#automatic-bid").click(() => {
        const bid = $("input[name=automatic-bid]").val();
        $.ajax({
            url: "{{ route('auction.auto.bid', ["uuid" => $auction->uuid]) }}",
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${jwt}`,
            },
            data: {
                bid: bid
            },
            success: function () {
                $("input[name=bid]").val('')
            }
        });
    });

</script>
</body>
</html>
