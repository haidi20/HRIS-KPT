<template>
  <div>
    <b-modal
      id="project_form"
      ref="project_form"
      :title="getTitleForm"
      size="lg"
      class="modal-custom"
      hide-footer
    >
      <Form />
      <hr />
      <b-row>
        <b-col cols>
          <b-tabs content-class="mt-3">
            <b-tab title="Kepala Pemborong" @click="onChangeTab('contractor')">
              <ContractorHasParent />
            </b-tab>
            <b-tab title="OS" @click="onChangeTab('os')">
              <OrdinarySeamanHasParent />
            </b-tab>
          </b-tabs>
        </b-col>
      </b-row>
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
import axios from "axios";
import moment from "moment";
import VueSelect from "vue-select";

import Form from "./form";
import ContractorHasParent from "../ContractorHasParent/contractorHasParent";
import OrdinarySeamanHasParent from "../OrdinarySeamanHasParent/ordinarySeamanHasParent";

export default {
  data() {
    return {
      getTitleForm: "Buat Proyek",
      is_loading: false,
    };
  },
  components: {
    Form,
    VueSelect,
    ContractorHasParent,
    OrdinarySeamanHasParent,
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
  watch: {
    //
  },
  methods: {
    onCloseModal() {
      this.$store.commit("project/CLEAR_FORM");
      this.$bvModal.hide("project_form");
    },
    onChangeTab(type) {
      //   console.info(type);
    },
    onSend() {
      console.info(this.form);
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
