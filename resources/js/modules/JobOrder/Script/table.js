import axios from "axios";
import moment from "moment";

import { checkNull } from "../../../utils";
import DatatableClient from "../../../components/DatatableClient";

export default {
    data() {
        return {
            columns: [
                {
                    label: "",
                    field: "",
                    width: "50px",
                    class: "",
                },
                {
                    label: "Nama Proyek",
                    field: "project_name",
                    width: "100px",
                    class: "",
                },
                {
                    label: "Pekerjaan",
                    field: "job_name",
                    width: "100px",
                    class: "",
                },
                {
                    label: "Catatan Pekerjaan",
                    field: "job_note",
                    width: "100px",
                    class: "",
                },
                {
                    label: "Pengawas",
                    field: "creator_name",
                    width: "100px",
                    class: "",
                },
                {
                    label: "Waktu Selesai",
                    field: "datetime_end_readable",
                    width: "100px",
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
            return this.$store.state.jobOrder.data;
        },
        getIsLoadingData() {
            return this.$store.state.jobOrder.loading.table;
        },
        params() {
            return this.$store.state.jobOrder.params;
        },
        job_order_id: {
            get() {
                return this.$store.state.jobOrder.form.job_order_id;
            },
            set(value) {
                this.$store.commit("jobOrder/INSERT_FORM_JOB_ORDER_ID", {
                    job_order_id: value,
                });
            },
        },
    },
    methods: {
        onFilter() {
            this.$store.dispatch("jobOrder/fetchDataFinish");
        },
        onChoose(item) {
            console.info(item);
        },
        getColumns() {
            const columns = this.columns.filter((item) => checkNull(item.label) != null);
            return columns;
        },
        getPermissionAdd() {
            return true;
        },
    },
};