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
            Room: <input type="number" name="room_num" required>
            Status: <select name="status">
                <option value="hold">Hold</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="checked_in">Checked In</option>
                <option value="checked_out">Checked Out</option>
                <option value="cancelled">Cancelled</option>
            </select>
            Memo: <input type="text" name="memo">
            <button type="submit">Make Reservation</button>
        </form>
    </div>

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
