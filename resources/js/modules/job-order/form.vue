<template>
  <div>
    <b-modal
      id="form_job_order"
      ref="form_job_order"
      :title="getTitleForm"
      size="xl"
      class="modal-custom"
      hide-footer
    >
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button
            variant="success"
            @click="onSend()"
            :disabled="is_loading"
            style="margin-left: 30px"
          >Simpan</b-button>
          <span v-if="is_loading">Loading...</span>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      is_loading: false,
      getTitleForm: "Tambah Job Order",
    };
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("form_job_order");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
