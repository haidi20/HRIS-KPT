<template>
  <div>
    <b-modal
      id="job_order_filter"
      ref="job_order_filter"
      :title="getTitleForm"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <b-row>
        <b-col cols>
          <b-form-group label="Pilih Jenis Data" label-for="type" class>
            <VueSelect
              id="type"
              class="cursor-pointer"
              v-model="params.type"
              placeholder="Pilih Jenis Data"
              :options="getOptionType"
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
          <b-form-group label="Pilih Data Berdasarkan" label-for="type_by" class>
            <VueSelect
              id="type_by"
              class="cursor-pointer"
              v-model="params.type_by"
              placeholder="Pilih Data Berdasarkan"
              :options="getOptionTypeBy"
              :reduce="(data) => data.id"
              label="name"
              searchable
              style="min-width: 180px"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <b-form-group label="Kata Kunci" label-for="type_by" class>
            <input type="text" placeholder="search..." style="width: 100%" class="form-control" />
          </b-form-group>
        </b-col>
      </b-row>
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" size="sm" class="float-end" @click="onFilter()">Kirim</b-button>
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
      getTitleForm: "Filter Data",
    };
  },
  components: {
    VueSelect,
  },
  computed: {
    getOptionType() {
      return this.$store.state.jobOrder.options.types;
    },
    getOptionTypeBy() {
      return this.$store.state.jobOrder.options.type_bys;
    },
    params() {
      return this.$store.state.jobOrder.params;
    },
  },
  methods: {
    onFilter() {
      this.$bvModal.hide("job_order_filter");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
