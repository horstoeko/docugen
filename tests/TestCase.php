<?php

namespace horstoeko\docugen\tests;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use \PHPUnit\Framework\TestCase as PhpUnitTestCase;

abstract class TestCase extends PhpUnitTestCase
{
    /**
     * Registered files that should be deleted in test case teardown
     *
     * @var array
     */
    protected static $registeredTestCaseFiles = [];

    /**
     * Registered files that should be deleted in test teardown
     *
     * @var array
     */
    protected $registeredTestFiles = [];

    /**
     * @inheritDoc
     */
    public static function setUpBeforeClass(): void
    {
        self::$registeredTestCaseFiles = [];
    }

    /**
     * @inheritDoc
     */
    public static function tearDownAfterClass(): void
    {
        foreach (self::$registeredTestCaseFiles as $registeredTestCaseFile) {
            if (file_exists($registeredTestCaseFile) && is_writable($registeredTestCaseFile)) {
                @unlink($registeredTestCaseFile);
            }
        }

        self::$registeredTestCaseFiles = [];
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registeredTestFiles = [];
    }

    /**
     * @inheritDoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        foreach ($this->registeredTestFiles as $registeredTestFile) {
            if (file_exists($registeredTestFile) && is_writable($registeredTestFile)) {
                @unlink($registeredTestFile);
            }
        }

        $this->registeredTestFiles = [];
    }

    /**
     * Register a file to delete in testcase teardown
     *
     * @param  string $filename
     * @return void
     */
    public function registerFileForTestCaseTeardown(string $filename): void
    {
        self::$registeredTestCaseFiles[] = $filename;
    }

    /**
     * Register a file to delete in testmethod teardown
     *
     * @param  string $filename
     * @return void
     */
    public function registerFileForTestMethodTeardown(string $filename): void
    {
        $this->registeredTestFiles[] = $filename;
    }

    /**
     * Expect notice on php version smaller than 8
     * Expect warning on php version greater or equal than 8
     *
     * @return void
     */
    public function expectNoticeOrWarning(): void
    {
        if (version_compare(phpversion(), '8', '>=')) {
            $this->expectWarning();
        } else {
            $this->expectNotice();
        }
    }

    /**
     * Access to private properties
     *
     * @param  string $className
     * @param  string $propertyName
     * @return ReflectionProperty
     */
    public function getPrivatePropertyFromClassname(string $className, string $propertyName): ReflectionProperty
    {
        $reflectionClass = new ReflectionClass($className);
        $reflectionProperty = $reflectionClass->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty;
    }

    /**
     * Access to private properties
     *
     * @param  object $object
     * @param  string $propertyName
     * @return ReflectionProperty
     */
    public function getPrivatePropertyFromObject(object $object, string $propertyName): ReflectionProperty
    {
        $reflectionClass = new ReflectionClass($object);
        $reflectionProperty = $reflectionClass->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty;
    }

    /**
     * Access to private method
     *
     * @param  string $className
     * @param  string $methodName
     * @return ReflectionMethod
     */
    public function getPrivateMethodFromClassname(string $className, string $methodName): ReflectionMethod
    {
        $reflectionClass = new ReflectionClass($className);
        $reflectionMethod = $reflectionClass->getMethod($methodName);
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod;
    }

    /**
     * Access to private method
     *
     * @param  object $object
     * @param  string $methodName
     * @return ReflectionMethod
     */
    public function getPrivateMethodFromObject(object $object, string $methodName): ReflectionMethod
    {
        $reflectionClass = new ReflectionClass($object);
        $reflectionMethod = $reflectionClass->getMethod($methodName);
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod;
    }
}
