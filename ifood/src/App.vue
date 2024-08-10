<template>
  <div id="app">
    <Sidebar />
    <div class="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Sidebar from './components/Sidebar.vue';

export default {
  components: {
    Sidebar
  }
}
</script>

<style>
#app {
  display: flex;
}

.content {
  margin-left: 250px;
  padding: 20px;
}
</style>
