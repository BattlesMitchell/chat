module.exports = {

	schema: true,

	attributes: {
		email: {
			type: 'email',
			required: true,
			unique: true
		},
		password: {
			type: 'text',
			required: true,
			size: 60
		},

		toJSON: function () {
			var obj = this.toObject();
			delete obj.password;
			delete obj._csrf;
			return obj;
		}
	},

	beforeCreate: function (attrs, next) {
		var bcrypt = require('bcrypt');

		bcrypt.genSalt(10, function(err, salt) {
			if (err) return next(err);

			bcrypt.hash(attrs.password, salt, function(err, hash) {
				if (err) return next(err);

				attrs.password = hash;
				next();
			});
		});
	}
};