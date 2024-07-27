document.addEventListener("DOMContentLoaded", function() {
    // Sample data
    const tasks = [
        "Clean dining area",
        "Prepare kitchen",
        "Check inventory"
    ];

    const reservations = [
        { name: "John Doe", email: "john@example.com", phone: "1234567890", date: "2024-07-30", time: "19:00" },
        // Add more sample reservations
    ];

    const orders = [
        { order: "Order #1", status: "Pending" },
        { order: "Order #2", status: "In Progress" },
        { order: "Order #3", status: "Completed" }
    ];

    // Load Daily Tasks
    const tasksList = document.getElementById('daily-tasks-list');

    function loadTasks() {
        tasksList.innerHTML = '';
        tasks.forEach(task => {
            const li = document.createElement('li');
            li.textContent = task;
            tasksList.appendChild(li);
        });
    }

    document.getElementById('add-task-btn').addEventListener('click', () => {
        const newTask = prompt('Enter new task:');
        if (newTask) {
            tasks.push(newTask);
            loadTasks();
        }
    });

    loadTasks();

    // Load Reservations
    const reservationsTable = document.getElementById('reservations-table').getElementsByTagName('tbody')[0];

    function loadReservations() {
        reservationsTable.innerHTML = '';
        reservations.forEach(reservation => {
            const row = reservationsTable.insertRow();
            row.innerHTML = `
                <td>${reservation.name}</td>
                <td>${reservation.email}</td>
                <td>${reservation.phone}</td>
                <td>${reservation.date}</td>
                <td>${reservation.time}</td>
            `;
        });
    }

    loadReservations();

    // Load Order Statuses
    const ordersList = document.getElementById('order-status-list');

    function loadOrders() {
        ordersList.innerHTML = '';
        orders.forEach(order => {
            const li = document.createElement('li');
            li.textContent = `${order.order} - ${order.status}`;
            ordersList.appendChild(li);
        });
    }

    loadOrders();
});
