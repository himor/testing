// node -e "require('grunt').tasks(['default']);"

module.exports = function (grunt) 
{
    grunt.initConfig(
    {
        pkg: grunt.file.readJSON('package.json'),
        jshint: {
            options: {
                devel:     true,
                browser:   true,
                curly:     true,
                eqeqeq:    true,
                forin:     true,
                freeze:    true,
                immed:     true,
                latedef:   true,
                newcap:    true,
                noarg:     true,
                nonew:     true,
                smarttabs: true,
                sub:       true,
                undef:     false,
                validthis: true
            },
            files:  
            [
                //
            ]
        },
        uglify: 
        { 
            options: 
            {
                stripBanners: true,
                banner: '/* <%= pkg.name %> | Main JS | build <%= grunt.template.today("yyyy-mm-dd") %> */\n\n'
            },
            build: 
            {
                src: 'src/js/main.js',  
                dest: 'build/js/main.js'
            }
        },
        cssmin: 
        { 
            build: 
            {
                options: 
                {
                    banner: '/* <%= pkg.name %> | Main CSS | build <%= grunt.template.today("yyyy-mm-dd") %> */\n'
                },
                files: 
                {
                    'build/css/main.css': 
                    [
                        'src/css/normalize.css', 
                        'src/css/main.css'
                    ]   
                }
            }
        },
        imagemin: 
        {                        
            main: 
            {      
                options: 
                {
                    optimizationLevel: 1,
                    progressive: true
                },                
                files: 
                [
                    {
                        expand: true,            
                        cwd: 'src/img/',        
                        src: 
                        [
                            '*.{jpg,gif,png}'
                        ],
                        dest: 'build/img'
                    },
                    {
                        expand: true,            
                        cwd: 'storage/',        
                        src: 
                        [
                            '*.{jpg,gif,png}'
                        ],
                        dest: 'build/storage'
                    }
                ]
            }
        },
        clean: 
        {
            build: ['build']
        },
    });
 
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
 
    grunt.registerTask('default', ['jshint', 'clean:build', 'uglify', 'cssmin', 'imagemin']); 
};