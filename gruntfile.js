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
		},
		compass: {
			dist: {
				options: {
					sassDir: 'sass',
					cssDir: 'css',
					environment: 'production'
				}
			}
		}

	});

	grunt.loadNpmTasks('grunt-jekyll');
	grunt.loadNpmTasks('grunt-contrib-compass');

	grunt.registerTask('default', 'jekyll');
};
