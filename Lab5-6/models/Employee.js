const mongoose = require('mongoose');

const employeeSchema = new mongoose.Schema({
  first_name: String,
  last_name: String,
  room_number: Number
});

module.exports = mongoose.model('Employee', employeeSchema);
