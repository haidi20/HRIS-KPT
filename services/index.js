const express = require('express');
const http = require('http');
// const socketIo = require('socket.io');
const { Server } = require("socket.io");
const cors = require('cors');
const bodyParser = require('body-parser');
const mysql = require('mysql');

const socketioModule = require('./socketioModule');
const NotificationController = require("./controllers/NotificationController");


const app = express();
const server = http.createServer(app);
// const io = socketIo(server);

app.use(cors());
app.use(bodyParser.json());

// Database connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'hris_kpt'
});

const io = new Server(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"],
    },
});

let userSockets = new Map();

io.on('connection', (socket) => {
    console.log('a user connected');

    const userId = socket.handshake.query['user_id'];
    setInterval(() => {
        const message = 'Hello every 5 seconds';
        io.emit('get-notification', { user_id: userId });
    }, 5000);

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
