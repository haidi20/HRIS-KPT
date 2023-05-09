import axios from "axios";
import moment from "moment";

const defaultForm = {
    date_start: moment(),
    date_end: moment(),
    employee_id: null,
    date_offs: [],
    date_vacation_start: null,
    date_vacation_end: null,
    roster_statuses: [],
}

const Roster = {
    namespaced: true,
    state: {
        base_url: null,
        data: [
            {
                id: "001-050523",
                name: "perbaikan mesin kapal",
            }
        ],
        params: {
            month_filter: new Date(),
        },
        form: { ...defaultForm },
        options: {
            list_days: [
                { text: "Senin", value: "Monday" },
                { text: "Selasa", value: "Tuesday" },
                { text: "Rabu", value: "Wednesday" },
                { text: "Kamis", value: "Thursday" },
                { text: "Jumat", value: "Friday" },
                { text: "Sabtu", value: "Saturday" },
                { text: "Minggu", value: "Sunday" },
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
                    `${context.state.base_url}/api/v1/roster/fetch-data`, {
                    params: { ...params },
                }
                )
                .then((responses) => {
                    console.info(responses);
                    const data = responses.data;

                    // context.commit("INSERT_DATA", {
                    //     data: data.data,
                    // });
                    context.commit("UPDATE_LOADING_TABLE", { value: false });
                })
                .catch((err) => {
                    context.commit("UPDATE_LOADING_TABLE", { value: false });
                    console.info(err);
                });
        },

    }
}

export default Roster;
