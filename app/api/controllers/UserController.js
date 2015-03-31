module.exports = {
	'test': function(req, res, next) {
		console.log(req.params.message);
		res.end();
	}
};