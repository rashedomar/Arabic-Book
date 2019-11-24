<?php

namespace Core;

use Core\DI\Container;
use Core\DI\Factory;
use Core\DI\Repository;

/**
 * Class App starts everything
 *
 * @package Core
 */
class App
{
    /**
     * App Object
     *
     * @var \Core\App
     */
    private static $instance = null;

    /**
     * Container object
     *
     * @var \Core\DI\Container
     */
    private $container;

    /**
     * App constructor
     */
    private function __construct()
    {
        $this->classRegister();
        $this->loadHelpers();
        $this->checkInstall();
        $this->container = Container::getInstance(new Factory(__DIR__.'/DI/services.json'), new Repository());
    }

    /**
     * Register classes with spl auto load
     */
    private function classRegister()
    {
        spl_autoload_register([$this, 'autoLoad']);
    }

    /**
     * Get helper functions
     *
     * @return void
     */
    private function loadHelpers()
    {
        require ROOT.DS.APP_DIR.DS.'System'.DS.'Helpers'.DS.'helpers'.EXT;
    }

    private function checkInstall()
    {
        if (is_dir(ROOT.DS.APP_DIR.DS.'public'.DS.'install')) {
            die('You should remove (Install) directory when you are done from it.');
        }
    }

    /**
     * create only one instance of this App through application (Singleton design pattern)
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * start the App
     */
    public function start()
    {
        //starts session
        $this->get('session')->start();

        //set the base and the request url
        $this->get('request')->setURLs();

        //check accessibility
        $this->access();

        //Get $controller, $method and $args
        extract($this->get('route')->dispatch());

        //Any controller should return a view object
        //Convert the view object to a string
        $output = (string) $this->get('load')->action($controller, $method, $args);

        //send the output to the response class
        $this->get('response')->setOutput($output);

        //print it
        $this->get('response')->send();
    }

    /**
     * Get an object from container by the given $key
     *
     * @param $key
     * @return object
     */
    public function get($key)
    {
        return $this->container->get($key);
    }

    /**
     * check accessibility to this app
     */
    private function access()
    {
        //get settings and share them through the app
        $this->share('settings', function () {
            $settings = $this->get('load')->model('Settings');

            return $settings->getSettings();
        });

        //check accessibility of the admin area
        if (strpos($this->get('request')->getUrl(), '/admin') === 0) {

            $this->get('load')->action('Admin/Access', 'index');

            //share admin admin layout
            $this->share('adminLayout', function () {
                return $this->get('load')->controller('Admin/Common/Layout');
            });
        } else {

            //share site layout
            $this->share('siteLayout', function () {
                return $this->get('load')->controller('Site/Common/Layout');
            });

            //check accessibility of the site area
            $this->get('load')->action('Site/Access', 'index');
        }
    }

    /**
     * share a service through the app
     *
     * @param $key
     * @param $value
     * @return void
     */
    public function share($key, $value)
    {
        $this->container->addService($key, $value);
    }

    /**
     * Load class by auto-loading
     *
     * @param $class
     * @throws \Exception
     * @return void
     */
    private function autoLoad($class)
    {
        $class = str_replace('\\', '/', $class);
        if (strpos($class, 'App') === 0) {
            $file = ROOT.DS.APP_DIR.DS.$class.EXT;
        } else {
            $file = ROOT.DS.APP_DIR.DS.'System'.DS.$class.EXT;
        }
        if (! file_exists($file)) {
            throw new \Exception($file.' Does Not Exists!');
        }
        require $file;
    }
}