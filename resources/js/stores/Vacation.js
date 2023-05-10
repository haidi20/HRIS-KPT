import axios from "axios";
import moment from "moment";

const defaultForm = {
    employee_id: null,
}

const Vacation = {
    namespaced: true,
    state: {
        base_url: null,
        data: [
            {
                id: 1,
                employee_name: "muhammad adi",
                position_name: "Welder",
                duration_readable: "7 Hari",
                date_start: "01 Mei 2023",
                date_end: "07 Mei 2023",
                created_by_name: "Sumardi",
            }
        ],
        params: {
                month: new Date(),
                search: null,
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

export default Vacation;
