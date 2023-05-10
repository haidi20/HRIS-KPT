import axios from "axios";
import moment from "moment";

import { numbersOnly, formatCurrency } from "../utils";

const defaultForm = {
    employee_id: null,
    amount: null, // jumlah nominal kasbon
    amount_readable: null,
    reason: null,
}

const SalaryAdvance = {
    namespaced: true,
    state: {
        base_url: null,
        data: [
            {
                id: 1,
                name: "Muhammad Adi",
                position_name: "Welder",
                amount: "Rp. 1.500.000",
                monthly_deduction: "Rp. 500.000",
                duration: "3 Bulan",
                status: "accept",
                status_readable: "Diterima",
                note: "kebutuhan beli kompor baru, kompor lama rusak",
            }
        ],
        params: {
            date_filter: new Date(),
            type: "",
        },
        form: { ...defaultForm },
        options: {
            types: [
                // (opsional)
                // {
                //     id: "settled",
                //     name: "lunas",
                // },
                // {
                //     id: "unpaid",
                //     name: "belum lunas",
                // },
                {
                    id: "",
                    name: "semua",
                },
                {
                    id: "waiting",
                    name: "menunggu persetujuan",
                },
                {
                    id: "reject",
                    name: "ditolak",
                },
                {
                    id: "accept",
                    name: "diterima",
                },
            ],
        },
        loading: {
            table: false,
        },
    },
    mutations: {
        INSERT_FORM_AMOUNT(state, payload) {
            if (payload.amount != null) {
                // console.info(typeof payload.amount);
                const numericValue = numbersOnly(payload.amount.toString());
                const readAble = formatCurrency(payload.amount, ".");

                // console.info(readAble);

                state.form.amount = numericValue;
                state.form.amount_readable = readAble;

                // console.info(state);
            }
        },
    },
    actions: {
        // onIncrement: (context, payload) => {
        //     context.commit("INCREMENT");
        // },

    }
}

export default SalaryAdvance;
