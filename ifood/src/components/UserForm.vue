<template>
    <div>
        <h2>{{ userId ? 'Edit User' : 'Create User' }}</h2>
        <form @submit.prevent="saveUser">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" v-model="user.first_name" required />
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" v-model="user.last_name" required />
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" v-model="user.email" required />
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" v-model="user.password" />
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            userId: null,
            user: {
                first_name: '',
                last_name: '',
                email: '',
                password: ''
            }
        };
    },
    async created() {
        this.userId = this.$route.params.id;
        if (this.userId) {
            this.fetchUser();
        }
    },
    methods: {
        async fetchUser() {
            try {
                const response = await fetch(`http://localhost:8000/users/${this.userId}`, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                    }
                });
                if (response.ok) {
                    this.user = await response.json();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        },
        async saveUser() {
            try {
                const method = this.userId ? 'PUT' : 'POST';
                const url = this.userId ? `http://localhost:8000/users/${this.userId}` : 'http://localhost:8000/users';

                await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                    },
                    body: JSON.stringify(this.user)
                });
                this.$router.push('/users');
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }
};
</script>
