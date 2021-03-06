<?php

namespace DelamatreZendCms\Navigation;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class DynamicNavigation extends DefaultNavigationFactory
{

    public static function recursiveAddPages(EntityManager $em,&$configuration,$route,$results,$parentId=0){

        foreach($results as $key=>$result){

            if($result['parent_id']==$parentId){

                $pages = array();
                static::recursiveAddPages($em,$pages,$route,$results,$result['id']);

                $configuration[] = array(
                    'label'=> $result['title'],
                    'route'=>$route,
                    'params'=>array('key' => $result['key']),
                    'result'=>$result,
                    'pages'=>$pages,
                );

            }

        }

        return $configuration;
    }

    public static function recursiveSearch(EntityManager $em,$configuration){

        //cycle through the navigation configuration and add the dynamic content
        foreach($configuration as $key=>$page){

            $route = false;
            $queryBuilder = $em->createQueryBuilder();
            $queryBuilder->select('e');

            if($page['entity']){
                $isDynamic=true;
                $route = $page['entity_route'];
                $queryBuilder->from($page['entity'],'e');
            }else{
                $isDynamic=false;
                $queryBuilder->from('DelamatreZendCms\Entity\Content','e');
            }


            if($isDynamic==true){

                $queryBuilder->where('e.active=1');
                $queryBuilder->orderBy("e.sortOrder",'ASC');
                $queryBuilder->addOrderBy("e.title",'ASC');

                $results = $queryBuilder->getQuery()->getArrayResult();

                if($page['depth']>0){

                    self::recursiveAddPages($em,$configuration[$key]['pages'],$route,$results);

                }else{

                    foreach($results as $result){

                        $configuration[$key]['pages'][] = array(
                            'label'=> $result['title'],
                            'route'=>$route,
                            'params'=>array('key' => $result['key']),
                            'result'=>$result,
                        );

                    }

                }

            }else{

                $queryBuilder->where('e.active=1');
                $queryBuilder->andWhere('e.key=:key');
                $queryBuilder->setParameter('key',$page['route']);
                $result = $queryBuilder->getQuery()->getArrayResult();
                $result = $result[0];

                $configuration[$key]['result'] = $result;

                if(!empty($page['pages'])){
                    $configuration[$key]['pages'] = static::recursiveSearch($em,$configuration[$key]['pages']);
                }

            }

        }

        return $configuration;

    }

    /**
     *
     * Overrides the default getPages function adds the dynamic content here
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return array
     */
    protected function getPages(ContainerInterface $container)
    {

        //get the top level configuration from the global configuration file
        $configuration = $container->get('config');

        //get the entityManager so that we can query records
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get('doctrine.entitymanager.orm_default');

        //search for records and add pages
        $configuration['navigation'][$this->getName()] = static::recursiveSearch($em,$configuration['navigation'][$this->getName()]);

        //override the configuration with the new one
        $container->setAllowOverride(true);
        $container->setService('config',$configuration);
        $container->setAllowOverride(false);

        //get and return the [ages
        $this->pages = parent::getPages($container);
        return $this->pages;


    }

}