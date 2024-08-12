$(document).ready(function() {
    const token = localStorage.getItem('authToken');

    if (!token && !window.location.pathname.includes('login.html')) {
        window.location.href = 'login.html';
    }

    if (window.location.pathname.includes('login.html')) {
        $('#loginForm').submit(function(event) {
            event.preventDefault();
            const email = $('#email').val();
            const password = $('#password').val();
            console.log(email);
            console.log(password);


            $.ajax({
                url: 'http://localhost:8000/login',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ email: email, password: password }),
                success: function(response) {
                    localStorage.setItem('authToken', JSON.parse(response).token);
                    window.location.href = 'users.html';
                },
                error: function() {
                    $('#loginMessage').text('Credenciais inválidas.');
                }
            });
        });
    }

    if (window.location.pathname.includes('users.html')) {
        $.ajax({
            url: 'http://localhost:8000/users',
            type: 'GET',
            headers: { 'Authorization': 'Bearer ' + token },
            success: function(users) {
                let rows = '';
                JSON.parse(users).forEach(user => {
                    rows += `<tr>
                        <td>${user.id}</td>
                        <td>${user.first_name} ${user.last_name}</td>
                        <td>${user.email}</td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="editUser(${user.id})">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Deletar</button>
                        </td>
                    </tr>`;
                });
                $('#userTableBody').html(rows);
            }
        });

        $('#createUserBtn').click(function() {
            // Open a modal or redirect to a form for user creation
            // Implement create user functionality here
        });
    }

    if (window.location.pathname.includes('orders.html')) {
        $.ajax({
            url: 'http://localhost:8000/orders',
            type: 'GET',
            headers: { 'Authorization': 'Bearer ' + token },
            success: function(orders) {
                let rows = '';
                orders.forEach(order => {
                    rows += `<tr>
                        <td>${order.id}</td>
                        <td>${order.description}</td>
                        <td>${order.quantity}</td>
                        <td>${order.price}</td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="editOrder(${order.id})">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteOrder(${order.id})">Deletar</button>
                        </td>
                    </tr>`;
                });
                $('#orderTableBody').html(rows);
            }
        });

        $('#createOrderBtn').click(function() {
            // Open a modal or redirect to a form for order creation
            // Implement create order functionality here
        });
    }
    
});

function editUser(id) {
    // Implement user edit functionality here
    // Redirect to user edit form or open a modal
}

function deleteUser(id) {
    const token = localStorage.getItem('authToken');
    $.ajax({
        url: `http://localhost:8000/users/${id}`,
        type: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token },
        success: function() {
            alert('Usuário deletado com sucesso!');
            location.reload();
        },
        error: function() {
            alert('Erro ao deletar usuário.');
        }
    });
}

function editOrder(id) {
    // Implement order edit functionality here
    // Redirect to order edit form or open a modal
}

function deleteOrder(id) {
    const token = localStorage.getItem('authToken');
    $.ajax({
        url: `http://localhost:8000/orders/${id}`,
        type: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token },
        success: function() {
            alert('Pedido deletado com sucesso!');
            location.reload();
        },
        error: function() {
            alert('Erro ao deletar pedido.');
        }
    });
}

