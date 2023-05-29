<template>
  <div>
    <b-modal
      id="job_order_modal"
      ref="job_order_modal"
      :title="title_form"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button variant="success" size="sm" class="float-end" @click="onSend()">Kirim</b-button>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title_form: "Daftar Job Order",
    };
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("job_order_modal");
    },
    async onSend() {
      this.$bvModal.hide("job_order_modal");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
