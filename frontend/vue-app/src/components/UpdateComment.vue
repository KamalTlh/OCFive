<template>
    <!-- Modal -->
    <div class="modal fade" id="updateComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Commentaire:</label>
                        <textarea class="form-control" id="message-text" v-model="commentContent"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="updateComment">Valider</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import Axios from 'axios';
export default {
    name: 'UpdateComment',
    props: [ 'commentContent', 'commentId' ],
    data() {
      return {
          updateContent: null,
      }
    },
    methods: {
        updateComment(){
            Axios
                .post("https://apiannuaire.jean-forteroche-dwj.fr/index.php", { 
                    route: 'updateComment',
                    id: this.commentId,
                    content: this.commentContent
                    }
                )
                .then( response => {
                    this.commentUpdated = response.data.commentUpdated;
                    this.$parent.getComments();
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.loading = false );
        }
    }
}
</script>

<style>
</style>