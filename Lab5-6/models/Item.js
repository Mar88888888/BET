const mongoose = require('mongoose');

const itemSchema = new mongoose.Schema({
  name: String,
  weight: Number,
  material: String
});

module.exports = mongoose.model('Item', itemSchema);