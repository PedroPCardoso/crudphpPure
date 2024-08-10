<template>
    <div>
        <UserList />
        <router-view></router-view>
    </div>
</template>

<script>
import UserList from '../components/UserList.vue';

export default {
    components: {
        UserList
    }
}
</script>