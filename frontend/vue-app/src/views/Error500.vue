<template>
<div id="snippet-preview" >
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>
                        Oops!</h1>
                    <h2>
                        500 Error Server</h2>
                    <div class="error-details">
                        Sorry, an error has occured, Internal Server Error!
                    </div>
                    <div class="error-actions">
                        <router-link to="/" class="btn btn-primary btn-lg"><i class="fas fa-home"></i>
                            Take Me Home </router-link>
                        <a href="#" class="btn btn-default btn-lg"><i class="fas fa-envelope"></i>
                            Contact Support </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>
#snippet-preview {
    position: relative;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 700px;
    z-index: 50;
}
.body-content { 
    background-image: url(/images/index.png);
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 1.428571429;
    color: #333;
    background-color: #fff;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.error-template {
    padding: 40px 15px;text-align: center;
}
.error-actions {
    margin-top:15px;margin-bottom:15px; 
}
.error-actions .btn { 
    margin-right:10px;
    padding: 10px 16px;
    font-size: 18px;
    line-height: 1.33;
    border-radius: 6px;
}

.error-actions .btn-primary:hover { 
    color: #fff !important;
    background-color: #3276b1 !important;
    border-color: #285e8e !important;
}
.error-actions .btn-default:hover{
    color: #333 !important;
    background-color: #ebebeb !important;
    border-color: #adadad !important;
}
.error-actions .btn-primary {
    color: #fff !important;
    background-color: #428bca !important;
    border-color: #357ebd !important;
}
.error-actions .btn-default {
    color: #333 !important;
    background-color: #fff !important;
    border-color: #ccc !important;
}
</style>