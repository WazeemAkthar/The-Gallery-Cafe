document.addEventListener("DOMContentLoaded", function() {
    // Sample data
    const reservations = [
        { name: "John Doe", email: "john@example.com", phone: "1234567890", date: "2024-07-30", time: "19:00" },
    ];
    const menuItems = [
        { item: "Pasta", description: "Delicious homemade pasta", price: "12.99" },
    ];
    const users = [
        { name: "Alice Smith", email: "alice@example.com" },
    ];

    // Reservation Management
    const reservationsTable = document.getElementById('reservations-table').getElementsByTagName('tbody')[0];

    function loadReservations() {
        reservationsTable.innerHTML = '';
        reservations.forEach((reservation, index) => {
            const row = reservationsTable.insertRow();
            row.innerHTML = `
                <td>${reservation.name}</td>
                <td>${reservation.email}</td>
                <td>${reservation.phone}</td>
                <td>${reservation.date}</td>
                <td>${reservation.time}</td>
                <td>
                    <button onclick="editReservation(${index})">Edit</button>
                    <button onclick="deleteReservation(${index})">Delete</button>
                </td>
            `;
        });
    }

    window.editReservation = function(index) {
        const reservation = reservations[index];
        alert('Editing reservation for ' + reservation.name);
    };

    window.deleteReservation = function(index) {
        reservations.splice(index, 1);
        loadReservations();
    };

    document.getElementById('add-reservation-btn').addEventListener('click', () => {
        alert('Adding a new reservation');
    });

    loadReservations();

    // Menu Management
    const menuTable = document.getElementById('menu-table').getElementsByTagName('tbody')[0];

    function loadMenuItems() {
        menuTable.innerHTML = '';
        menuItems.forEach((menuItem, index) => {
            const row = menuTable.insertRow();
            row.innerHTML = `
                <td>${menuItem.item}</td>
                <td>${menuItem.description}</td>
                <td>${menuItem.price}</td>
                <td>
                    <button onclick="editMenuItem(${index})">Edit</button>
                    <button onclick="deleteMenuItem(${index})">Delete</button>
                </td>
            `;
        });
    }

    window.editMenuItem = function(index) {
        const menuItem = menuItems[index];
        alert('Editing menu item ' + menuItem.item);
    };

    window.deleteMenuItem = function(index) {
        menuItems.splice(index, 1);
        loadMenuItems();
    };

    document.getElementById('add-menu-item-btn').addEventListener('click', () => {
        alert('Adding a new menu item');
    });

    loadMenuItems();

    // User Management
    const usersTable = document.getElementById('users-table').getElementsByTagName('tbody')[0];

    function loadUsers() {
        usersTable.innerHTML = '';
        users.forEach((user, index) => {
            const row = usersTable.insertRow();
            row.innerHTML = `
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>
                    <button onclick="deleteUser(${index})">Delete</button>
                </td>
            `;
        });
    }

    window.deleteUser = function(index) {
        users.splice(index, 1);
        loadUsers();
    };

    loadUsers();
});
