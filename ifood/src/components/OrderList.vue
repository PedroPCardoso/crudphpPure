<template>
    <div>
        <h2>Orders</h2>
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
            orders: []
        };
    },
    async created() {
        this.fetchOrders();
    },
    methods: {
        async fetchOrders() {
            try {
                const response = await fetch('http://localhost:8000/orders', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                    }
                });
                if (response.ok) {
                    this.orders = await response.json();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        },
        createOrder() {
            // Logic to create a new order
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
                console.error('Error:', error);
            }
        }
    }
};
</script>

