const { defineConfig } = require("cypress");

module.exports = defineConfig({
		env: {
			wp_username: 'cyadmin',
			wp_password: 'KzYZqv&0ISx1gJKBH5NqA',
		},
  		e2e: {

			baseUrl: 'http://localhost:10386',
    		setupNodeEvents(on, config) {
      		// implement node event listeners here
    	},
	},
});
