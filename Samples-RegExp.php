<?php

include('Library/PatternDataGenerator.php');

class RegExpPatternDataGeneratorSampleRunner
{
	private $_generator	= null;
	private $_patterns	= array();
	private $_results	= array();
	
	public function __construct()
	{
		$this->_generator = new RegExpPatternDataGenerator();
		
		$this->_patterns[] = '.+';
		$this->_patterns[] = '(.)+';
		
		$this->_patterns[] = '0x[A-F]{2}';
		$this->_patterns[] = '[a-zA-Z]{6}';
		$this->_patterns[] = '[[:alnum:]]{8,12}'; // POSIX style intervals
		$this->_patterns[] = '\d{4}-\d{4}'; // PCRE style intervals
		
		$this->_patterns[] = 'one|two|three';	// the "OR" character
		
		$this->_patterns[] = '(one|two|three) \\1'; // subpatterns
		$this->_patterns[] = '(?:\w):(one|two|three) \\1'; // non-capturing subpatterns
		$this->_patterns[] = '([abc])+ \\1';
		$this->_patterns[] = '([abc]) \\1+';
		
		$this->_patterns[] = '^\S+\s\w{4}$';
		
		$this->_patterns[] = '(ir)?regular'; // either "regular" or "irregular"
		
		$this->_patterns[] = '^(complete)$';
		$this->_patterns[] = '^(completish)\$';
		$this->_patterns[] = '\A(complete)\Z';
		
		$this->_patterns[] = 'gooo*gle';
		
		$this->_patterns[] = 'Tab\tHere';
		$this->_patterns[] = 'Tab\cIHere'; // control characters
		$this->_patterns[] = 'Tab\x09Here'; // hexadecimal character codes
		
		$this->_patterns[] = 'C\+\+'; // escaping special characters
		$this->_patterns[] = '\QC++\E'; // escaping literals
		
		$this->_patterns[] = '.+\bword\b'; // word boundries
	}
	
	public function RunSamples()
	{
		$this->_results = array();
		
		reset($this->_patterns);		
		foreach ($this->_patterns as $pattern)
		{
			$this->_generator->SetPattern($pattern);
			$data = $this->_generator->GenerateData();
			$matches = $this->_generator->Validate($data);
			
			$this->_results[] = array('Pattern'=>$pattern, 'Data'=>$data, 'Valid'=>$matches);
		}
	}
	
	public function ExportResults()
	{
		return $this->_results;
	}
	
	public function PrintResults()
	{
		$allSamplesAreValid = true;
		
		reset($this->_results);
		if (isset($_SERVER['REMOTE_ADDR'])) // sample is running within a web application
		{
			// TODO: prepare a nice HTML output
			$format = '[%s]<br /><strong>Generated Data:</strong> %s<br /><strong>Pattern:</strong> %s<br /><br />';
			
			foreach ($this->_results as $result)
			{
				printf($format, ($result['Valid'] ? 'valid' : 'invalid'), htmlspecialchars($result['Data']), htmlspecialchars($result['Pattern']));
				
				$allSamplesAreValid = $allSamplesAreValid && $result['Valid'];
			}
		}
		else // sample is running from a terminal
		{
			$format = "[%s]\nGenerated Data: %s\nPattern: %s\n\n";
			
			foreach ($this->_results as $result)
			{
				printf($format, ($result['Valid'] ? 'valid' : 'invalid'), $result['Data'], $result['Pattern']);
				
				$allSamplesAreValid = $allSamplesAreValid && $result['Valid'];
			}
		}
		
		if ($allSamplesAreValid)
		{
			printf('All samples are reported to be valid');
		}
		else
		{
			printf('Some samples are reported to be invalid');
		}
	}
}

$runner = new RegExpPatternDataGeneratorSampleRunner();
$runner->RunSamples();
$runner->PrintResults();
