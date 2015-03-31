module.exports = {
	feed: function(req, res, next) {
		var limit = req.body.limit || 30;
		var page = req.body.page;

		var test = {
			messages: [
				{
					type: 'text',
					author: 'Conner Ruhl',
					content: 'Hello, World!'
				}
			]
		};
		
		res.json(test);
	}
};