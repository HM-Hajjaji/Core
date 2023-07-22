<?php

namespace Core\Component\Kernel;

use Core\Component\Http\Request;
use Core\Component\Http\Response;
use Core\Component\Validator\Validator;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;
use Route\Http\HttpRoute;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class Kernel
{
    protected ?string $projectDir = null;
    protected ?HttpRoute $httpRoute = null;
    protected ?EntityManager $entityManager = null;
    protected ?Run $whoops= null;
    protected ?Validator $validator= null;
    protected ?Request $request= null;
    protected ?Response $response= null;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->validator = new Validator();

        $this->whoops = new Run();
        $this->whoops->pushHandler(new PrettyPageHandler())->register();
    }


    /**
     * @throws \Exception
     */
    public function run(string $projectDir): void
    {
        $this->setProjectDir($projectDir);
        Dotenv::createImmutable($this->getProjectDir())->load();
        $this->entityManager = $this->handleEntityManager();

        $this->httpRoute= new HttpRoute(sprintf($this->getProjectDir()."/%s","source/Controller"));
        $this->httpRoute->resolve();
    }

    /**
     * @throws MissingMappingDriverImplementation
     * @throws Exception
     */
    private function handleEntityManager():EntityManager
    {
        $config = ORMSetup::createAttributeMetadataConfiguration([$this->getProjectDir()."/source"],true);
        $connection = DriverManager::getConnection((new DsnParser(['mysql' => "mysqli"]))->parse(env("DATABASE_URL")));
        return new EntityManager($connection, $config);
    }

    /**
     * @return HttpRoute
     */
    public function getHttpRoute(): HttpRoute
    {
        return $this->httpRoute;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @return Run
     */
    public function getWhoops(): Run
    {
        return $this->whoops;
    }

    /**
     * @return Validator
     */
    public function getValidator(): Validator
    {
        return $this->validator;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getProjectDir(): string
    {
        return $this->projectDir;
    }

    /**
     * @param string $projectDir
     * @return Kernel
     */
    public function setProjectDir(string $projectDir): static
    {
        $this->projectDir = $projectDir;
        return $this;
    }

}