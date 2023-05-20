import axios from "axios";
import moment from "moment";

import { numbersOnly, formatCurrency, checkNull, dateDuration } from "../utils";

const defaultForm = {
    id: null,
    date_end: null,
    date_duration: null,
    // biaya
    price: null,
    price_readable: null,
    // DP
    down_payment: null,
    down_payment_readable: null,
    // sisa pembyaaran
    remaining_payment: null,
    remaining_payment_readable: null,
    contractors: [
        {
            id: null,
        },
    ],
    oses: [
        {
            id: null,
        },
    ],
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
            position: false,
        },
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_DATA(state, payload) {
            state.data = payload.projects;
        },
        INSERT_FORM_NEW_CONTRACTOR(state, payload) {
            state.form.contractors = [
                ...state.form.contractors,
                {
                    id: null,
                },
            ]
        },
        INSERT_FORM_NEW_OS(state, payload) {
            state.form.oses = [
                ...state.form.oses,
                {
                    id: null,
                },
            ]
        },
        INSERT_FORM_PRICE(state, payload) {
            if (payload.price != null) {
                // console.info(typeof payload.amount);
                const numericValue = numbersOnly(payload.price.toString());
                const readAble = formatCurrency(payload.price, ".");

                // console.info(readAble.replace(/[^\d.:]/g, ''));

                state.form.price = numericValue;
                state.form.price_readable = readAble;

                // console.info(state);
            }
        },
        INSERT_FORM_DOWN_PAYMENT(state, payload) {
            if (payload.down_payment != null) {
                // console.info(typeof payload.amount);
                const numericValue = numbersOnly(payload.down_payment.toString());
                const readAble = formatCurrency(payload.down_payment, ".");

                // console.info(readAble.replace(/[^\d.:]/g, ''));

                state.form.down_payment = numericValue;
                state.form.down_payment_readable = readAble;

                // console.info(state);
            }
        },
        INSERT_FORM_REMAINING_PAYMENT(state, payload) {
            // console.info(state.form.price, state.form.down_payment);
            // return false;
            if (checkNull(state.form.down_payment) != null && checkNull(state.form.price) != null) {
                const remaining_payment = state.form.price - state.form.down_payment;
                // console.info(remaining_payment);
                const numericValue = numbersOnly(remaining_payment.toString());
                let readAble = formatCurrency(remaining_payment, ".");
                if (Number(state.form.price) < Number(state.form.down_payment)) {
                    readAble = `- ${readAble}`;
                }

                // console.info(readAble.replace(/[^\d.:]/g, ''));

                state.form.remaining_payment = numericValue;
                state.form.remaining_payment_readable = readAble;

                // console.info(state);
            } else {
                state.form.remaining_payment = null;
                state.form.remaining_payment_readable = null;
            }
        },
        INSERT_FORM_DATE_END(state, payload) {
            // console.info(payload.date_end);
            state.form.date_end = payload.date_end;
        },
        INSERT_FORM_DATE_DURATION(state, payload) {
            // console.info(state.form.date_end);
            const dateNow = moment().format("YYYY-MM-DD");
            const date_duration = dateDuration(dateNow, state.form.date_end);

            // console.info(date_duration);
            state.form.date_duration = `${date_duration} Hari`;
        },
        INSERT_OPTION_POSITION(state, payload) {
            state.options.positions = payload.positions;
        },
        UPDATE_LOADING_TABLE(state, payload) {
            state.loading.table = payload.value;
        },
        UPDATE_LOADING_POSITION(state, payload) {
            state.loading.position = payload.value;
        },
        DELETE_FORM_CONTRACTOR(state, payload) {
            // const index = state.form.contractors.findIndex(obj => obj.id === payload.id);

            // Hapus objek dari array jika index ditemukan
            // if (index !== -1) {
            //     state.form.contractors.splice(index, 1);
            // }

            state.form.contractors.splice(payload.index, 1);
        },
        DELETE_FORM_OS(state, payload) {
            state.form.oses.splice(payload.index, 1);
        },
        CLEAR_FORM(state, payload) {
            // console.info(defaultForm);
            state.form = { ...defaultForm };
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
                    // console.info(responses);
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
        fetchPosition: async (context, payload) => {
            context.commit("INSERT_OPTION_POSITION", {
                projects: [],
            });
            context.commit("UPDATE_LOADING_POSITION", { value: true });

            const params = {
                ...context.state.params,
                month: moment(context.state.params.month).format("Y-MM"),
            }

            await axios
                .get(
                    `${context.state.base_url}/api/v1/position/fetch-data`, {
                    params: { ...params },
                }
                )
                .then((responses) => {
                    console.info(responses);
                    const data = responses.data;

                    context.commit("INSERT_OPTION_POSITION", {
                        positions: data.positions,
                    });
                    context.commit("UPDATE_LOADING_POSITION", { value: false });
                })
                .catch((err) => {
                    context.commit("UPDATE_LOADING_POSITION", { value: false });
                    console.info(err);
                });
        },

    }
}

export default Project;
