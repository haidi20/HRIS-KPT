<template>
  <div>
    <b-modal
      id="roster_form"
      ref="roster_form"
      :title="title_form"
      size="lg"
      class="modal-custom"
      hide-footer
    >
      <b-row>
        <b-col cols>
          <b-form-group
            :label="`Hari Off ${form.work_schedule == '5,2' ? 'Pertama': ''}`"
            label-for="date"
          >
            <VueSelect
              id="day_off_one"
              class="cursor-pointer"
              v-model="form.day_off_one"
              placeholder="Pilih Hari"
              :options="getOptionDays"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
        <b-col cols v-if="form.work_schedule == '5,2'">
          <b-form-group label="Hari Off Kedua" label-for="date">
            <VueSelect
              id="day_off_two"
              class="cursor-pointer"
              v-model="form.day_off_two"
              placeholder="Pilih Hari"
              :options="getOptionDays"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
        <b-col cols>
          <b-form-group label="Tanggal Cuti" label-for="date">
            <DatePicker
              id="date"
              v-model="form.date_vacation"
              format="YYYY-MM-DD"
              type="date"
              placeholder="Pilih Tanggal"
              style="width: 100%"
              range
              :disabled-date="(date, currentValue) => disabledDate(date, currentValue)"
            />
          </b-form-group>
        </b-col>
      </b-row>
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
import VueSelect from "vue-select";

export default {
  data() {
    return {
      title_form: null,
    };
  },
  mounted() {
    //
  },
  components: {
    VueSelect,
  },
  computed: {
    getTitleForm() {
      return this.$store.state.roster.get_title_form;
    },
    getOptionDays() {
      return this.$store.state.roster.options.list_days;
    },
    form() {
      return this.$store.state.roster.form;
    },
  },
  watch: {
    getTitleForm(value, oldValue) {
      this.title_form = value;
    },
  },
  methods: {
    onSend() {
      console.info(this.form);
      this.$bvModal.hide("roster_form");
    },
    onCloseModal() {
      this.$bvModal.hide("roster_form");
    },
    disabledDate(date, currentValue) {
      return date < moment({ date: 1 });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
