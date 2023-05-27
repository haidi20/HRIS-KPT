<template>
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Penyesuaian Gaji</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">Penyesuaian Gaji</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <section class="section">
      <div class="card">
        <div class="card-header">
          Data
          <button
            @click="onCreate"
            class="btn btn-sm btn-success shadow-sm float-end ml-2"
            id="addData"
            data-toggle="modal"
          >
            <i class="fas fa-plus text-white-50"></i> Tambah
          </button>
        </div>

        <div class="card-body">
          <Table />
        </div>
      </div>
    </section>
    <Form />
  </div>
</template>

<script>
import Form from "./form";
import Table from "./table";

export default {
  props: {
    user: String,
    baseUrl: String,
  },
  components: {
    Table,
    Form,
  },
  mounted() {
    // this.$bvModal.show("salary_adjustment_form");
    this.$store.commit("INSERT_BASE_URL", { base_url: this.baseUrl });
    this.$store.commit("INSERT_USER", { user: JSON.parse(this.user) });

    ["salaryAdjustment", "employee", "master"].map((item) => {
      this.$store.commit(`${item}/INSERT_BASE_URL`, {
        base_url: this.baseUrl,
      });
    });

    this.$store.dispatch("fetchPermission");
    this.$store.dispatch("master/fetchPosition");
    this.$store.dispatch("employee/fetchOption");
    this.$store.dispatch("salaryAdjustment/fetchData");
  },
  methods: {
    onCreate() {
      this.$store.commit("salaryAdjustment/CLEAR_FORM");
      this.$bvModal.show("salary_adjustment_form");
      this.$store.commit("salaryAdjustment/INSERT_FORM_FORM_TYPE", {
        form_type: "detail",
      });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
