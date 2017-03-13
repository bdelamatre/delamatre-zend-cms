<?php

namespace DelamatreZendCmsAdmin;

return array(

    //default routes
    'router' => array(
        'routes' => array(

            'cms-admin-default' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Admin',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Admin' => Controller\AdminController::class,
            'Admin\Controller\Settings' => Controller\SettingsController::class,
            'Admin\Controller\Help' => Controller\HelpController::class,
            'Admin\Controller\Blog' => Controller\BlogController::class,
            'Admin\Controller\Content' => Controller\ContentController::class,
            'Admin\Controller\Email' => Controller\EmailController::class,
            'Admin\Controller\EmailTemplate' => Controller\EmailTemplateController::class,
            'Admin\Controller\Gallery' => Controller\GalleryController::class,
            'Admin\Controller\CaseStudy' => Controller\CaseStudyController::class,
            'Admin\Controller\Document' => Controller\DocumentController::class,
            'Admin\Controller\Video' => Controller\VideoController::class,
            'Admin\Controller\WhitePaper' => Controller\WhitePaperController::class,
            'Admin\Controller\Filemanager' => Controller\FilemanagerController::class,
            'Admin\Controller\User' => Controller\UserController::class,
        ),
    ),

    'module_layouts' => array(
        'DelamatreZendCmsAdmin' => 'layout/admin',
        'ZfcUser' => 'layout/login',
    ),

    'view_manager' => array(
        'template_map' => array(
            'layout/admin'           => __DIR__ . '/../view/layout/admin.phtml',
            'layout/login'           => __DIR__ . '/../view/layout/login.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),


    'zfcuser' => array(

        /**
         * Login Redirect Route
         *
         * Upon successful login the user will be redirected to the entered route
         *
         * Default value: 'zfcuser'
         * Accepted values: A valid route name within your application
         *
         */
        'login_redirect_route' => 'cms-admin-default',

    ),

    //doctrine settings
    'doctrine' => array(
        //Doctrine Entity settings
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'default_driver' => array(
                'paths' => array(
                   // __DIR__ . '/../src/DelamatreZendCmsAdmin/Entity',
                ),
            ),
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    //'DelamatreZendCmsAdmin\Entity' => 'default_driver',
                )
            )
        ),

    ),

);
