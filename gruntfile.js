/*global module:false*/
module.exports = function(grunt) {

	grunt.initConfig({

		jekyll: {
			watch: true,
			serve: true,
			options: {
				serve: true,
				watch: true,
				config: '_config.yml,_config.dev.yml'
			}
		}
	});

	grunt.loadNpmTasks('grunt-jekyll');

	grunt.registerTask('default', 'jekyll');
};
