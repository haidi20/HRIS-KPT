<template>
  <div>
    <b-modal
      id="job_order_confirmation"
      ref="job_order_confirmation"
      :title="title_form"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button
            v-if="!getReadOnly()"
            style="float: right"
            variant="success"
            @click="onSend()"
            :disabled="is_loading || getIsDisabledBtnSend"
          >Simpan</b-button>
          <span v-if="is_loading" style="float: right">Loading...</span>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script src="../Script/formConfirmation.js"></script>

<style lang="scss" scoped>
</style>
