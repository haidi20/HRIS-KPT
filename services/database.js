const { Sequelize } = require('sequelize');

const sequelize = new Sequelize('hris_kpt', 'root', '', {
    host: 'localhost',
    dialect: 'mysql'
});

module.exports = sequelize;
