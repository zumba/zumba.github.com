<?php

class AllAppTest extends CakeTestSuite {

	protected $coverageSetup = false;

	public static function suite() {
		$suite = new self('All Application Tests');
		$suite->addTestDirectoryRecursive(dirname(__FILE__));
		return $suite;
	}

	public function run(PHPUnit_Framework_TestResult $result = NULL, $filter = FALSE, array $groups = array(), array $excludeGroups = array(), $processIsolation = FALSE) {
		if ($result === NULL) {
			$result = $this->createResult();
		}
		if (!$this->coverageSetup) {
			$coverage = $result->getCodeCoverage();
			if ($coverage) { // If the CodeCoverage is not installed or disabled
				$coverage->setProcessUncoveredFilesFromWhitelist(true);

				$coverageFilter = $coverage->filter();
				$coverageFilter->addDirectoryToBlacklist(APP . DS . 'Test');
				$coverageFilter->addDirectoryToBlacklist(CORE_PATH);
			}
			$this->coverageSetup = true;
		}
		return parent::run($result, $filter, $groups, $excludeGroups, $processIsolation);
	}

}