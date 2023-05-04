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
          <b-form-group label="Pilih Jenis Data" label-for="data_type" class>
            <VueSelect
              id="data_type"
              class="cursor-pointer"
              v-model="params.data_type"
              placeholder="Pilih Jenis Data"
              :options="getOptionTypeData"
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
          <input type="text" placeholder="search..." style="width: 100%" class="form-control" />
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
    getOptionTypeData() {
      return this.$store.state.jobOrder.options.data_types;
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
