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

    'module_layouts' => array(
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

);
