<?php

namespace DelamatreZendCms;

return array(

    //default routes
    'router' => array(
        'routes' => array(

            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'DelamatreZendCms\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'sitemap' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/sitemap',
                    'defaults' => array(
                        'controller' => 'DelamatreZendCms\Controller\Index',
                        'action'     => 'sitemap',
                    ),
                ),
            ),
            'sitemap-xml' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/sitemap.xml',
                    'defaults' => array(
                        'controller' => 'DelamatreZendCms\Controller\Index',
                        'action'     => 'sitemapXml',
                    ),
                ),
            ),
            'contact' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/contact',
                    'defaults' => array(
                        'controller' => 'DelamatreZendCms\Controller\Index',
                        'action'     => 'contact',
                    ),
                ),
            ),
            'blog-post' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/blog/[:key][/:category]',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                        'controller' => 'DelamatreZendCms\Controller\Blog',
                        'action'     => 'post',
                    ),
                ),
            ),
            'blog' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/blog[/category/:category]',
                    'defaults' => array(
                        'controller' => 'DelamatreZendCms\Controller\Blog',
                        'action'     => 'index',
                        'category'     => 'all',
                    ),
                ),
            ),
            'submit-lead' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/submit-lead',
                    'defaults' => array(
                        'controller' => 'DelamatreZendCms\Controller\Lead',
                        'action'     => 'submit-lead',
                    ),
                ),
            ),
            'submit-newsletter' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/submit-newsletter',
                    'defaults' => array(
                        'controller' => 'DelamatreZendCms\Controller\Lead',
                        'action'     => 'submit-newsletter',
                    ),
                ),
            ),
            'thank-you' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/thank-you',
                    'defaults' => array(
                        'controller' => 'DelamatreZendCms\Controller\Lead',
                        'action'     => 'thank-you',
                    ),
                ),
            ),
            'thank-you-newsletter' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/thank-you-newsletter',
                    'defaults' => array(
                        'controller' => 'DelamatreZendCms\Controller\Lead',
                        'action'     => 'thank-you-newsletter',
                    ),
                ),
            ),
            'cms-default' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'DelamatreZendCms\Controller',
                        'controller'    => 'Index',
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
            'DelamatreZendCms\Controller\Index' => Controller\IndexController::class,
            'DelamatreZendCms\Controller\Blog' => Controller\BlogController::class,
            'DelamatreZendCms\Controller\Lead' => Controller\LeadController::class,
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            //'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    //custom view helpers
    'view_helpers' => array(
        'invokables'=> array(
            'cmsContent'        => 'DelamatreZendCms\View\Helper\CmsContent',
        )
    ),

    //doctrine settings
    'doctrine' => array(
        //Doctrine Entity settings
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'default_driver' => array(
                'paths' => array(
                    __DIR__ . '/../src/DelamatreZendCms/Entity',
                ),
            ),
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'DelamatreZendCms\Entity' => 'default_driver',
                )
            )
        ),

    ),

);
