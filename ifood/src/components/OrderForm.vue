<template>
    <div>
        <h2>{{ orderId ? 'Edit Order' : 'Create Order' }}</h2>
        <form @submit.prevent="saveOrder">
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" v-model="order.description" required />
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" v-model="order.quantity" required />
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" v-model="order.price" step="0.01" required />
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            orderId: null,
            order: {
                description: '',
                quantity: 0,
                price: 0
            }
        };
    },
    async created() {
        this.orderId = this.$route.params.id;
        if (this.orderId) {
            this.fetchOrder();
        }
    },
    methods: {
        async fetchOrder() {
            try {
                const response = await fetch(`http://localhost:8000/orders/${this.orderId}`, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                    }
                });
                if (response.ok) {
                    this.order = await response.json();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        },
        async saveOrder() {
            try {
                const method = this.orderId ? 'PUT' : 'POST';
                const url = this.orderId ? `http://localhost:8000/orders/${this.orderId}` : 'http://localhost:8000/orders';

                await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                    },
                    body: JSON.stringify(this.order)
                });
                this.$router.push('/orders');
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }
};
</script>