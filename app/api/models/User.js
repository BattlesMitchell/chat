var User = {
  // Enforce model schema in the case of schemaless databases
  schema: true,

  attributes: {
    email     : { type: 'email',  unique: true },
    passports : { collection: 'Passport', via: 'user' }
  }
};

module.exports = User;