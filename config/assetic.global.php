<?php

namespace DelamatreZend;

return array(

    //default assetic configuration
    'assetic_configuration' => array(

        'routes' => array(
            'cms-admin(.*)' => array(
                '@admin_css',
                '@admin_js',
            ),
            'zfcuser(.*)' => array(
                '@admin_css',
                '@admin_js',
            ),
        ),

        'modules' => array(
            'delamatre-zend-cms-admin' => array(
                'root_path' => __DIR__.'/../bower_components',

                'collections' => array(
                    'admin_js' => array(
                        'assets' => array(
                            'jquery-ui/jquery-ui.js',
                            'summernote/dist/summernote.js',
                            'elfinder/js/elfinder.full.js',
                            'summernote-ext-elfinder-master/summernote-ext-elfinder.js',
                            '../public/assets/admin/admin.js',
                        ),
                        'filters' => array(
                            '?JSMinFilter' => array(
                                'name' => 'Assetic\Filter\JSMinFilter'
                            ),
                        ),
                    ),
                    'admin_css' => array(
                        'assets' => array(
                            'summernote/dist/summernote.css',
                            'elfinder/css/elfinder.full.css',
                            'elfinder/css/theme.css',
                            '../public/assets/admin/admin.css',
                        ),
                        'filters' => array(
                            'CssRewriteFilter' => array(
                                'name' => 'Assetic\Filter\CssRewriteFilter'
                            ),
                            '?CssMinFilter' => array(
                                'name' => 'Assetic\Filter\CssMinFilter'
                            ),
                        ),
                    ),
                ),
            ),
        ),

    ),

);
