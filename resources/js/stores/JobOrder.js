import axios from "axios";
import moment from "moment";

const defaultForm = {
    code: "",
    project_id: "",
    category_id: "",
    type_job_id: "",
    type_job_note: "",
    image: null,
}

const JobOrder = {
    namespaced: true,
    state: {
        base_url: null,
        data: [],
        params: {
            date_filter: new Date(),
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
