const http = require('http');
const cors = require('cors');
const moment = require('moment');
const express = require('express');
const { Server } = require("socket.io");
const bodyParser = require('body-parser');

const JobOrder = require('./models/jobOrder');
const Notification = require('./models/notification');

const JobOrderController = require("./controllers/JobOrderController");

const socketioModule = require('./socketioModule');
const { updateOrCreate } = require("./utils");
const { includes } = require('lodash');

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

io.on('connection', async (socket) => {
    console.log('a user connected');

    // const timeInterval = 60000;
    const timeInterval = 5000;
    const userId = socket.handshake.query.user_id;
    const timestamp = socket.handshake.query.timestamp;
    let now = moment().format('Y-MM-DD HH:mm');

    setInterval(async () => {
        const timestampServer = moment().valueOf();
        const getJobOrder = await JobOrderController.getJobOrderNotFinish({ userId: 10, });

        if (timestamp) {
            io.emit('get-notification', {
                data: getJobOrder,
                now,
                userId: userId,
            });
        }
    }, timeInterval);

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
