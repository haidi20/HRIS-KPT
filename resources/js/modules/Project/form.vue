<template>
  <div>
    <b-row>
      <b-col cols>
        <b-form-group label="Nama Proyek" label-for="name" class>
          <b-form-input v-model="form.name" id="name" name="name" autocomplete="off"></b-form-input>
        </b-form-group>
      </b-col>
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
      <!-- <b-col cols>
        <b-form-group label="Jenis Pekerjaan" label-for="work_type" class>
          <VueSelect
            id="work_type"
            class="cursor-pointer"
            v-model="form.work_type"
            placeholder="Pilih Jenis Pekerjaan"
            :options="getOptionJobs"
            :reduce="(data) => data.id"
            label="name"
            searchable
            style="min-width: 180px"
          />
        </b-form-group>
      </b-col>-->
    </b-row>
    <b-row>
      <b-col cols>
        <b-form-group label="Jenis Proyek" label-for="type" class>
          <VueSelect
            id="type"
            class="cursor-pointer"
            v-model="form.type"
            placeholder="Pilih Jenis Proyek"
            :options="getOptionTypes"
            :reduce="(data) => data.id"
            label="name"
            searchable
            style="min-width: 180px"
          />
        </b-form-group>
      </b-col>
      <b-col cols>
        <b-form-group label="Perusahaan" label-for="company_id" class>
          <VueSelect
            id="company_id"
            class="cursor-pointer"
            v-model="form.company_id"
            placeholder="Pilih Perusahaan"
            :options="getOptionCompanies"
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
      <b-col cols>
        <b-form-group label="Tanggal Selesai" label-for="date_end">
          <DatePicker
            id="date_end"
            v-model="date_end"
            format="YYYY-MM-DD"
            type="date"
            style="width: 100%"
            :disabled-date="(date, currentValue) => disabledDate(date, currentValue)"
          />
        </b-form-group>
      </b-col>
      <b-col cols>
        <b-form-group label="Lama Pengerjaan" label-for="date_end">
          <span>{{form.date_duration}}</span>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols>
        <b-form-group label="Biaya Proyek" label-for="price" class>
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
      <b-col col md="8">
        <b-form-group label="Catatan" label-for="note" class>
          <b-form-input v-model="form.note" id="note" name="note" autocomplete="off"></b-form-input>
        </b-form-group>
      </b-col>
    </b-row>
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
      return this.$store.state.master.data.barges;
    },
    getOptionCompanies() {
      return this.$store.state.master.data.companies;
    },
    getOptionTypes() {
      return this.$store.state.project.options.types;
    },
    getOptionJobs() {
      return this.$store.state.master.data.jobs;
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
    date_end: {
      get() {
        return this.$store.state.project.form.date_end;
      },
      set(value) {
        this.$store.commit("project/INSERT_FORM_DATE_END", {
          date_end: value,
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
    date_end(value, oldValue) {
      this.$store.commit("project/INSERT_FORM_DATE_DURATION");
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
