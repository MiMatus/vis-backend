<?php declare(strict_types=1);


namespace Tests\Unit;

use SkillShare\Bootstrap;
use SkillShare\Enitity\Location;
use SkillShare\Enitity\Supplier;
use SkillShare\Repository\SupplierRepository;
use SkillShare\Test\Unit\Mock\LoggerMock;
use SkillShare\Test\Unit\Mock\SupplierMapperMock;
use Tester\Assert;

require_once  __DIR__ . '/../../src/Bootstrap.php';
Bootstrap::bootForTests();

class SupplierRepositoryTest extends \Tester\TestCase
{

	private SupplierRepository $supplierRepository;
    
    protected function setUp()
    {
		$this->supplierRepository = new SupplierRepository(
			new SupplierMapperMock(),
			new LoggerMock()
		);
    }

	public function testSaveSupplier(): void
	{
		$supplier = new Supplier('email', 'password', new Location('city', 'street', 'postalCode'), 'name', []);
		$this->supplierRepository->save($supplier);
		//Assert::same($supplier, $this->supplierRepository->find(''));
	}

	public function testSupplierRetrieval(): void
	{

	}
}

(new SupplierRepositoryTest())->run();
