module.exports = {
	
	login: function (req, res) {
		var bcrypt = require('bcrypt');
		var INVALID_LOGIN_MESSAGE = 'Bad email and password combination!';

		// find user with specified email
		User.findOneByEmail(req.body.email).done(function (err, user) {

			// not found
			if (err) res.json({ error: 'Database error.' }, 500);

			// user found
			if (user) {

				// compare user entry vs stored encrypted password
				bcrypt.compare(req.body.password, user.password, function (err, match) {

					// bad password
					if (err) res.json({ error: 'Database error.' }, 500);

					// good login
					if (match) {

						// setup session and return user information
						req.session.user = user.id;
						res.json(user);

					} else {
						if (req.session.user) req.session.user = null;
						res.json({ error: invalidLoginMessage }, 400);
			  		}
				});

			// user not found
			} else {
				res.json({ error: invalidLoginMessage }, 400);
			}
		});	
	},

	'new': function (req, res) {

		// returns new.jade
		res.view();
	},

	create: function (req, res) {

		// attempt to create a new user
		User.create(req.params.all(), function (err, user) {

			// bad attempt
			if (err) return;// next(err);

			// user created
			res.json(user);
		});
	}
};