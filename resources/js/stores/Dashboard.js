import axios from "axios";
import moment from "moment";

const defaultForm = {
    id: null,
}

const Dashboard = {
    namespaced: true,
    state: {
        base_url: null,
        data: {
            positions: [],
            employee_not_have_job_orders: [],
            five_employee_highest_job_orders: [],
        },
        params: {
            month: new Date(),
        },
        form: { ...defaultForm },
        options: {
            //
        },
        loading: {
            position: false,
            employee_not_have_job_order: false,
            five_employee_highest_job_order: false,
        },
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_TABLE(state, payload) {
            state.data.positions = payload.positions;
            state.data.employee_not_have_job_orders = payload.employee_not_have_job_orders;
            state.data.five_employee_highest_job_orders = payload.five_employee_highest_job_orders;
        },
        INSERT_FORM(state, payload) {
            state.form = { ...state.form, ...payload.form };
        },
        UPDATE_LOADING_TABLE(state, payload) {
            state.loading.table = payload.value;
        },
        CLEAR_FORM(state, payload) {
            state.form = { ...defaultForm };
        },
    },
    actions: {
        fetchTotal: async (context, payload) => {
            // context.commit("INSERT_TABLE", {
            //     positions: [],
            //     employee_not_have_job_orders: [],
            //     five_employee_highest_job_orders: [],
            // });
            // context.commit("UPDATE_LOADING_TABLE", { value: true });

            const params = {
                ...context.state.params,
                month: moment(context.state.params.month).format("Y-MM"),
            }

            await axios
                .get(
                    `${context.state.base_url}/api/v1/dashboard/fetch-total`, {
                    params: { ...params },
                })
                .then((responses) => {
                    console.info(responses);
                    const data = responses.data;

                    // context.commit("INSERT_TABLE", {
                    //     total: data.total,
                    // });
                    // context.commit("UPDATE_LOADING_TABLE", { value: false });
                })
                .catch((err) => {
                    // context.commit("UPDATE_LOADING_TABLE", { value: false });
                    console.info(err);
                });
        },

    },
    getters: {
        //
    },
}

export default Dashboard;
