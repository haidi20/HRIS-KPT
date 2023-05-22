import axios from "axios";
import moment from "moment";

import { numbersOnly, formatCurrency, checkNull, dateDuration } from "../utils";

const defaultForm = {
    id: null,
    date_end: null,
    day_duration: null,
    // biaya
    price: null,
    price_readable: null,
    // DP
    down_payment: null,
    down_payment_readable: null,
    // sisa pembyaaran
    remaining_payment: null,
    remaining_payment_readable: null,
    company_id: null,
    foreman_id: null,
    type: null,
    // contractors: [
    //     {
    //         id: null,
    //     },
    // ],
    // ordinary_seamans: [
    //     {
    //         id: null,
    //     },
    // ],
    form_type: "create", // create, edit, detail
    form_title: "Tambah Proyek",

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
        INSERT_FORM(state, payload) {
            state.form = {
                ...state.form,
                ...payload.form,
                date_end: new Date(payload.form.date_end),
            };
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
            state.form.ordinary_seamans = [
                ...state.form.ordinary_seamans,
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
        INSERT_FORM_FORM_TYPE(state, payload) {
            state.form.form_type = payload.form_type;
            state.form.form_title = payload.form_title;
        },
        INSERT_FORM_DAY_DURATION(state, payload) {
            // console.info(state.form.date_end);
            const dateNow = moment().format("YYYY-MM-DD");
            const dayDuration = dateDuration(dateNow, state.form.date_end);

            // console.info(day_duration);
            state.form.day_duration = `${dayDuration}`;
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
            state.form.ordinary_seamans.splice(payload.index, 1);
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
        /**
         * Perform an action asynchronously.
         *
         * @param {Object} context - The context object.
         * @param {Object} payload - The payload object.
         * @param {Object} payload.form - The form item.
         * @param {string} payload.form_type - The type of form.
         * @param {string} payload.form_title - The title of the form.
         * @returns {Promise} A promise that resolves after the action is performed.
         */
        onAction: async (context, payload) => {
            context.commit("INSERT_FORM", {
                form: payload.form,
            });
            context.commit("INSERT_FORM_FORM_TYPE", {
                form_type: payload.form_type,
                form_title: payload.form_title,
            });
            context.commit("INSERT_FORM_PRICE", {
                price: payload.form.price,
            });
            context.commit("INSERT_FORM_DOWN_PAYMENT", {
                down_payment: payload.form.down_payment,
            });
            context.commit("INSERT_FORM_REMAINING_PAYMENT");

            // if (payload.form.contractors.length == 0) {
            //     context.commit("INSERT_FORM_NEW_CONTRACTOR");
            // }

            // if (payload.form.ordinary_seamans.length == 0) {
            //     context.commit("INSERT_FORM_NEW_OS");
            // }
        },
    },
    getters: {
        getReadOnly: (state) => {
            let result = false;

            // console.info(state.form.form_type);

            if (state.form.form_type == "detail") {
                result = true;
            }

            return result;
        },
    },
}

export default Project;
