module.exports = {
	schema: true,
	attributes: {
		type: { type: 'string', enum: ['text', 'image', 'system'] }
		
		author: { type: 'string', required: true },
		authorImageURL: { type: 'string' },
		content: { type: 'string' }
	},