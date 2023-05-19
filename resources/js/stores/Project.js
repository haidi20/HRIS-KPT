import axios from "axios";
import moment from "moment";

const defaultForm = {

}

const Project = {
    namespaced: true,
    state: {
        base_url: null,
        data: [],
        params: {
            month: new Date(),
        },
        form: { ...defaultForm },
        options: {
            barges: [
                {
                    id: 1,
                    name: "Kapal A",
                },
            ],
            types: [
                {
                    id: "daily",
                    name: "Harian",
                },
                {
                    id: "contract",
                    name: "Borongan",
                },
            ],
            work_types: [
                {
                    id: "production",
                    name: "Produksi (pembuatan dari awal)",
                },
                {
                    id: "maintenance",
                    name: "Maintenance (Perbaikan)",
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
            state.data = payload.projects;
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
            context.commit("INSERT_DATA", {
                projects: [],
            });
            context.commit("UPDATE_LOADING_TABLE", { value: true });

            const params = {
                ...context.state.params,
                month: moment(context.state.params.month).format("Y-MM"),
            }

            await axios
                .get(
                    `${context.state.base_url}/api/v1/project/fetch-data`, {
                    params: { ...params },
                }
                )
                .then((responses) => {
                    console.info(responses);
                    const data = responses.data;

                    context.commit("INSERT_DATA", {
                        projects: data.projects,
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

export default Project;
