const http = require('http');
const cors = require('cors');
const moment = require('moment');
const express = require('express');
const { Server } = require("socket.io");
const bodyParser = require('body-parser');

const JobOrderController = require("./controllers/JobOrderController");

const socketioModule = require('./socketioModule');

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
    // const userId = socket.handshake.query.user_id;
    const timestampServer = moment().format('Y-MM-DD HH:mm');
    const timestamp = socket.handshake.query.timestamp;
    // const now = moment().format('YYYY-MM-DD HH:mm:ss');
    let now = moment().set({ month: 6, date: 27, hour: 22, minute: 30 }).format('Y-MM-DD HH:mm:ss');

    socket.on('send_user_id', (responses, callback) => {
        setInterval(async () => {
            const userId = responses.user_id;
            const getJobOrder = await JobOrderController.getJobOrderNotFinish({ now, userId: userId });

            socket.join(userId);

            io.to(userId).emit(`get_notification`, {
                data: getJobOrder,
                now,
                timestamp,
                timestampServer,
                userId,
            });
        }, timeInterval);
    });

    socket.on('disconnect', () => {

        console.log('user disconnected');
    });
});

socketioModule.setIo(io);

server.listen(3000, () => {
    console.log('listening on *:3000');
});
