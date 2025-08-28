<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Reservation</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f7f7f7; }
        .container { max-width: 500px; margin: auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px #ccc; }
        h1 { text-align: center; }
        label { display: block; margin-top: 15px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; border-radius: 4px; border: 1px solid #ccc; }
        button { margin-top: 20px; width: 100%; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .room-info { margin-top: 10px; font-size: 14px; color: #333; }
        .summary { background: #e9f7ef; padding: 10px; border-radius: 6px; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Hotel Reservation</h1>
    <form id="reservationForm" method="post" action="create_reservation.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="user_email" required>

        <label for="room_select">Room Type:</label>
        <select id="room_select" name="room_num" required></select>
        <div id="room_info" class="room-info"></div>

        <label for="checkin">Check-in Date:</label>
        <input type="date" id="checkin" name="checkin" required>

        <label for="checkout">Check-out Date:</label>
        <input type="date" id="checkout" name="checkout" required>

        <button type="submit">Reserve</button>
    </form>
    <div id="summary" class="summary" style="display:none;"></div>
</div>
<script>
// Fetch rooms and populate selector
fetch('rooms_api.php')
  .then(res => res.json())
  .then(rooms => {
    const select = document.getElementById('room_select');
    const info = document.getElementById('room_info');
    rooms.filter(room => room.available_yn === 'Y').forEach(room => {
      const option = document.createElement('option');
      option.value = room.room_num;
      option.text = `${room.type} (Room #${room.room_num})`;
      option.dataset.price = room.price;
      option.dataset.capacity = room.capacity;
      select.appendChild(option);
    });
    function updateInfo() {
      const selected = select.options[select.selectedIndex];
      info.innerHTML = `<b>Price:</b> $${selected.dataset.price} <br><b>Capacity:</b> ${selected.dataset.capacity}`;
    }
    select.addEventListener('change', updateInfo);
    if (select.options.length > 0) updateInfo();
  });

// Show summary before submit
const form = document.getElementById('reservationForm');
form.addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(form);
  fetch('create_reservation.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    const summary = document.getElementById('summary');
    if (data.success) {
      summary.innerHTML = `<b>Reservación creada correctamente.</b>`;
    } else {
      summary.innerHTML = `<b>Error:</b> ${data.message}`;
    }
    summary.style.display = 'block';
  })
  .catch(err => {
    const summary = document.getElementById('summary');
    summary.innerHTML = `<b>Error de conexión o formato.</b>`;
    summary.style.display = 'block';
  });
});
</script>
</body>
</html>
