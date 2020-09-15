<?php

namespace App;

//use Dotenv\Dotenv;
use Dotenv\Dotenv2;
use Config;

class Application
{

    /**
     * @var Config
     */
    public $config;

    /**
     * @var array
     */
    protected $paths = [];

    public function __construct()
    {
		try {
		
			$this->setupPaths();
			$this->config = new Config();
			$this->config->loadConfigurationFiles($this->paths['config_path'], $this->getEnvironment());
		}
		catch (Exception $e) { 
		
			$status = const_Error_Conexion_WS;
			$status = -3;
			
			$comments = "<h2>Exception Error catched by the Reservaciones application!</h2>" . "<br>" . $e->getMessage(); 

			return $status;
		}
    }

    private function setupPaths()
    {
        $this->paths['env_file_path'] = __DIR__ . '/../';
        $this->paths['env_file']      = $this->paths['env_file_path'].'.env';
        $this->paths['config_path'] = __DIR__ . '/../config';
    }

    private function getEnvironment()
    {
        if (is_file($this->paths['env_file'])) {
            Dotenv2::load($this->paths['env_file_path']);
        }

        return getenv('ENVIRONMENT') ?: 'production';
    }
}