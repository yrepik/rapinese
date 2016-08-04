module.exports = function(grunt) {

    var baseJsFiles = [
        "./bower_components/jquery/jquery.js",
        "./bower_components/bootstrap/js/alert.js",
        "./bower_components/bootstrap/js/collapse.js",
        "./bower_components/angular/angular.js",
        "./bower_components/angular-i18n/angular-locale_es-ar.js",
        "./bower_components/angular-animate/angular-animate.js",                  
        "./bower_components/angular-bootstrap/ui-bootstrap-tpls.js",
        "./resources/assets/js/app.js"
    ];

    grunt.initConfig({
        less: {
            dist: {
                src: "./resources/assets/less/styles.less",
                dest: "./public/css/styles.css"
            }
        },
        concat: {
            base: {
                src: baseJsFiles,
                dest: "./public/js/base.js"
            },
            home: {
                src: [
                    "./resources/assets/js/home.js"
                ],
                dest: "./public/js/home.js"
            },
            products: {
                files: {
                    "./public/js/products.js": [
                        "./resources/assets/js/products.js"
                    ]
                }
            },            
            cart: {
                src: [
                    "./bower_components/angular-confirm/angular-confirm.js",
                    "./resources/assets/js/cart.js"
                ],
                dest: "./public/js/cart.js"
            }            
        }, 
        uglify: {
            options: {
                mangle: false
            },
            base: {
                files: {
                    "./public/js/base.js": baseJsFiles
                }
            },
            home: {
                files: {
                    "./public/js/home.js": [
                        "./resources/assets/js/home.js"
                    ]
                }
            },         
            products: {
                files: {
                    "./public/js/products.js": [
                        "./resources/assets/js/products.js"
                    ]
                }
            },
            cart: {
                src: [
                    "./bower_components/angular-confirm-modal/angular-confirm.js",
                    "./resources/assets/js/cart.js"
                ],
                dest: "./public/js/cart.js"
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
            },
            uglifyCart: {
                files: "./resources/assets/js/cart.js",
                tasks: ["uglify:cart"]
            }
        },
        copy: {
            env: {
                files: [
                    {src: ['.env.example'], dest: '.env'}
                ]
            },   
            fonts: {
                files: [
                    {expand: true, flatten: true, src: ['bower_components/bootstrap/dist/fonts/*'], dest: 'public/fonts/'},
                    {expand: true, flatten: true, src: ['bower_components/components-font-awesome/fonts/*'], dest: 'public/fonts/'}
                ]
            }
        },
        exec: {
            composer_install: {
                command: "composer install"
            },		
            bower_install: {
                command: "bower install"
            },
            artisan_migrate: {
                command: "php artisan migrate"
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

    grunt.registerTask("install", function(arg) {
        grunt.task.run(
            "exec:composer_install", 
            //"exec:artisan_migrate",
            "exec:bower_install", 
            "copy:fonts", 
            "cssmin", 
            "less", 
            "uglify"
        );
    });  

};