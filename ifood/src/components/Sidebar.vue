<template>
    <div class="sidebar">
        <nav>
            <ul>
                <li><router-link to="/users">Users</router-link></li>
                <li><router-link to="/orders">Orders</router-link></li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
}
</script>

<style>
.sidebar {
    width: 250px;
    background-color: #f8f9fa;
    position: fixed;
    height: 100%;
    top: 0;
    left: 0;
    padding: 20px;
}

.sidebar nav ul {
    list-style-type: none;
    padding: 0;
}

.sidebar nav ul li {
    margin: 10px 0;
}

.sidebar nav ul li a {
    text-decoration: none;
    color: #007bff;
}
</style>
