import axios from "axios";
import moment from "moment";

const defaultForm = {
    id: null,
}

const defaultTotal = [
    {
        field: "employee",
        title: "Karyawan",
        value: 1,
        color: "pink",
        //   icon: "fas fa-chalkboard-teacher",
        icon: "fas fa-user",
        data: [],
    },
    {
        field: "absence",
        title: "Absen Masuk",
        value: 5,
        color: "green",
        //   icon: "fas fa-cocktail",
        icon: "fas fa-user",
        data: [],
    },
    {
        field: "notAbsence",
        title: "Belum Absen Datang ",
        value: 5,
        color: "red",
        icon: "fas fa-user",
        data: [],
    },
    {
        field: "absenceLate",
        title: "Terlambat",
        value: 5,
        color: "purple",
        icon: "fas fa-user",
        data: [],
    },
    {
        field: "notCombackAfterRest",
        title: "Belum Kembali Istirahat",
        value: 5,
        color: "blue",
        //   icon: "fas fa-cocktail",
        icon: "fas fa-user",
        data: [],
    },
];

const Dashboard = {
    namespaced: true,
    state: {
        base_url: null,
        data: {
            positions: [],
            employee_not_have_job_orders: [],
            five_employee_highest_job_orders: [],
            total: [],
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
        INSERT_TABLE_ALL(state, payload) {
            state.data.positions = payload.positions;
            state.data.employee_not_have_job_orders = payload.employee_not_have_job_orders;
            state.data.five_employee_highest_job_orders = payload.five_employee_highest_job_orders;
        },
        INSERT_DATA_TOTAL(state, payload) {
            state.data.total = [...defaultTotal];
        },
        INSERT_DATA_TOTAL_VALUE(state, payload) {
            // console.info(payload);
            const getIndex = state.data.total.findIndex(item => item.field == payload.field);

            state.data.total[getIndex] = {
                ...state.data.total[getIndex],
                value: payload.value,
                data: payload.data.length > 0 ? payload.data : [],
            }

            // console.info(state.data.total);
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
                    // console.info(responses);
                    const data = responses.data;

                    context.commit("INSERT_DATA_TOTAL");
                    context.commit("INSERT_DATA_TOTAL_VALUE", {
                        field: "employee",
                        value: data.totalEmployee,
                        data: [],
                    });
                    context.commit("INSERT_DATA_TOTAL_VALUE", {
                        field: "absence",
                        value: data.totalEmployeeAbsence,
                        data: data.dataEmployeeAbsences,
                    });
                    context.commit("INSERT_DATA_TOTAL_VALUE", {
                        field: "notCombackAfterRest",
                        value: data.totalNotCombackAfterRest,
                        data: data.dataNotCombackAfterRests,
                    });
                    context.commit("INSERT_DATA_TOTAL_VALUE", {
                        field: "notAbsence",
                        value: data.totalEmployeeNotAbsence,
                        data: data.dataEmployeeNotAbsences,
                    });
                    context.commit("INSERT_DATA_TOTAL_VALUE", {
                        field: "absenceLate",
                        value: data.totalEmployeeAbsenceLate,
                        data: data.dataEmployeeAbsenceLate,
                    });
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
