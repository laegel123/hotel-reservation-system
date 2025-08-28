<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Reservation System - Simple UI</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { margin-top: 40px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        form { margin-bottom: 20px; }
        input, select { padding: 5px; margin: 5px; }
        .section { border: 1px solid #ddd; padding: 20px; margin-bottom: 30px; border-radius: 8px; }
    </style>
</head>
<body>

        <h1>Hotel Reservation System - Simple UI</h1>

        <div class="section">
                <h2>Make Reservation</h2>
                <form method="post" action="create_reservation.php">
                        User Email: <input type="text" name="user_email" required>
                        <label for="room_select">Room Type:</label>
                        <select id="room_select" name="room_num" required></select>
                        <div id="room_info" style="margin-top:10px;"></div>
                        <button type="submit">Make Reservation</button>
                </form>
        </div>

        <script>
        // Fetch rooms and populate selector
        fetch('get_rooms.php')
            .then(res => res.json())
            .then(rooms => {
                const select = document.getElementById('room_select');
                const info = document.getElementById('room_info');
                rooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.room_num;
                    option.text = `${room.type} (Room #${room.room_num})`;
                    option.dataset.price = room.price;
                    option.dataset.available = room.available_yn === 'Y' ? 'Available' : 'Not Available';
                    select.appendChild(option);
                });
                function updateInfo() {
                    const selected = select.options[select.selectedIndex];
                    info.innerHTML = `<b>Price:</b> $${selected.dataset.price} <br><b>Status:</b> ${selected.dataset.available}`;
                }
                select.addEventListener('change', updateInfo);
                if (select.options.length > 0) updateInfo();
            });
        </script>

    <div class="section">
        <h2>Create Room</h2>
        <form method="post" action="create_room.php">
            Room Number: <input type="number" name="room_num" required>
            Type: <input type="text" name="type" required>
            Description: <input type="text" name="description" required>
            Capacity: <input type="number" name="capacity" required>
            Price: <input type="number" step="0.01" name="price" required>
            <button type="submit">Create</button>
        </form>
    </div>

    <div class="section">
        <h2>Create User</h2>
        <form method="post" action="create_user.php">
            Email: <input type="email" name="email" required>
            Name: <input type="text" name="name" required>
            Password: <input type="password" name="password" required>
            Role: <input type="text" name="role" required>
            <button type="submit">Create</button>
        </form>
    </div>

</body>
</html>
