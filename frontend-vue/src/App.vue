<template>
    <router-view></router-view>
</template>

<script>
import Index from "./components/page/Index.vue";
export default {
    name: "App",
    components: {
        Index,
    },
};
</script>
