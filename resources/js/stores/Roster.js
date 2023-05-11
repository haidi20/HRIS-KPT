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
        data: {
            main: [],
            total: [],
        },
        params: {
            month: new Date(),
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
        date_range: [],
        get_title_form: [],
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
        INSERT_TOTAL(state, payload) {
            state.data.total = {
                ...state.data.total,
                [payload.initial]: payload.data,
            }
        },
        INSERT_FORM(state, payload) {
            const getForm = state.data.main.find(item => item.id == payload.id);
            // console.info(getForm);

            const dateVacation = getForm.date_vacation[0] != null ? [
                new Date(getForm.date_vacation[0]),
                new Date(getForm.date_vacation[1]),
            ] : [
                null, null
            ];

            state.get_title_form = "Ubah Roster - " + getForm.employee_name;
            state.form = {
                ...state.form,
                employee_id: getForm.employee_id,
                employee_name: getForm.employee_name,
                work_schedule: getForm.work_schedule,
                day_off_one: getForm.day_off_one,
                day_off_two: getForm.day_off_two,
                month: new Date(getForm.month),
                date_vacation: dateVacation,
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
                month: moment(context.state.params.month).format("Y-MM"),
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
        fetchTotal: async (context, payload) => {
            const params = {
                // ...context.state.params,
                date_filter: moment(context.state.params.date_filter).format("Y-MM"),
            }

            let rosterStasuses = payload.rosterStasuses;
            rosterStasuses = [
                ...rosterStasuses,
                {
                    id: 0,
                    initial: "ALL",
                },
            ];

            const promises = rosterStasuses
                .map(async (item, index) => {
                    context.commit("INSERT_TOTAL", { initial: item, data: [] });

                    return new Promise((resolve, reject) => {
                        axios
                            .get(`${context.state.base_url}/api/v1/roster/fetch-total`, {
                                params: {
                                    ...params,
                                    roster_status_initial: item.initial,
                                },
                            })
                            .then((responses) => {
                                // console.info(responses);

                                const data = responses.data.data;

                                context.commit("INSERT_TOTAL", { initial: item.initial, data: data });

                                resolve(item);
                            }).then(roster_status => {

                            });
                    });
                })

            await Promise.all(promises)
                .then((result) => {
                    console.info(context.state.data.total);
                });

        },
    }
}

export default Roster;
