<template>
<div class="container" id="userupdateview">
    <UserProfileUpdate />
</div>
</template>

<script>
import UserProfileUpdate from '../components/UserProfileUpdate';
export default {
    components: {
        UserProfileUpdate
    },
};
</script>

<style scoped>
#userupdateview{
    min-height: 77vh;
}
</style>