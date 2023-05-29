import axios from "axios";
import moment from "moment";

const defaultForm = {
    code: null,
    project_id: null,
    category: null,
    job_id: null,
    job_note: null,
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
        data: [],
        params: {
            month: new Date(),
            type: "all",
            type_by: "creator",
            project_id: null,
        },
        form: { ...defaultForm },
        is_active_form: false,
        options: {
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
                    id: 'reguler',
                    name: "Reguler",
                },
                {
                    id: 'daily',
                    name: "Harian",
                },
                {
                    id: 'fixed_price',
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
            state.data = payload.job_orders;
        },
        INSERT_FORM(state, payload) {
            state.form.form_kind = payload?.form_kind;
            state.form = {
                ...state.form,
                ...payload.form,
            };
        },
        INSERT_FORM_JOB_ID(state, payload) {
            state.form.job_id = payload.job_id;
        },
        INSERT_FORM_CODE(state, payload) {
            state.form.code = payload.code;
        },
        INSERT_FORM_KIND(state, payload) {
            state.form.form_title = payload.form_title;
            state.form.form_kind = payload.form_kind;
        },
        INSERT_PARAM(state, payload) {
            state.params = {
                ...state.params,
                ...payload,
            }
        },
        UPDATE_IS_ACTIVE_FORM(state, payload) {
            state.is_active_form = payload.value;
        },
        UPDATE_LOADING_TABLE(state, payload) {
            state.loading.table = payload.value;
        },
    },
    actions: {
        fetchData: async (context, payload) => {
            context.commit("INSERT_DATA", {
                job_orders: [],
            });
            context.commit("UPDATE_LOADING_TABLE", { value: true });

            const params = {
                ...context.state.params,
                month: moment(context.state.params.month).format("Y-MM"),
            }

            await axios
                .get(
                    `${context.state.base_url}/api/v1/job-order/fetch-data`, {
                    params: { ...params },
                })
                .then((responses) => {
                    // console.info(responses);
                    const data = responses.data;

                    context.commit("INSERT_DATA", {
                        job_orders: data.jobOrders,
                    });
                    context.commit("UPDATE_LOADING_TABLE", { value: false });
                })
                .catch((err) => {
                    context.commit("UPDATE_LOADING_TABLE", { value: false });
                    console.info(err);
                });
        },

    }
}

export default JobOrder;
