<template>
    <div>
        <h2>Orders</h2>
        <label for="userFilter">Filter by User:</label>
        <select id="userFilter" v-model="selectedUser" @change="fetchOrders">
            <option value="">All Users</option>
            <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.first_name }} {{ user.last_name }}
            </option>
        </select>

        <button @click="createOrder">Create Order</button>
        <ul>
            <li v-for="order in orders" :key="order.id">
                Description: {{ order.description }}, Quantity: {{ order.quantity }}, Price: {{ order.price }}
                <button @click="editOrder(order.id)">Edit</button>
                <button @click="deleteOrder(order.id)">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            orders: [],
            users: [],
            selectedUser: ''  
        };
    },
    async created() {
        this.fetchUsers();  
        this.fetchOrders(); 
    },
    methods: {
        async fetchUsers() {
            try {
                const response = await fetch('http://localhost:8000/users', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                    }
                });
                if (response.ok) {
                    let data = await response.json();
                    this.users = data['data'];
                }
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
        async fetchOrders() {
            try {
                let url = 'http://localhost:8000/orders';

                if (this.selectedUser) {
                    url += `?user_id=${this.selectedUser}`; // Adiciona o filtro de usuário à URL
                }

                const response = await fetch(url, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                    }
                });
                if (response.ok) {
                    let data = await response.json();
                    this.orders = data['data'];
                }
            } catch (error) {
                console.error('Error fetching orders:', error);
            }
        },
        createOrder() {
            this.$router.push({ path: `/create-order` });
        },
        editOrder(orderId) {
            this.$router.push({ path: `/edit-order/${orderId}` });
        },
        async deleteOrder(orderId) {
            try {
                await fetch(`http://localhost:8000/orders/${orderId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                    }
                });
                this.fetchOrders();
            } catch (error) {
                console.error('Error deleting order:', error);
            }
        }
    }
};
</script>
