import axios from "axios";
import moment from "moment";

const defaultForm = {
    employee_id: null,
    employee_name: null,
    work_schedule: null,
    day_off_one: null,
    day_off_two: null,
    month: new Date,
    date_vacation: [
        null,
        null,
    ],
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
            month_filter: new Date,
        },
        form: { ...defaultForm },
        options: {
            list_days: [
                { name: "Senin", id: "Monday" },
                { name: "Selasa", id: "Tuesday" },
                { name: "Rabu", id: "Wednesday" },
                { name: "Kamis", id: "Thursday" },
                { name: "Jumat", id: "Friday" },
                { name: "Sabtu", id: "Saturday" },
                { name: "Minggu", id: "Sunday" },
            ],
        },
        loading: {
            table: false,
        },
        date_ranges: [],
        get_title_form: [],
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_DATA(state, payload) {
            state.data = payload.data;
        },
        INSERT_DATE_RANGES(state, payload) {
            state.date_ranges = payload.date_ranges;
        },
        INSERT_FORM(state, payload) {
            const getForm = state.data.find(item => item.id == payload.id);
            // console.info(getForm);
            state.get_title_form = "Ubah Roster - " + getForm.employee_name;
            state.form = {
                ...state.form,
                employee_id: getForm.employee_id,
                employee_name: getForm.employee_name,
                work_schedule: getForm.work_schedule,
                day_off_one: getForm.day_off_one,
                day_off_two: getForm.day_off_two,
                date_vacation: [
                    new Date(getForm.date_vacation[0]),
                    new Date(getForm.date_vacation[1]),
                ],
            };
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
                    // console.info(responses);
                    const data = responses.data;

                    context.commit("INSERT_DATA", {
                        data: data.data,
                    });
                    context.commit("INSERT_DATE_RANGES", {
                        date_ranges: data.dateRanges,
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

export default Roster;
