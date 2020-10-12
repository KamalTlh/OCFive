<template>
    <!-- Modal -->
    <div class="modal fade" id="showComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-body">
                {{ commentContent }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ReadComment',
    props: {
        commentContent: String
    },
    data() {
      return {
      }
    },
}
</script>

<style>

</style>