<template>
  <div>
    <b-modal
      id="job_order_form"
      ref="job_order_form"
      :title="getTitleForm"
      size="lg"
      class="modal-custom"
      hide-footer
    >
      <b-row>
        <b-col cols>
          <b-form-group label="Proyek" label-for="project_id" class>
            <VueSelect
              id="project_id"
              class="cursor-pointer"
              v-model="form.project_id"
              placeholder="Pilih Proyek"
              :options="getOptionProjects"
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
          <b-form-group label="Kode" label-for="code" class>
            <b-form-input v-model="form.code" id="code" name="code"></b-form-input>
          </b-form-group>
        </b-col>
        <b-col cols>
          <b-form-group label="Kategori" label-for="category_id" class>
            <VueSelect
              id="category_id"
              class="cursor-pointer"
              v-model="form.category_id"
              placeholder="Pilih Kategori"
              :options="getOptionCategory"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols sm="12" md="6">
          <b-form-group label="Pekerjaan" label-for="job_id" class>
            <VueSelect
              id="job_id"
              class="cursor-pointer"
              v-model="form.job_id"
              placeholder="Pilih Pekerjaan"
              :options="getOptionJobs"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
        <b-col cols sm="12" md="6">
          <b-form-group label="Keterangan Jenis Pekerjaan" label-for="type_job_note" class>
            <b-form-input v-model="form.type_job_note" id="type_job_note" name="type_job_note"></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols>
          <b-form-group label="Jam Mulai" label-for="hour_start" class>
            <!-- <b-form-input type="hour" v-model="form.hour_start" id="hour_start" name="hour_start"></b-form-input> -->
            <input
              type="time"
              class="form-control"
              v-model="form.hour_start"
              id="hour_start"
              name="hour_start"
            />
          </b-form-group>
        </b-col>
        <b-col cols>
          <b-form-group label="Estimasi Waktu" label-for="estimation" class>
            <b-form-input v-model="form.estimation" id="estimation" name="estimation"></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col col sm="6">
          <b-form-group label="Jenis Waktu" label-for="type_time" class>
            <VueSelect
              id="type_time"
              class="cursor-pointer"
              v-model="form.type_time"
              placeholder="Pilih Jenis Waktu"
              :options="getOptionTypTime"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
        <b-col col sm="6">
          <b-form-group label="Waktu Selesai" label-for="type_time" class>
            <span>Senin, 25 Mei 2023 13:00</span>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols>
          <b-form-group label="Tingkat Kesulitan" label-for="job_level" class>
            <VueSelect
              id="job_level"
              class="cursor-pointer"
              v-model="form.job_level"
              placeholder="Pilih Pekerjaan"
              :options="getOptionJobLevels"
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
          <b-form-group label="Masukkan Foto" label-for="image" class>
            <b-form-file id="image" v-model="form.image"></b-form-file>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col col sm="6">
          <b-form-group label="Pilih Karyawan" label-for="image" class>
            <b-button variant="success" @click="onShowEmployee()">Data Karyawan</b-button>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols>
          <b-form-group label="Keterangan" label-for="note" class>
            <b-form-input v-model="form.note" id="note" name="note"></b-form-input>
          </b-form-group>
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
      <Employee />
    </b-modal>
  </div>
</template>

<script>
import VueSelect from "vue-select";
import Employee from "../employee/view/employee";

export default {
  data() {
    return {
      is_loading: false,
      getTitleForm: "Tambah Job Order",
    };
  },
  mounted() {
    // this.$bvModal.show("data_employee");
    this.$store.commit("employee/UPDATE_IS_FORM_MOBILE", {
      value: true,
    });
  },
  components: {
    VueSelect,
    Employee,
  },
  computed: {
    getOptionProjects() {
      return this.$store.state.jobOrder.options.projects;
    },
    getOptionCategory() {
      return this.$store.state.jobOrder.options.categories;
    },
    getOptionJobs() {
      return this.$store.state.jobOrder.options.jobs;
    },
    getOptionJobLevels() {
      return this.$store.state.jobOrder.options.job_levels;
    },
    getOptionTypTime() {
      return this.$store.state.jobOrder.options.type_times;
    },
    form() {
      return this.$store.state.jobOrder.form;
    },
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("job_order_form");
    },
    onShowEmployee() {
      this.$bvModal.show("data_employee");
    },
    onSend() {
      this.$bvModal.hide("job_order_form");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
