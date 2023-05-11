<template>
  <div>
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
  </div>
</template>

<script>
export default {
  data() {
    return {
      is_loading: false,
    };
  },
  computed: {
    getTitleForm() {
      return this.$store.state.jobOrder.form.form_title;
    },
  },
  methods: {
    onCloseModal() {
      this.$store.commit("jobOrder/INSERT_FORM_KIND", {
        form_title: "data job order",
        form_kind: null,
      });
      this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
        value: false,
      });
      this.$bvModal.hide("job_order_form_action");
    },
    onSend() {
      this.$store.commit("jobOrder/INSERT_FORM_KIND", {
        form_title: "data job order",
        form_kind: null,
      });
      this.$store.commit("jobOrder/UPDATE_IS_ACTIVE_FORM", {
        value: false,
      });
      this.$bvModal.hide("job_order_form_action");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
