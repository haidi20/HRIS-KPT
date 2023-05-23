import axios from "axios";
import moment from "moment";

const defaultForm = {

}

const example = {
    namespaced: true,
    state: {
        base_url: null,
        data: {
            main: []
        },
        params: {
            date: [
                new Date(moment().startOf("month")),
                new Date(),
            ],
            status: "all",
        },
        form: { ...defaultForm },
        options: {
            statuses: [
                {
                    id: "all",
                    name: "Semua",
                },
                {
                    id: "waiting",
                    name: "Menunggu Persetujuan",
                },
                {
                    id: "settled",
                    name: "Lunas",
                },
                {
                    id: "unpaid",
                    name: "Belum Lunas",
                },
                {
                    id: "accept",
                    name: "Diterima",
                },
                {
                    id: "reject",
                    name: "Ditolak",
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
        INSERT_DATA_MAIN(state, payload) {
            state.data.main = payload.salary_advances;
        },
        INSERT_FORM(state, payload) {
            state.form = { ...state.form, ...payload.form };
        },

        CLEAR_FORM(state, payload) {
            // console.info(defaultForm);
            state.form = { ...defaultForm };
        },
        UPDATE_LOADING_TABLE(state, payload) {
            state.loading.table = payload.value;
        },
    },
    actions: {
        fetchData: async (context, payload) => {
            context.commit("INSERT_DATA_MAIN", {
                salary_advances: [],
            });
            context.commit("UPDATE_LOADING_TABLE", { value: true });

            const params = {
                ...context.state.params,
                date_start: moment(context.state.params.date[0]).format("YYYY-MM-DD"),
                date_end: moment(context.state.params.date[1]).format("YYYY-MM-DD"),
                user_id: payload.user_id,
            }

            await axios
                .get(
                    `${context.state.base_url}/api/v1/report/salary-advance/fetch-data`, {
                    params: { ...params },
                })
                .then((responses) => {
                    console.info(responses);
                    const data = responses.data;

                    context.commit("INSERT_DATA_MAIN", {
                        salary_advances: data.salaryAdvances,
                    });
                    context.commit("UPDATE_LOADING_TABLE", { value: false });
                })
                .catch((err) => {
                    context.commit("UPDATE_LOADING_TABLE", { value: false });
                    console.info(err);
                });
        },

    },
    getters: {
        //
    },
}

export default example;
