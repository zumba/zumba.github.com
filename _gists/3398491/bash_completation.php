<?php

// In my job.php file
if ($argv[1] === '__check__') {
	if (empty($argv[2])) {
		echo implode(' ', \Zumba\Job\Job::availableJobs());
	} else {
		$class = getJobClass($argv[2]);
		if (class_exists($class)) {
			echo implode(' ', $class::availableMethods());
		}
	}
	exit(0);
}


// In my Zumba\Job\Job class
public static function availableJobs() {
	$files = \Zumba\Util\FileSystem::listFiles(JOB . DIRECTORY_SEPARATOR . 'Job');
	// $files will contain a list of files in specific folder
	$jobs = array();
	foreach ($files as $file) {
		$jobs[] = pathinfo($file, PATHINFO_FILENAME);
	}
	sort($jobs);
	return $jobs;
}


// In the parent class of my jobs
public static function availableMethods() {
	$methods = array();

	$refClass = new \ReflectionClass(get_called_class());
	foreach ($refClass->getMethods() as $method) {
		if (
			!$method->isPublic() ||
			$method->isConstructor() ||
			$method->isDestructor() ||
			$method->isStatic()
		) {
			continue;
		}
		$methods[] = $method->name;
	}
	return $methods;
}
