import axios from "axios";
import moment from "moment";
import DatePicker from "vue2-datepicker";

import VueSelect from "vue-select";

import DatatableClient from "../../../components/DatatableClient";

export default {
    props: {
        user: String,
        baseUrl: String,
        statuses: String,
    },
    data() {
        return {
            employee_columns: [
                {
                    label: "Nama",
                    field: "employee_name",
                    width: "200px",
                    class: "",
                },
                {
                    label: "Jabatan",
                    field: "position_name",
                    width: "200px",
                    class: "",
                },
                {
                    label: "Total",
                    field: "total_job_order",
                    width: "200px",
                    class: "",
                },
            ],
            employee_notyet_columns: [
                {
                    label: "Nama",
                    field: "employee_name",
                    width: "200px",
                    class: "",
                },
                {
                    label: "Jabatan",
                    field: "position_name",
                    width: "200px",
                    class: "",
                },
            ],
            position_columns: [
                {
                    label: "Nama",
                    field: "employee_name",
                    width: "200px",
                    class: "",
                },
                {
                    label: "Minimum",
                    field: "minimum_employee",
                    width: "200px",
                    class: "",
                },
                {
                    label: "Aktual",
                    field: "actual_employee",
                    width: "200px",
                    class: "",
                },
            ],
            setting_position_columns: [
                {
                    label: "Nama Jabatan",
                    field: "name",
                    width: "200px",
                    class: "",
                },
            ],
            options: {
                perPage: 5,
                // perPageValues: [5, 10, 25, 50, 100],
            },
        };
    },
    components: {
        VueSelect,
        DatatableClient,
    },
    mounted() {
        const user = JSON.parse(this.user);
        this.$store.commit("INSERT_BASE_URL", { base_url: this.baseUrl });
        this.$store.commit("INSERT_USER", { user });

        ["dashboard", "master"].map((item) => {
            this.$store.commit(`${item}/INSERT_BASE_URL`, {
                base_url: this.baseUrl,
            });
        });

        this.$store.dispatch("fetchPermission");
        // this.$store.dispatch("dashboard/fetchTotal");
        this.$store.dispatch("master/fetchPosition");
        this.$store.dispatch("dashboard/fetchDashboardHasPosition");

        this.$store.commit("dashboard/INSERT_DATA_TOTAL");
    },
    computed: {
        getBaseUrl() {
            return this.$store.state.base_url;
        },
        getUserId() {
            return this.$store.state.user?.id;
        },
        getDataTotal() {
            return this.$store.state.dashboard.data.total;
        },
        getDataSelecteds() {
            return this.$store.state.dashboard.data.selecteds;
        },
        getDataPosition() {
            return this.$store.state.dashboard.data.positions;
        },
        getDataDashboardHasPositions() {
            return this.$store.state.dashboard.data.dashboard_has_positions;
        },
        getDataEmployeeNotHaveJobOrder() {
            return this.$store.state.dashboard.data.employee_not_have_job_orders;
        },
        getDataFiveEmployeeHighestJobOrder() {
            return this.$store.state.dashboard.data.five_employee_highest_job_orders;
        },
        getOptionPositions() {
            return this.$store.state.master.data.positions;
        },
        form() {
            return this.$store.state.master.form;
        },
    },
    watch: {
        getBaseUrl(value) {
            if (value != null) {
                console.info(value);
                this.$store.dispatch("dashboard/fetchTotal");
            }
        },
    },
    methods: {
        onShowData(item) {
            if (item.data.length > 0) {
                // console.info("show");
                this.$bvModal.show("data_total");
                this.$store.commit("dashboard/INSERT_DATA_SELECTED", { data: item.data });
            }
        },
        onShowSettingPosition() {
            this.$bvModal.show("data_setting_position");
        },
        onCloseModal() {
            this.$bvModal.hide("data_total");
            this.$bvModal.hide("data_setting_position");
        },
        async onSend() {
            const Swal = this.$swal;

            // mengambil data hexa saja
            const request = {
                ...this.form,
            };

            // console.info(request);

            await axios
                .post(`${this.getBaseUrl}/api/v1/dashboard/store-has-position`, request)
                .then((responses) => {
                    // console.info(responses);
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

                        this.$store.dispatch("dashboard/fetchDashboardHasPosition");
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
        },
        getColumns(nameColumn) {
            const columns = this[nameColumn].filter((item) => item.label != "");
            return columns;
        },
    }
};
