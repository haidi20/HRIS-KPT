const moment = require('moment');
const express = require('express');

const JobOrder = require("../models/jobOrder");
const { Op, literal } = require('sequelize');
const Project = require('../models/project');
const sequelize = require('../database');

exports.getJobOrderNotFinish = async ({ now, userId }) => {
    let jobOrders = [];

    jobOrders = await JobOrder.findAll({
        where: {
            [Op.and]: [
                literal(`DATE_FORMAT(DATE_SUB(datetime_estimation_end, INTERVAL 15 MINUTE), '%Y-%m-%d %H:%i:%s') <= '${now}'`),
                { status: 'active' }, // Filter by status = 'active'
                { created_by: userId },
            ],
        },
    });

    return jobOrders;
}
