<template>
<div class="container" id="userprofilview">
    <UserProfileDetail />
</div>
</template>

<script>
import UserProfileDetail from '../components/UserProfileDetail';
export default {
    components: {
        UserProfileDetail
    },
};
</script>

<style scoped>
#userprofilview{
    min-height: 77vh;
}
</style>