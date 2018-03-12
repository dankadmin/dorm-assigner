<?php
namespace OTPropelMigration;

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use RuntimeException;
use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
use OTPropel;

class MigrationBootstrap {
    protected static $serviceManager;
    protected static $config;
    protected static $bootstrap;

    public static function init()
    {
        $moduleConfig      = include __DIR__ . '/../../config/module.config.php';
        $applicationConfig = include __DIR__ . '/../../../../config/application.config.php';

        $zf2ModulePaths = array();
        if (isset($applicationConfig['module_listener_options']['module_paths'])) {
            $modulePaths = $applicationConfig['module_listener_options']['module_paths'];
            foreach($modulePaths as $modulePath) {
                if (($path = static::findParentPath($modulePath))) {
                    $zf2ModulePaths[] = $path;
                }
            }
        }

        if (isset($applicationConfig['module_listener_options']['config_glob_paths'])) {
            $globConfigs = $applicationConfig['module_listener_options']['config_glob_paths'];
            foreach ($globConfigs as $globConfig) {
                $localConfig = include __DIR__ . '/../../../../config/autoload/local.php';
                $globalConfig = include __DIR__ . '/../../../../config/autoload/global.php';
            }
        }

        $zf2ModulePaths  = implode(PATH_SEPARATOR, $zf2ModulePaths) . PATH_SEPARATOR;

    static::initAutoloader();
        $baseConfig = array(
                'module_listener_options' => array(
                        'module_paths' => explode(PATH_SEPARATOR, $zf2ModulePaths),
                ),
    );

        $config = ArrayUtils::merge($moduleConfig, $applicationConfig);
        $config = ArrayUtils::merge($config, $baseConfig);
    $config = ArrayUtils::merge($config, $localConfig);
        $config = ArrayUtils::merge($config, $globalConfig);
        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();

        static::$serviceManager = $serviceManager;
        static::$config         = $config;

        $serviceContainer            = Propel::getServiceContainer();
        $connectionName              = 'product_catalog';
        $propelConfig                = $config['propel'];
    list($dsn, $dbUser, $dbPass) = static::generateDsn($connectionName, $propelConfig['database']['connections']);
        $serviceContainer->setAdapterClass($connectionName, 'mysql');
        $manager = new ConnectionManagerSingle();
        $manager->setConfiguration(
                array(
                        'dsn'      => $dsn,
                        'user'     => $dbUser,
                        'password' => $dbPass
                )
        );
        $serviceContainer->setConnectionManager($connectionName, $manager);
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    public static function getConfig()
    {
        return static::$config;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (is_readable($vendorPath . '/autoload.php')) {
            $loader = include $vendorPath . '/autoload.php';
        } else {
            $zf2Path = getenv('ZF2_PATH') ? : (defined('ZF2_PATH') ? ZF2_PATH : (is_dir($vendorPath . '/ZF2/library') ? $vendorPath . '/ZF2/library' : false));
        if (!$zf2Path ) {
                throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable');
            }
            include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
        }


        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
        'autoregister_zf' => true,
                'namespaces' => array(
                __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    protected static function findParentPath($path) {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) return false;
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }

    protected static function generateDsn($connectionName, $config) {
        if ($config[$connectionName]['dbname']) {
            $dbName = $config[$connectionName]['dbname'];
        } else {
            $dbName = $config['default']['dbname'];
        }
        if ($config[$connectionName]['host']) {
            $dbHost = $config[$connectionName]['host'];
        } else {
            $dbHost = $config['default']['host'];
        }
        if ($config[$connectionName]['user']) {
            $dbUser = $config[$connectionName]['user'];
        } else {
            $dbUser = $config['default']['user'];
        }
        if ($config[$connectionName]['password']) {
            $dbPass = $config[$connectionName]['password'];
        } else {
            $dbPass = $config['default']['password'];
        }

        $dsnString = 'mysql:host=' . $dbHost . ';dbname=' . $dbName;
        return array($dsnString, $dbUser, $dbPass);
    }
}
