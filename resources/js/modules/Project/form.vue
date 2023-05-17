<template>
  <div>
    <b-modal
      id="project_form"
      ref="project_form"
      :title="getTitleForm"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
          <b-button
            style="float: right"
            variant="success"
            @click="onSend()"
            :disabled="is_loading"
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
      getTitleForm: "Buat Proyek",
      is_loading: false,
    };
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    form() {
      return this.$store.state.project.form;
    },
  },
  methods: {
    onCloseModal() {
      this.$store.commit("project/CLEAR_FORM");
      this.$bvModal.hide("project_form");
    },
    async onSend() {
      this.$bvModal.hide("project_form");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
