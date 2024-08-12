<template>
    <div>
        <h2>{{ orderId ? 'Edit Order' : 'Create Order' }}</h2>
        <form @submit.prevent="saveOrder">
            <div class="form-group">
                <label for="user">User:</label>
                <select v-model="order.user_id" required>
                    <option v-for="user in users" :key="user.id" :value="user.id">
                        {{ user.first_name }} {{ user.last_name }}
                    </option>
                </select>
            </div>
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
            users: [], // Array para armazenar a lista de usuários
            order: {
                user_id: '', // Para armazenar o user_id selecionado
                description: '',
                quantity: 0,
                price: 0
            }
        };
    },
    async created() {
        this.orderId = this.$route.params.id;
        this.fetchUsers(); // Carrega a lista de usuários ao criar o componente
        if (this.orderId) {
            this.fetchOrder(); // Carrega a ordem se estiver editando
        }
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
                    this.users = data['data']; // Preenche o array de usuários
                }
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
        async fetchOrder() {
            try {
                const response = await fetch(`http://localhost:8000/orders/${this.orderId}`, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                    }
                });
                if (response.ok) {
                    let data = await response.json();
                    this.order = data['data'];
                }
            } catch (error) {
                console.error('Error fetching order:', error);
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
                console.error('Error saving order:', error);
            }
        }
    }
};
</script>
