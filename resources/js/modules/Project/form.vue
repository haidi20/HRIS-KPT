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
      <b-row>
        <b-col cols>
          <b-form-group label="Nama Proyek" label-for="name" class>
            <b-form-input v-model="form.name" id="name" name="name" autocomplete="off"></b-form-input>
          </b-form-group>
        </b-col>
        <b-col cols>
          <b-form-group label="Jenis Pekerjaan" label-for="work_type" class>
            <VueSelect
              id="work_type"
              class="cursor-pointer"
              v-model="form.work_type"
              placeholder="Pilih Jenis Pekerjaan"
              :options="getOptionWorkTypes"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols>
          <b-form-group label="Kapal" label-for="barge_id" class>
            <VueSelect
              id="barge_id"
              class="cursor-pointer"
              v-model="form.barge_id"
              placeholder="Pilih Kapal"
              :options="getOptionBarges"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
        <b-col cols>
          <b-form-group label="Jenis Proyek" label-for="barge_id" class>
            <VueSelect
              id="barge_id"
              class="cursor-pointer"
              v-model="form.barge_id"
              placeholder="Pilih Jenis Proyek"
              :options="getOptionTypes"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols>
          <b-form-group label="Pengawas" label-for="foreman_id" class>
            <VueSelect
              id="foreman_id"
              class="cursor-pointer"
              v-model="form.foreman_id"
              placeholder="Pilih Pengawas"
              :options="getOptionForemans"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
        <b-col cols>perusahaan</b-col>
        <b-col cols>
          <b-form-group label="Tanggal Selesai" label-for="date_end">
            <DatePicker
              id="date_end"
              v-model="form.date_end"
              format="YYYY-MM-DD"
              type="date"
              placeholder="Pilih Tanggal Selesai"
              style="width: 100%"
              :disabled-date="(date, currentValue) => disabledDate(date, currentValue)"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols>
          <b-form-group label="Biaya" label-for="price" class>
            <b-form-input v-model="price" id="price" name="price" autocomplete="off"></b-form-input>
          </b-form-group>
        </b-col>
        <b-col cols>
          <b-form-group label="DP (Down Payment) " label-for="down_payment" class>
            <b-form-input
              v-model="down_payment"
              id="down_payment"
              name="down_payment"
              autocomplete="off"
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col cols>
          <b-form-group label="Sisa Yang Dibayarkan" label-for="remaining_payment" class>
            <b-form-input
              v-model="form.remaining_payment_readable"
              id="remaining_payment"
              name="remaining_payment"
              autocomplete="off"
              disabled
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col col md="4">
          <b-form-group label="Catatan" label-for="note" class>
            <b-form-input v-model="form.note" id="note" name="note" autocomplete="off"></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols>
          <b-tabs content-class="mt-3">
            <b-tab title="Kapal" @click="onChangeTab('barge')" active>kapal</b-tab>
            <b-tab title="Kepala Pemborong" @click="onChangeTab('contractor_head')">Kepala Pemborong</b-tab>
            <b-tab title="OS" @click="onChangeTab('os')">OS</b-tab>
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

export default {
  data() {
    return {
      getTitleForm: "Buat Proyek",
      is_loading: false,
    };
  },
  components: {
    VueSelect,
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getOptionBarges() {
      return this.$store.state.project.options.barges;
    },
    getOptionTypes() {
      return this.$store.state.project.options.types;
    },
    getOptionWorkTypes() {
      return this.$store.state.project.options.work_types;
    },
    getOptionForemans() {
      return this.$store.state.employee.data.foremans;
    },
    form() {
      return this.$store.state.project.form;
    },
    price: {
      get() {
        return this.$store.state.project.form.price_readable;
      },
      set(value) {
        this.$store.commit("project/INSERT_FORM_PRICE", {
          price: value,
        });
      },
    },
    down_payment: {
      get() {
        return this.$store.state.project.form.down_payment_readable;
      },
      set(value) {
        this.$store.commit("project/INSERT_FORM_DOWN_PAYMENT", {
          down_payment: value,
        });
      },
    },
  },
  watch: {
    price(value, oldValue) {
      this.$store.commit("project/INSERT_FORM_REMAINING_PAYMENT");
    },
    down_payment(value, oldValue) {
      this.$store.commit("project/INSERT_FORM_REMAINING_PAYMENT");
    },
  },
  methods: {
    onCloseModal() {
      this.$store.commit("project/CLEAR_FORM");
      this.$bvModal.hide("project_form");
    },
    onChangeTab(type) {
      console.info(type);
    },
    async onSend() {
      this.$bvModal.hide("project_form");
    },
    disabledDate(date, currentValue) {
      return date <= moment();
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
