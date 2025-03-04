const mongoose = require('mongoose');

const issuanceSchema = new mongoose.Schema({
  employee_id: { type: mongoose.Schema.Types.ObjectId, ref: 'Employee' },
  item_id: { type: mongoose.Schema.Types.ObjectId, ref: 'Item' },
  issue_date: Date
});

module.exports = mongoose.model('Issuance', issuanceSchema);
