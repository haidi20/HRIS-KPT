const http = require('http');
const cors = require('cors');
const moment = require('moment');
const express = require('express');
const { Op } = require('sequelize');
const { Server } = require("socket.io");
const bodyParser = require('body-parser');

const JobOrder = require('./models/jobOrder');
const Notification = require('./models/notification');

const socketioModule = require('./socketioModule');
const NotificationController = require("./controllers/NotificationController");
const { updateOrCreate } = require("./utils");

const app = express();
const server = http.createServer(app);
// const io = socketIo(server);

app.use(cors());
app.use(bodyParser.json());

const io = new Server(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"],
    },
});

let userSockets = new Map();

io.on('connection', async (socket) => {
    console.log('a user connected');

    // const now = moment().format('YYYY-MM-DD HH:mm:ss');
    const now = moment().set({ date: 24, hour: 22 });
    const userId = socket.handshake.query['user_id'];
    // setInterval(async () => {
    const jobOrders = await JobOrder.findAll({
        where: {
            datetime_estimation_end: {
                [Op.lte]: now,
            },
            status: 'active',
            created_by: userId,
            // deleted_at: {
            //     [Op.is]: null,
            // }
        },
        // limit: 5,
        order: [
            ['datetime_estimation_end', 'DESC'] // Opsional: Mengurutkan berdasarkan datetime_estimation_end secara descending
        ],
    });

    Promise.all(jobOrders.map(async jobOrder => {
        const newItem = {
            user_id: userId,
            parent_id: jobOrder.id,
            parent_model: "App\\Models\\JobOrder",
        };

        const foundItem = await Notification.findOne({
            where: newItem,
        });

        if (!foundItem) {
            await Notification.create(newItem);
        }
    })).then(async (process) => {
        if (process) {
            const notifications = await Notification.findAll({
                where: {
                    is_show: false,
                },
                // limit: 5,
            });

            io.emit('get-notification', {
                data: notifications,
                now: now,
            });
        }
    }).catch(error => {
        // handle error
        console.log(error);
    });
    // }, 5000);

    // socket.on('notification', (message) => {
    //     console.log('message: ' + message);
    //     io.emit('send-notification', {
    //         message,
    //         user_id: userId,
    //     });
    // });

    socket.on('disconnect', () => {
        console.log('user disconnected');
    });
});

socketioModule.setIo(io);

// Express route for sending a message
app.post('/notification',
    (req, res) => NotificationController.sendMessage(req, res));

server.listen(3000, () => {
    console.log('listening on *:3000');
});
