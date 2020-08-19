<template>
    <div>
        <!-- Side Modal Top Right -->
        <mdb-modal side position="top-right" direction="right" :show="modal" @close="modal = false">
            <mdb-modal-header>
                <mdb-modal-title>Bienvue</mdb-modal-title>
            </mdb-modal-header>
            <mdb-modal-body>
                <h3>Bonjour! Bonne navigation!</h3>
            </mdb-modal-body>
            <mdb-modal-footer>
                <mdb-btn color="secondary" @click.native="modal = false">Close</mdb-btn>
            </mdb-modal-footer>
        </mdb-modal>
    </div>
</template>

<script>
  import { mdbModal, mdbModalHeader, mdbModalTitle, mdbModalBody, mdbModalFooter, mdbBtn } from 'mdbvue';
  export default {
    name: 'Logout',
    components: {
      mdbModal,
      mdbModalHeader,
      mdbModalTitle,
      mdbModalBody,
      mdbModalFooter,
      mdbBtn
    },
    data() {
      return {
        modal: false
      };
    }
  };
</script>

<style>
</style>
