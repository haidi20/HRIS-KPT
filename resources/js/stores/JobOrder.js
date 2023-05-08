import axios from "axios";
import moment from "moment";

const defaultForm = {
    code: "",
    project_id: "",
    category_id: "",
    type_job_id: "",
    type_job_note: "",
    image: null,
    type_time: 1,
}

const JobOrder = {
    namespaced: true,
    state: {
        base_url: null,
        data: [
            {
                id: 1,
                project_name: "Staging",
                project_note: "informasi lebih lengkap tentang staging ksjdlfkjsdf",
                status: "Aktif",
                employee_total: 5,
                employee_active_total: 4,
                status_color: "success",
                count_assessment: 1,
                is_assessment_foreman: false,
                is_assessment_quality_control: true,
            },
            {
                id: 2,
                project_name: "Staging",
                project_note: "informasi lebih lengkap tentang staging ksjdlfkjsdf",
                status: "Aktif",
                employee_total: 5,
                employee_active_total: 4,
                status_color: "success",
                count_assessment: 1,
                is_assessment_foreman: false,
                is_assessment_quality_control: true,
            },
            {
                id: 3,
                project_name: "Staging",
                project_note: "informasi lebih lengkap tentang staging ksjdlfkjsdf",
                status: "Aktif",
                employee_total: 5,
                employee_active_total: 4,
                status_color: "success",
                count_assessment: 1,
                is_assessment_foreman: false,
                is_assessment_quality_control: true,
            },
            {
                id: 4,
                project_name: "Staging",
                project_note: "informasi lebih lengkap tentang staging ksjdlfkjsdf",
                status: "Aktif",
                employee_total: 5,
                employee_active_total: 4,
                status_color: "success",
                count_assessment: 1,
                is_assessment_foreman: false,
                is_assessment_quality_control: true,
            },
        ],
        params: {
            date: new Date(),
            type: "all",
            type_by: "creator",
        },
        form: { ...defaultForm },
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
                    id: 1,
                    name: "Menit",
                },
                {
                    id: 2,
                    name: "Jam",
                },
                {
                    id: 3,
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

    },
    actions: {
        // onIncrement: (context, payload) => {
        //     context.commit("INCREMENT");
        // },

    }
}

export default JobOrder;
