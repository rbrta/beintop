const middleware = {}

middleware['manager'] = require('..\\middleware\\manager.js')
middleware['manager'] = middleware['manager'].default || middleware['manager']

export default middleware
