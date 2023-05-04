import axios from "axios";
import moment from "moment";

const defaultForm = {
    employee_id: null,
}

const Employee = {
    namespaced: true,
    state: {
        base_url: null,
        data: [
            {
                id: 1,
                name: "Muhammad Adi",
            }
        ],
        params: {
            date_filter: new Date(),
        },
        form: { ...defaultForm },
        options: {
            //
        },
        loading: {
            table: false,
        },
    },
    mutations: {

    },
    actions: {
        // onIncrement: (context, payload) => {
        //     context.commit("INCREMENT");
        // },

    }
}

export default Employee;
