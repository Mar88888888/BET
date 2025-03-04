const Item = require('../models/Item');
const Employee = require('../models/Employee');
const Issuance = require('../models/Issuance');

const resolvers = {
  items: async () => await Item.find(),
  employees: async () => await Employee.find(),
  issuances: async () => await Issuance.find().populate('employee_id').populate('item_id'),

  addItem: async ({ name, weight, material }) => {
    const item = new Item({ name, weight, material });
    await item.save();
    return item;
  },

  addEmployee: async ({ first_name, last_name, room_number }) => {
    const employee = new Employee({ first_name, last_name, room_number });
    await employee.save();
    return employee;
  },

  addIssuance: async ({ employee_id, item_id, issue_date }) => {
    const issuance = new Issuance({ employee_id, item_id, issue_date });
    await issuance.save();
    return issuance;
  },

  updateItem: async ({ id, name, weight, material }) => {
    return await Item.findByIdAndUpdate(id, { name, weight, material }, { new: true });
  },

  updateEmployee: async ({ id, first_name, last_name, room_number }) => {
    return await Employee.findByIdAndUpdate(id, { first_name, last_name, room_number }, { new: true });
  },

  updateIssuance: async ({ id, employee_id, item_id, issue_date }) => {
    return await Issuance.findByIdAndUpdate(id, { employee_id, item_id, issue_date }, { new: true });
  },

  deleteItem: async ({ id }) => {
    await Issuance.deleteMany({ item_id: id });
    await Item.findByIdAndDelete(id);
    return true;
  },

  deleteEmployee: async ({ id }) => {
    await Issuance.deleteMany({ employee_id: id });
    await Employee.findByIdAndDelete(id);
    return true;
  },

  deleteIssuance: async ({ id }) => {
    await Issuance.findByIdAndDelete(id);
    return true;
  }
};

module.exports = resolvers;
