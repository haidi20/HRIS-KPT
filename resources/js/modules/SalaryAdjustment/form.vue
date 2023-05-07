<template>
  <div>
    <b-modal
      id="salary_adjustment_form"
      ref="salary_adjustment_form"
      :title="getTitleForm"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <b-row>
        <b-col cols>
          <b-form-group label="Nama " label-for="name" class>
            <b-form-input v-model="form.name" id="name" name="name"></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <br />
      <b-row class="float-end">
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button variant="success" @click="onSend()" class="ml-8" :disabled="is_loading">Simpan</b-button>
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
      getTitleForm: "Tambah Penyesuaian Gaji",
    };
  },
  computed: {
    form() {
      return this.$store.state.salaryAdjustment.form;
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
