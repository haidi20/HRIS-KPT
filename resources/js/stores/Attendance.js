import axios from "axios";
import moment from "moment";

const defaultForm = {

}

const Attendance = {
    namespaced: true,
    state: {
        base_url: null,
        data: {
            main: [],
        },
        params: {
            month_filter: new Date(),
        },
        form: { ...defaultForm },
        options: {
            //
        },
        loading: {
            table: false,
        },
        date_range: [],
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_DATA(state, payload) {
            state.data.main = payload.data;
        },
        INSERT_DATE_RANGE(state, payload) {
            state.date_range = payload.date_range;
        },
        UPDATE_LOADING_TABLE(state, payload) {
            state.loading.table = payload.value;
        },
    },
    actions: {
        fetchData: async (context, payload) => {
            context.commit("UPDATE_LOADING_TABLE", { value: true });

            const params = {
                // ...context.state.params,
                month_filter: moment(context.state.params.month_filter).format("Y-MM"),
            }

            await axios
                .get(
                    `${context.state.base_url}/api/v1/attendance/fetch-data`, {
                    params: { ...params },
                }
                )
                .then((responses) => {
                    console.info(responses);
                    const data = responses.data;

                    context.commit("INSERT_DATA", {
                        data: data.data,
                    });
                    context.commit("INSERT_DATE_RANGE", {
                        date_range: data.dateRange,
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

export default Attendance;
