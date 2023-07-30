<template>
  <div>
    <b-modal
      id="overtime_modal"
      ref="overtime_modal"
      :title="title_form"
      size="md"
      class="modal-custom"
      hide-footer
    >
      <b-tabs content-class="mt-3">
        <b-tab title="input" active>
          <b-row>
            <b-col cols>
              <b-row>
                <b-col cols>
                  <b-form-group label="Tanggal Mulai" label-for="date_start">
                    <DatePicker
                      id="date_start"
                      v-model="form.date_start"
                      format="YYYY-MM-DD"
                      type="date"
                      placeholder="pilih Tanggal"
                      style="width: 100%"
                    />
                  </b-form-group>
                </b-col>
                <b-row>
                  <b-col cols>
                    <b-form-group label="Jam Mulai" label-for="hour_start_overtime">
                      <input
                        type="time"
                        class="form-control"
                        v-model="form.hour_start_overtime"
                        id="hour_start_overtime"
                        name="hour_start_overtime"
                      />
                    </b-form-group>
                  </b-col>
                </b-row>
              </b-row>
            </b-col>
            <b-col cols>
              <b-row>
                <b-col cols>
                  <b-form-group label="Tanggal Selesai" label-for="date_end">
                    <DatePicker
                      id="date_end"
                      v-model="form.date_end"
                      format="YYYY-MM-DD"
                      type="date"
                      placeholder="pilih Tanggal"
                      style="width: 100%"
                    />
                  </b-form-group>
                </b-col>
                <b-row>
                  <b-col cols>
                    <b-form-group label="Jam Selesai" label-for="hour_end_overtime">
                      <input
                        type="time"
                        class="form-control"
                        v-model="form.hour_end_overtime"
                        id="hour_end_overtime"
                        name="hour_end_overtime"
                      />
                    </b-form-group>
                  </b-col>
                </b-row>
              </b-row>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <b-form-group label="Keterangan" label-for="note">
                <b-form-textarea
                  v-model="form.note"
                  id="note"
                  name="note"
                  autocomplete="off"
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
              </b-form-group>
            </b-col>
          </b-row>
        </b-tab>
        <b-tab title="data">
          <DatatableClient
            :data="getDataOvertime"
            :columns="columns"
            :options="options"
            nameStore="jobOrder"
            nameLoading="table_overtime_base_user"
            :filter="true"
            :footer="false"
            bordered
          >
            <template v-slot:filter>
              <b-col cols>
                Data SPL
                <!-- <i class="fas fa-cogs"></i> -->
              </b-col>
            </template>
            <template v-slot:tbody="{ filteredData }">
              <b-tr v-for="(item, index) in filteredData" :key="index">
                <b-td v-for="column in getColumns()" :key="column.label">{{ item[column.field] }}</b-td>
              </b-tr>
            </template>
          </DatatableClient>
        </b-tab>
      </b-tabs>
      <br />
      <b-row>
        <b-col>
          <b-button variant="info" @click="onCloseModal()">Tutup</b-button>
        </b-col>
        <b-col style="text-align: right;">
          <span v-if="is_loading">Loading...</span>
          <b-button variant="success" @click="onSend()" :disabled="is_loading">Kirim</b-button>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";

import DatatableClient from "../../../components/DatatableClient";

export default {
  data() {
    return {
      is_loading: false,
      title_form: "SPL (surat perintah lembur)",
      options: {
        perPage: 5,
        // perPageValues: [5, 10, 25, 50, 100],
      },
      columns: [
        {
          label: "Waktu Mulai",
          field: "datetime_start_readable",
          width: "200px",
          class: "",
        },
        {
          label: "Waktu Selesai",
          field: "datetime_end_readable",
          width: "200px",
          class: "",
        },
        {
          label: "Durasi",
          field: "duration_readable",
          width: "200px",
          class: "",
        },
      ],
    };
  },
  components: {
    DatatableClient,
  },
  computed: {
    getBaseUrl() {
      return this.$store.state.base_url;
    },
    getUserId() {
      return this.$store.state.user.id;
    },
    getDataOvertime() {
      return this.$store.state.jobOrder.table.overtime_base_user;
    },
    form() {
      return this.$store.state.jobOrder.form;
    },
  },
  methods: {
    onCloseModal() {
      this.$bvModal.hide("overtime_modal");
    },
    async onSend() {
      const Swal = this.$swal;

      const request = {
        id: this.form.id,
        note: this.form.note,
        date_start: moment(this.form.date_start).format("YYYY-MM-DD"),
        hour_start: this.form.hour_start_overtime,
        date_end: moment(this.form.date_end).format("YYYY-MM-DD"),
        hour_end: this.form.hour_end_overtime,
        user_id: this.getUserId,
        // user_id: 1000,
      };

      this.is_loading = true;

      // console.info(request);

      await axios
        .post(
          `${this.getBaseUrl}/api/v1/job-status-has-parent/store-overtime`,
          request
        )
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

            this.$bvModal.hide("overtime_modal");
            this.$store.dispatch("jobOrder/fetchDataOvertimeBaseUser", {
              user_id: this.getUserId,
            });
          }

          this.is_loading = false;
        })
        .catch((err) => {
          console.info(err);

          this.is_loading = false;

          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
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
    getColumns() {
      const columns = this.columns.filter((item) => item.label != "");
      return columns;
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
