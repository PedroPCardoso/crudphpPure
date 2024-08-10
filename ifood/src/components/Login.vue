<template>
    <div class="login">
        <h2>Login</h2>
        <form @submit.prevent="login">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" v-model="email" required />
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" v-model="password" required />
            </div>
            <button type="submit">Login</button>
            <div v-if="message">{{ message }}</div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
            message: ''
        };
    },
    methods: {
        async login() {
            try {
                const response = await fetch('http://localhost:8000/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email: this.email, password: this.password })
                });

                if (response.ok) {
                    const data = await response.json();
                    localStorage.setItem('authToken', data.token);
                    this.$router.push('/users');
                } else {
                    this.message = 'Invalid credentials';
                }
            } catch (error) {
                console.error('Error:', error);
                this.message = 'Error logging in';
            }
        }
    }
};
</script>

<style>
.login {
    max-width: 500px;
    margin: auto;
}
</style>
