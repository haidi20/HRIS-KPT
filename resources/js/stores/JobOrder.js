import axios from "axios";
import moment from "moment";

const defaultForm = {
    code: "",
    project_id: "",
    category_id: "",
    type_job_id: "",
    type_job_note: "",
    status: null,
    image: null,
    date: new Date(),
    hour: null,
    note: null,
    type_time: "hour",
    form_kind: null,
    form_title: "Job Order",
}

const JobOrder = {
    namespaced: true,
    state: {
        base_url: null,
        data: [
            {
                id: 1,
                project_id: 1,
                category_id: 1,
                category_name: "Reguler",
                project_name: "Staging",
                project_note: "informasi lebih lengkap tentang staging",
                status: "active",
                status_readable: "Aktif",
                employee_total: 5,
                employee_active_total: 4,
                status_color: "success",
                count_assessment: 1,
                is_assessment_foreman: false,
                is_assessment_quality_control: true,
            },
        ],
        params: {
            date: [
                [
                    new Date(),
                    new Date()
                ],
            ],
            type: "all",
            type_by: "creator",
        },
        form: { ...defaultForm },
        is_active_form: false,
        options: {
            projects: [
                {
                    id: 1,
                    name: "Kapal A",
                },
            ],
            jobs: [
                {
                    id: 1,
                    name: "Perbaikan Mesin",
                },
            ],
            type_times: [
                {
                    id: "minute",
                    name: "Menit",
                },
                {
                    id: "hour",
                    name: "Jam",
                },
                {
                    id: "day",
                    name: "Hari",
                },
            ],
            job_levels: [
                {
                    id: 1,
                    name: "Sulit / Berat",
                },
                {
                    id: 2,
                    name: "Sedang / Menengah",
                },
                {
                    id: 3,
                    name: "Mudah / Ringan",
                },
            ],
            categories: [
                {
                    id: 1,
                    name: "Reguler",
                },
                {
                    id: 2,
                    name: "Harian",
                },
                {
                    id: 3,
                    name: "Borongan",
                },
            ],
            types: [
                {
                    id: "all",
                    name: "semua",
                },
                {
                    id: "pause",
                    name: "tunda",
                },
                {
                    id: "active",
                    name: "aktif",
                },
                // jangan ini hanya untuk pengawas
                {
                    id: "done_assessment_qc",
                    name: "sudah dinilai oleh QC",
                },
            ],
            type_bys: [
                {
                    id: "creator",
                    name: "anda",
                },
                {
                    id: "other_foreman",
                    name: "pengawas lain",
                },
            ],
        },
        loading: {
            table: false,
        },
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_DATA(state, payload) {
            state.data = payload.data;
        },
        INSERT_FORM(state, payload) {
            state.form.form_kind = payload?.form_kind;
            state.form = {
                ...state.form,
                ...payload.form,
            };
        },
        INSERT_FORM_KIND(state, payload) {
            state.form.form_title = payload.form_title;
            state.form.form_kind = payload.form_kind;
        },
        UPDATE_IS_ACTIVE_FORM(state, payload) {
            state.is_active_form = payload.value;
        },
    },
    actions: {
        // onIncrement: (context, payload) => {
        //     context.commit("INCREMENT");
        // },

    }
}

export default JobOrder;
