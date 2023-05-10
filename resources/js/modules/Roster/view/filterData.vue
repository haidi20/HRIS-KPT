<template>
  <div>
    <b-row>
      <b-col cols>
        <b-form-group label="Bulan" label-for="month" class="place_filter_table">
          <DatePicker
            id="month"
            v-model="params.month"
            format="YYYY-MM"
            type="month"
            placeholder="pilih bulan"
          />
        </b-form-group>
        <b-button
          class="place_filter_table"
          variant="success"
          size="sm"
          @click="onFilter()"
          :disabled="getIsLoadingData"
        >Kirim</b-button>
        <span v-if="getIsLoadingData">Loading...</span>
        <b-button
          class="place_filter_table ml-4"
          variant="success"
          size="sm"
          @click="onExport()"
          :disabled="is_loading_export"
        >
          <i class="fas fa-file-excel"></i>
          Export
        </b-button>
        <span v-if="is_loading_export">Loading...</span>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      is_loading_export: false,
    };
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getIsLoadingData() {
      return this.$store.state.roster.loading.table;
    },
    params() {
      return this.$store.state.roster.params;
    },
  },
  methods: {
    onFilter() {
      this.$store.dispatch("roster/fetchData");
      this.$store.dispatch("roster/fetchTotal");
    },
    async onExport() {
      const Swal = this.$swal;
      this.is_loading_export = true;

      await axios
        .get(`${this.getBaseUrl}/roster/export`, {
          params: {
            user_id: this.getUserId,
            date_filter: moment(this.getDateFilter).format("Y-MM"),
          },
        })
        .then((responses) => {
          //   console.info(responses);
          this.is_loading_export = false;
          const data = responses.data;

          if (data.success) {
            window.open(data.linkDownload, "_blank");
          }
        })
        .catch((err) => {
          this.is_loading_export = false;
          console.info(err);
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });
          Toast.fire({
            icon: "error",
            title: err.response.data.message,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.VueTables__search-field {
  display: none;
}

.place_filter_table {
  align-items: self-end;
  margin-bottom: 0;
  display: inline-block;
}

.table-wrapper {
  overflow-x: auto;
}
</style>
