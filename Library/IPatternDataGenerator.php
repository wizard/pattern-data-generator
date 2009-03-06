<?php

interface IPatternDataGenerator
{
	public function SetPattern($Pattern);
	public function GetPattern();
	
	public function GenerateData();
	public function GenerateDataFrom($Pattern);
	
	public function Validate($Data);
	public function ValidateAgainst($Data, $Pattern);
}

