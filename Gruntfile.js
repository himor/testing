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
                'public/js/*.js'
            ]
        },
        concat: {
            options: {
                stripBanners: true,
            },
            admin: {
                src: [
                    'public/js/vendor/bootstrap.min.js',
                    'public/js/dashboard.js'
                ],
                dest: 'public/temp/js/admin.js'
            },
            dist: {
                src: [
                    'public/js/main.js',
                ],
                dest: 'public/temp/js/main.js'
            },
        },
        uglify: 
        { 
            options: {
                stripBanners: true,
                banner: '/* <%= pkg.name %> | Main JS | build <%= grunt.template.today("yyyy-mm-dd") %> */\n\n'
            },
            build: {
                src: 'public/temp/js/main.js',  
                dest: 'public/build/js/main.js'
            },
            admin: {
                src: 'public/temp/js/admin.js',  
                dest: 'public/build/js/admin.js'
            }
        },
        cssmin: 
        { 
            build: {
                options: {
                    banner: '/* <%= pkg.name %> | Main CSS | build <%= grunt.template.today("yyyy-mm-dd") %> */\n'
                },
                files: {
                    'public/build/css/main.css': [
                        'public/css/normalize.css', 
                        'public/css/main.css'
                    ]   
                }
            },
            admin: {
                options: {
                    banner: '/* <%= pkg.name %> | Admin CSS | build <%= grunt.template.today("yyyy-mm-dd") %> */\n'
                },
                files: {
                    'public/build/css/admin.css': [
                        'public/css/bootstrap.min.css',
                        'public/css/bootstrap-theme.min.css',
                        'public/css/dashboard.css'
                    ]   
                }
            }
        },
        imagemin: 
        {                        
            main: {      
                options: {
                    optimizationLevel: 1,
                    progressive: true
                },                
                files: [
                    {
                            expand: true,            
                            cwd: 'public/img/',        
                            src: 
                            [
                                '**/*.{jpg,gif,png}'
                            ],
                            dest: 'public/build/img'
                    }
                ]
            }
        },
        clean: 
        {
            build: ['public/build'],
            temp: ['public/temp']
        },
        copy: {
            admin: 
            {
                files: [
                    {
                        expand: true,
                        cwd: 'public/fonts',
                        src: '*',
                        dest: 'public/build/fonts/'
                    },
                    {
                        src: 'public/js/vendor/jquery-1.11.1.min.js',
                        dest: 'public/build/js/vendor/jquery-1.11.1.min.js'
                    }
                ]
            }
        }
    });
 
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
 
    grunt.registerTask('default', ['jshint', 'clean:build', 'concat', 'uglify', 'clean:temp', 'imagemin', 'cssmin', 'copy']); 
};