module.exports = function(req, res, next) {
	res.locals.flash = {};
	if (!res.session.flash) return next();

	res.locals.flash = _.clone(res.session.flash);
	res.session.flash = {};

	next();
};