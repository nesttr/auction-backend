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
    <form action=""></form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type="module">
    import {io} from "https://cdn.socket.io/4.8.0/socket.io.esm.min.js";

    const uuid = "{{ $auction->uuid }}"
    const url = "ws://127.0.0.1:3000";
    const socket = io(url);

    socket.emit('subscribe', uuid);

    socket.on('history', (data) => {
        let html = "";
        for (let k of data) {
            html += `<li>${k.bid} - ${k.register_number}</li>`;
        }
        $(".history-list").html(html);
    });

</script>
</body>
</html>
