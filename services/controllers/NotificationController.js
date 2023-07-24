const socketioModule = require('../socketioModule');

exports.sendMessage = (req, res, params) => {
    // This is where you'd get your message from the request, e.g. req.body.message
    const message = req.body?.message;
    // const user_id = req.body?.user_id;

    const io = socketioModule.getIo();
    // Emit the message to all connected clients
    io.emit('get-notification', {
        message
    });

    res.json({ message: `Message sent! ${message}` });
}
