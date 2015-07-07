<?php 

namespace Csgt\Login;
use Config, View, Exception;

class Login {
	private $serviceFactory;
  private $clientId;
  private $clientSecret;
  private $scope = array();

  public function __construct(ServiceFactory $serviceFactory = null) {
    if (null === $serviceFactory) {
        // Create the service factory
        $serviceFactory = new ServiceFactory();
    }
    $this->serviceFactory = $serviceFactory;
  }

  public function setConfig($service) {
		$this->clientId     = config("csgtlogin::$service.clientid");
		$this->clientSecret = config("csgtlogin::$service.clientsecret");
		$this->scope        = config("csgtlogin::$service.scope", array());
  }

  public function createStorageInstance($storageName) {
    $storageClass = "\\OAuth\\Common\\Storage\\$storageName";
    $storage = new $storageClass();
    return $storage;
  }

  public function setHttpClient($httpClientName) {
    $httpClientClass = "\\OAuth\\Common\\Http\\Client\\$httpClientName";
    $this->serviceFactory->setHttpClient(new $httpClientClass());
  }

  public function consumer($service, $url = null, $scope = null) {
    // get config
    $this->setConfig( $service );

    // get storage object
    $storage = $this->createStorageInstance('Session');

    // create credentials object
    $credentials = new Credentials(
        $this->clientId,
        $this->clientSecret,
        $url ?: URL::current()
    );

    // check if scopes were provided
    if (is_null($scope)) {
      $scope = $this->scope;
    }

    // return the service consumer object
    return $this->serviceFactory->createService($service, $credentials, $storage, $scope);

  }
}