const http = require('http');
const cors = require('cors');
const moment = require('moment');
const express = require('express');
const { Server } = require("socket.io");
const bodyParser = require('body-parser');

const JobOrderController = require("./controllers/JobOrderController");

const socketioModule = require('./socketioModule');
const JobOrder = require('./models/jobOrder');

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

    // const timeInterval = 60000; // 1 menit
    const timeInterval = 5000; // 5 detik
    const now = moment().format('YYYY-MM-DD HH:mm:ss');
    // let now = moment().set({ month: 6, date: 27, hour: 22, minute: 30 }).format('Y-MM-DD HH:mm:ss');

    io.emit('test_send', { data: "send" });

    socket.on('send_user_id', (responses, callback) => {
        setInterval(async () => {
            const userId = responses.user_id;
            const getJobOrder = await JobOrderController.getJobOrderNotFinish({ now, userId: userId });

            socket.join(userId);

            io.to(userId).emit(`get_notification`, {
                data: getJobOrder,
                now,
                userId,
            });
        }, timeInterval);
    });

    socket.on('disconnect', () => {

        console.log('user disconnected');
    });
});

socketioModule.setIo(io);

app.get('/', async (req, res) => {
    res.send({ data: "service KPT", });
});
app.get('/test-connection', async (req, res) => {
    const data = await JobOrder.findAll();
    // let result = null;

    // result = await new Promise((resolve) => {
    //     setTimeout(() => {
    //         resolve('insert local');
    //     }, 1000)
    // });

    res.send({ data: data.length, });
});

server.listen(3003, () => {
    console.log('listening on *:3003');
});
