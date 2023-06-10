import axios from "axios";
import moment from "moment";
import DatatableClient from "../../../components/DatatableClient";

export default {
    data() {
        return {
            is_loading_export: false,
            columns: [
                {
                    label: "Nama",
                    field: "name",
                    width: "100px",
                    class: "",
                },
                {
                    label: "Waktu",
                    field: "type_time_readable",
                    width: "100px",
                    class: "",
                },
                {
                    label: "Nilai",
                    field: "amount_readable",
                    width: "100px",
                    class: "",
                },
                {
                    label: "Jenis",
                    field: "type_adjustment_name",
                    width: "100px",
                    class: "",
                },
                {
                    label: "Keterangan",
                    field: "note",
                    width: "100px",
                    class: "",
                },
                {
                    label: "",
                    class: "",
                    width: "20px",
                },
            ],
            options: {
                perPage: 5,
                // perPageValues: [5, 10, 25, 50, 100],
            },
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
            return this.$store.state.user?.id;
        },
        getData() {
            return this.$store.state.salaryAdjustment.data;
        },
        params() {
            return this.$store.state.salaryAdjustment.params;
        },
    },
    methods: {
        onExport() {
            //
        },
        onDetail(form) {
            //   this.$store.commit("salaryAdjustment/CLEAR_FORM");
            this.$store.commit("salaryAdjustment/INSERT_FORM", {
                form,
                form_type: "detail",
            });
            this.$store.commit("employeeHasParent/INSERT_FORM", {
                form: {
                    position_id: form.position_id,
                    job_order_id: form.job_order_id,
                    employee_base: form.employee_base,
                },
                form_type: "detail",
            });
            this.$store.commit("employeeHasParent/INSERT_DATA_ALL_SELECTED", {
                selecteds: [...form.salary_adjustment_details],
            });
            this.$bvModal.show("salary_adjustment_form");
        },
        onEdit(form) {
            // console.info(form);
            //   this.$store.commit("salaryAdjustment/CLEAR_FORM");
            this.$bvModal.show("salary_adjustment_form");
            this.$store.commit("salaryAdjustment/INSERT_FORM", {
                form,
                form_type: "edit",
            });
            this.$store.commit("employeeHasParent/INSERT_FORM", {
                form: {
                    position_id: form.position_id,
                    job_order_id: form.job_order_id,
                    employee_base: form.employee_base,
                },
                form_type: "detail",
            });
            this.$store.commit("employeeHasParent/INSERT_DATA_ALL_SELECTED", {
                selecteds: [...form.salary_adjustment_details],
            });
        },
        onDelete(id) {
            //
        },
        onFilter() {
            //   console.info(this.params);
            this.$store.dispatch("salaryAdjustment/fetchData");
        },
        getColumns() {
            const columns = this.columns.filter((item) => item.label != "");
            return columns;
        },
    },
};
