<template>
    <div>
        <h2>Users</h2>
        <button @click="createUser">Create User</button>
        <ul>
            <li v-for="user in users" :key="user.id">
                {{ user.first_name }} {{ user.last_name }}
                <button @click="editUser(user.id)">Edit</button>
                <button @click="deleteUser(user.id)">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: []
        };
    },
    async created() {
        this.fetchUsers();
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
                    this.users = await response.json();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        },
        createUser() {
            this.$router.push('/create-user');
        },
        editUser(userId) {
            this.$router.push(`/edit-user/${userId}`);
        },
        async deleteUser(userId) {
            try {
                await fetch(`http://localhost:8000/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
                    }
                });
                this.fetchUsers();
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }
};
</script>