<template>
    <div>
        <OrderList />
        <router-view></router-view>
    </div>
</template>

<script>
import OrderList from '../components/OrderList.vue';

export default {
    components: {
        OrderList
    }
}
</script>