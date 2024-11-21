<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deneme</title>
</head>
<body>
<script type="module">
    import { io } from "https://cdn.socket.io/4.8.0/socket.io.esm.min.js";

    const uuid = "51b956fb-413e-461f-81fc-46aaf30b47a4"
    const url = "ws://127.0.0.1:3000";
    const socket = io(url);

    // socket.emit('subscribe', uuid);

</script>
</body>
</html>
