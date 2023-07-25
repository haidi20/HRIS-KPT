const { Sequelize, DataTypes } = require('sequelize');
const db = require('../database');

const Notification = db.define('Notification', {
    id: {
        type: DataTypes.BIGINT,
        autoIncrement: true,
        primaryKey: true
    },
    user_id: {
        type: DataTypes.BIGINT,
        allowNull: false
    },
    parent_id: {
        type: DataTypes.BIGINT,
        allowNull: false
    },
    parent_model: {
        type: DataTypes.STRING,
        allowNull: false
    },
    readed_at: {
        type: DataTypes.DATE,
        allowNull: true
    },
    is_show: {
        type: DataTypes.BOOLEAN,
        defaultValue: false
    },
    created_at: {
        type: DataTypes.DATE,
        allowNull: false
    },
    updated_at: {
        type: DataTypes.DATE,
        allowNull: false
    },
}, {
    tableName: 'notifications',
    underscored: true,
    timestamps: true,   // this option states that we are using Sequelize's built-in timestamps.
    createdAt: 'created_at',
    updatedAt: 'updated_at'
});

module.exports = Notification;
