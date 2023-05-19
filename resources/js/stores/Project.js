import axios from "axios";
import moment from "moment";

import { numbersOnly, formatCurrency } from "../utils";

const defaultForm = {
    id: null,
    // biaya
    price: null,
    price_readable: null,
    // DP
    down_payment: null,
    down_payment_readable: null,
    // sisa pembyaaran
    remaining_payment: null,
    remaining_payment_readable: null,
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

            // console.info(state.form);
            // return false;
            if (state.form.down_payment != null && state.form.price != null) {
                const remaining_payment = state.form.price - state.form.down_payment;
                // console.info(typeof payload.amount);
                const numericValue = numbersOnly(remaining_payment.toString());
                const readAble = formatCurrency(remaining_payment, ".");

                // console.info(readAble.replace(/[^\d.:]/g, ''));

                state.form.remaining_payment = numericValue;
                state.form.remaining_payment_readable = readAble;

                // console.info(state);
            }
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
