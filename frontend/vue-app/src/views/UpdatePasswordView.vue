<template>
<div class="container password-update" id="updatepasswordview">
    <UpdatePassword />
</div>
</template>

<script>
import UpdatePassword from '../components/UpdatePassword';
export default {
    name: "UpdatePasswordView",
    components: {
        UpdatePassword
    }
};
</script>

<style scoped>
#updatepasswordview{
    min-height: 77vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
</style>