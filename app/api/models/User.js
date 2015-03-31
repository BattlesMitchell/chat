module.exports = { 
	schema: true,
	attributes: {
		email: { type: 'email', unique: true },
		passports: { collection: 'Passport', via: 'user' }
	}
};