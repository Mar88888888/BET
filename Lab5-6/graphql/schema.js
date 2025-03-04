const { buildSchema } = require('graphql');

const schema = buildSchema(`
  type Item {
    id: ID!
    name: String!
    weight: Float!
    material: String!
  }

  type Employee {
    id: ID!
    first_name: String!
    last_name: String!
    room_number: Int!
  }

  type Issuance {
    id: ID!
    employee: Employee!
    item: Item!
    issue_date: String!
  }

  type Query {
    items: [Item]
    employees: [Employee]
    issuances: [Issuance]
  }

  type Mutation {
    addItem(name: String!, weight: Float!, material: String!): Item
    addEmployee(first_name: String!, last_name: String!, room_number: Int!): Employee
    addIssuance(employee_id: ID!, item_id: ID!, issue_date: String!): Issuance

    updateItem(id: ID!, name: String, weight: Float, material: String): Item
    updateEmployee(id: ID!, first_name: String, last_name: String, room_number: Int): Employee
    updateIssuance(id: ID!, employee_id: ID, item_id: ID, issue_date: String): Issuance

    deleteItem(id: ID!): Boolean
    deleteEmployee(id: ID!): Boolean
    deleteIssuance(id: ID!): Boolean
  }
`);

module.exports = schema;
