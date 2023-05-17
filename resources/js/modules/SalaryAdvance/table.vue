<template>
  <div>
    <b-row style="margin-top: 10px">
      <b-col cols>
        <b-button variant="info" size="sm" class @click="onFilter()">Filter</b-button>
      </b-col>
      <b-col cols style="align-item: right">
        <b-button variant="success" size="sm" class="float-end" @click="onCreate()">Tambah</b-button>
      </b-col>
    </b-row>
    <br />
    <b-row>
      <b-col class="place-data">
        <template v-if="getLoadingTable">
          <b-tr>
            <b-td>Loading...</b-td>
          </b-tr>
        </template>
        <template v-else-if="getData.length > 0">
          <b-row v-for="(data, index) in getData" :key="index">
            <b-col class="place-item" @click="onOpenAction(data)">
              <h5>{{data.employee_name}} - {{data.position_name}}</h5>
              <div class="flex flex-row">
                <div class="flex-grow-2 flex flex-col">
                  <span>
                    <b>Jumlah Kasbon :</b>
                  </span>
                  <span>{{data.loan_amount_readable}}</span>

                  <span class="title-item">
                    <b>Keterangan :</b>
                  </span>
                  <span>{{data.reason}}</span>
                  <template v-if="data.approval_status == 'accept'">
                    <span class="title-item">
                      <b>Potongan Setiap Bulan :</b>
                    </span>
                    <span>{{data.monthly_deduction}}</span>
                  </template>
                  <template v-if="data.approval_status == 'reject'">
                    <span class="title-item">
                      <b>Catatan :</b>
                    </span>
                    <span>{{data.note}}</span>
                  </template>
                  <!-- <span class="title-item">Sudah Terbayarkan :</span>
                <span>Rp. 500.000</span>
                <span class="title-item">Belum Terbayarkan :</span>
                  <span>Rp. 1.000.000</span>-->
                </div>
                <div class="flex-grow flex flex-col">
                  <span>
                    <b>Status :</b>
                  </span>
                  <span
                    :class="`badge bg-${data.approval_color}`"
                    style="width:5rem"
                  >{{data.approval_status}}</span>
                  <template v-if="data.approval_status == 'accept'">
                    <span class="title-item">
                      <b>Durasi :</b>
                    </span>
                    <span>{{data.duration}}</span>
                  </template>
                </div>
              </div>
            </b-col>
          </b-row>
        </template>
        <template v-else>
          <b-tr>
            <b-td>Data Kosong</b-td>
          </b-tr>
        </template>
        <vue-bottom-sheet ref="myBottomSheet" max-height="30%">
          <div class="flex flex-col">
            <div class="action-item">ubah</div>
            <div class="action-item" @click="onDelete">hapus</div>
          </div>
        </vue-bottom-sheet>
      </b-col>
    </b-row>
    <FilterData />
    <Form />
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import Form from "./form";
import FilterData from "./filter";
export default {
  data() {
    return {
      title: "",
    };
  },
  components: {
    FilterData,
    Form,
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user?.id;
    },
    getData() {
      return this.$store.state.salaryAdvance.data;
    },
    getLoadingTable() {
      return this.$store.state.salaryAdvance.loading.table;
    },
    form() {
      return this.$store.state.salaryAdvance.form;
    },
  },
  watch: {
    getBaseUrl(value, oldValue) {
      if (value != null) {
        this.$store.dispatch("salaryAdvance/fetchData", {
          user_id: this.getUserId,
        });
      }
    },
  },
  methods: {
    onOpenAction(data) {
      this.$store.commit("salaryAdvance/INSERT_FORM", {
        form: data,
      });

      this.$refs.myBottomSheet.open();
    },
    onCreate() {
      //   console.info("create");
      this.$refs.myBottomSheet.close();
      this.$store.commit("salaryAdvance/CLEAR_FORM");
      this.$bvModal.show("salary_advance_form");
    },
    onFilter() {
      this.$bvModal.show("salary_advance_filter");
    },
    async onDelete() {
      this.$refs.myBottomSheet.close();
      //   console.info(this.form);
      const Swal = this.$swal;
      await Swal.fire({
        title: "Perhatian!!!",
        html: `Anda yakin ingin hapus data kasbon dari karyawan ${this.form.employee_name} ?</h2>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya hapus",
        cancelButtonText: "Batal",
      }).then(async (result) => {
        if (result.isConfirmed) {
          await axios
            .post(`${this.getBaseUrl}/api/v1/salary-advance/delete`, {
              id: this.form.id,
              user_id: this.getUserId,
            })
            .then((responses) => {
              //   console.info(responses);
              const data = responses.data;

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

              if (data.success == true) {
                Toast.fire({
                  icon: "success",
                  title: data.message,
                });

                this.$store.dispatch("salaryAdvance/fetchData", {
                  user_id: this.getUserId,
                });
              }
            })
            .catch((err) => {
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
        }
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.place-data {
  max-height: 500px;
  overflow-y: scroll;
}
.place-data::-webkit-scrollbar {
  display: none;
}
.place-item {
  border-bottom: 1px solid #dbdfea;
  padding: 0.5rem;
}
.action-item {
  padding: 25px 0px 25px 20px;
  border-bottom: 1px solid #dbdfea;
}
.title-item {
  margin-top: 10px;
}
</style>
