<template>
    <div class="comment">
        <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-right cross" data-toggle="modal" data-target="#form"> <i class="fa fa-times mr-2"></i> </div>
                    <div class="card-body text-center"> <img src=" https://i.imgur.com/d2dKtI7.png" height="100" width="100">
                        <div class="comment-box text-center">
                            <div class="comment-area">
                                <!-- TinyMCE editeur -->
                                <Editor
                                    v-model="textComment"
                                    api-key="dmq04iw9gib4uqvaf08o82m2cvfkr1uau93te34rqcwauf9j"
                                    :init="{
                                        height: 250,
                                        menubar: false,
                                        plugins: [
                                        'advlist autolink lists link image charmap print preview anchor',
                                        'searchreplace visualblocks code fullscreen',
                                        'insertdatetime media table paste code help wordcount'
                                        ],
                                        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | \
                                        alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | \
                                        fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                                        valid_children : '+body[style]',
                                        valid_elements : '*[*]'
                                    }"
                                />
                                <!-- Fin TinyMce -->
                            </div>
                            <div class="text-center mt-4"> <button class="send px-5" data-toggle="modal" data-target="#form" type="submit" @click="sendComment">Envoyer commentaire <i class="fas fa-long-arrow-alt-right ml-1"></i></button> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'

 export default {
    name: 'AddComment',
    props:['workerId'],
    data(){
        return {
            textComment: null
        }
    },
    components: {
        Editor
    },
    methods:{
        /*-- Envoi du commentaire au composant parent --*/
        sendComment(){
            this.$emit('data-commentSent', { 'textComment': this.textComment });
        }
    }
 }
</script>

<style scoped>
html,
body {
    height: 100%
}

body {
    font-family: 'Manrope', sans-serif;
    background: #000
}

.cross {
    padding: 10px;
    color: #d6312d;
    cursor: pointer;
    font-size: 23px
}

.cross i {
    margin-top: -5px;
    cursor: pointer
}

.comment-box {
    padding: 5px
}

.send {
    color: #fff;
    background-color: #ff0000;
    border-color: #ff0000;
    display: inline-block;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
    padding: .375rem .75rem;
        padding-right: 0.75rem;
        padding-left: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    text-transform: inherit;
}

.send:hover {
    color: #fff;
    background-color: #f50202;
    border-color: #f50202;
}
</style>