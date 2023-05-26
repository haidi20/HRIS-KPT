import axios from "axios";
import moment from "moment";

import { numbersOnly, formatCurrency } from "../utils";

const defaultForm = {
    name: null,
    type_time: "base time",
    type_amount: "nominal",
    amount: null,
    amount_readable: null,
    date_start: new Date(),
    date_end: new Date(moment().add({ month: 1 })),
    type_adjustment: "deduction",
    note: null,
}

const SalaryAdjustment = {
    namespaced: true,
    state: {
        base_url: null,
        data: [],
        params: {
            date_filter: new Date(),
        },
        form: { ...defaultForm },
        options: {
            type_times: [
                {
                    id: "forever",
                    name: "selamanya",
                },
                {
                    id: "base time",
                    name: "berdasarkan bulan",
                }
            ],
            // jenis jumlah dalam bentuk persen atau angka
            type_amounts: [
                {
                    id: "nominal",
                    name: "jumlah uang",
                },
                {
                    id: "percent",
                    name: "presentase dari gaji karyawan",
                },
            ],
            type_adjustments: [
                {
                    id: "deduction",
                    name: "pengurangan",
                },
                {
                    id: "addition",
                    name: "penambahan",
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
            state.data = payload.salaryAdjustments;
        },
        INSERT_FORM(state, payload) {
            state.form = { ...state.form, ...payload.form };
        },
        INSERT_FORM_AMOUNT(state, payload) {
            if (payload.amount != null) {
                // console.info(typeof payload.amount);
                const numericValue = numbersOnly(payload.amount.toString());
                const readAble = formatCurrency(payload.amount, ".");

                // console.info(readAble.replace(/[^\d.:]/g, ''));

                state.form.amount = numericValue;
                state.form.amount_readable = readAble;

                console.info(state);
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
                salaryAdjustments: [],
            });
            context.commit("UPDATE_LOADING_TABLE", { value: true });

            const params = {
                ...context.state.params,
                month: moment(context.state.params.month).format("Y-MM"),
            }

            await axios
                .get(
                    `${context.state.base_url}/api/v1/salary-adjustment/fetch-data`, {
                    params: { ...params },
                })
                .then((responses) => {
                    console.info(responses);
                    const data = responses.data;

                    context.commit("INSERT_DATA", {
                        salaryAdjustments: data.salaryAdjustments,
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

export default SalaryAdjustment;
