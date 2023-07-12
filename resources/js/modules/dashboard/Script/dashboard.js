import axios from "axios";
import moment from "moment";
import DatePicker from "vue2-datepicker";

import DatatableClient from "../../../components/DatatableClient";

export default {
    data() {
        return {
            list_total: [
                {
                    title: "Karyawan",
                    value: 1,
                    color: "blue",
                    //   icon: "fas fa-chalkboard-teacher",
                    icon: "fas fa-user",
                },
                {
                    title: "Belum Kembali Istirahat",
                    value: 5,
                    color: "red",
                    //   icon: "fas fa-cocktail",
                    icon: "fas fa-user",
                },
                {
                    title: "Belum Absen Datang ",
                    value: 5,
                    color: "green",
                    icon: "fas fa-user",
                },
                {
                    title: "Terlambat",
                    value: 5,
                    color: "purple",
                    icon: "fas fa-user",
                },
            ],
            employee_columns: [
                {
                    label: "Nama",
                    field: "name",
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
                    field: "name",
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
                    field: "name",
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
        getDataPosition() {
            return this.$store.state.dashboard.data.positions;
        },
        getDataEmployeeNotHaveJobOrder() {
            return this.$store.state.dashboard.data.employee_not_have_job_orders;
        },
        getDataFiveEmployeeHighestJobOrder() {
            return this.$store.state.dashboard.data.five_employee_highest_job_orders;
        },
    },
};
