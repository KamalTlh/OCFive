<template>
    <div class="comment">
        <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-right cross" data-toggle="modal" data-target="#form"> <i class="fa fa-times mr-2"></i> </div>
                    <div class="card-body text-center"> <img src=" https://i.imgur.com/d2dKtI7.png" height="100" width="100">
                        <div class="comment-box text-center">
                            <!-- <h4>Add a comment</h4> -->
                            <div class="comment-area">
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
                                        toolbar:
                                        'undo redo | formatselect | bold italic backcolor | \
                                        alignleft aligncenter alignright alignjustify | \
                                        bullist numlist outdent indent | removeformat | help'
                                    }"
                                />
                            </div>
                            <!-- <textarea class="form-control" placeholder="what is your view?" rows="4"></textarea>  -->
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
        sendComment(){
            this.$emit('data-commentSent', { 'textComment': this.textComment });
        }
    }
 }
</script>

<style>

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

.comment-area textarea {
    resize: none;
    border: 1px solid #ff0000
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #ffffff;
    outline: 0;
    box-shadow: 0 0 0 1px rgb(255, 0, 0) !important
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
}

.send:hover {
    color: #fff;
    background-color: #f50202;
    border-color: #f50202;
}

.rating {
    display: inline-flex;
    margin-top: -10px;
    flex-direction: row-reverse
}

.rating>input {
    display: none
}

.rating>label {
    position: relative;
    width: 28px;
    font-size: 35px;
    color: #ff0000;
    cursor: pointer
}

.rating>label::before {
    content: "\2605";
    position: absolute;
    opacity: 0
}

.rating>label:hover:before,
.rating>label:hover~label:before {
    opacity: 1 !important
}

.rating>input:checked~label:before {
    opacity: 1
}

.rating:hover>input:checked~label:before {
    opacity: 0.4
}
</style>