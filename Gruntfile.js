module.exports = function(grunt) {

    grunt.initConfig({
        less: {
            dist: {
                src: "./resources/assets/less/styles.less",
                dest: "./public/css/styles.css"
            }
        },
        concat: {
            base: {
                src: [
                    "./bower_components/jquery/jquery.js",
                    "./bower_components/bootstrap/js/alert.js",
                    "./bower_components/bootstrap/js/collapse.js",                      
                    //"./bower_components/bootstrap/js/dropdown.js",
                    //"./bower_components/bootstrap/js/transition.js",
                    "./bower_components/angular/angular.js",
                    "./bower_components/angular-animate/angular-animate.js",                  
                    "./bower_components/angular-bootstrap/ui-bootstrap-tpls.js",
                    "./resources/assets/js/app.js"
                ],
                dest: "./public/js/base.js"
            },
            home: {
                src: [
                    "./resources/assets/js/home.js"
                ],
                dest: "./public/js/home.js"
            }            
        }, 
        uglify: {
            options: {
                mangle: false
            },
            base: {
                files: {
                    "./public/js/base.js": [
                        "./bower_components/jquery/jquery.js",
                        "./bower_components/bootstrap/js/alert.js",
                        "./bower_components/bootstrap/js/collapse.js",                      
                        //"./bower_components/bootstrap/js/dropdown.js",
                        //"./bower_components/bootstrap/js/transition.js",
                        "./bower_components/angular/angular.js",
                        "./bower_components/angular-animate/angular-animate.js",
                        "./bower_components/angular-bootstrap/ui-bootstrap-tpls.js",
                        "./resources/assets/js/app.js"
                    ]
                }
            },
            home: {
                files: {
                    "./public/js/home.js": [
                        //"./bower_components/bootstrap/js/carousel.js",
                        "./resources/assets/js/home.js"
                    ]
                }
            },         
            products: {
                files: {
                    "./public/js/products.js": [
                        //"./bower_components/bootstrap/js/modal.js",
                        "./resources/assets/js/products.js"
                    ]
                }
            }
        },  
        cssmin: {
            options: {
                shorthandCompacting: false,
                roundingPrecision: -1
            },
            target: {
                files: {
                    "./public/css/lib.css": [
                        "./bower_components/bootstrap/dist/css/bootstrap.min.css",
                        "./bower_components/components-font-awesome/css/font-awesome.min.css"
                    ]
                }
            }
        },          
        watch: {
            options: {
                atBegin: true
            },
            less: {
                files: "./resources/assets/less/*.less",
                tasks: ["less"]
            },
            uglifyBase: {
                files: "./resources/assets/js/app.js",
                tasks: ["uglify:base"]
            }, 
            uglifyHome: {
                files: "./resources/assets/js/home.js",
                tasks: ["uglify:home"]
            },                       
            uglifyProducts: {
                files: "./resources/assets/js/products.js",
                tasks: ["uglify:products"]
            }                              
        },
        copy: {
            fonts: {
                files: [
                    {expand: true, flatten: true, src: ['bower_components/bootstrap/dist/fonts/*'], dest: 'public/fonts/'},
                    {expand: true, flatten: true, src: ['bower_components/components-font-awesome/fonts/*'], dest: 'public/fonts/'}
                ]
            }
        },
        exec: {
            bower_install: {
                command: "bower install"
            }
        },        
        mysqlrunfile: {
            updates: {
                options: {
                    connection: {
                        host: 'localhost',
                        username: 'root',
                        password: '1234',
                        database: 'rapinese',
                        multipleStatements: true
                    }                        
                },
                src: './rapi_updates.sql'
            }
        }        
    });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-exec');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-mysql-runfile');

    grunt.registerTask("install", function(arg) {
        if (arg == "clean") {
            grunt.file.delete("./bower_components");
        }
        grunt.task.run("exec:bower_install", "copy:fonts", "cssmin");
    });  

};