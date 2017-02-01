<?php

return array(

    //doctrine settings
    'doctrine' => array(
        //Doctrine Entity settings
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'default_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
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