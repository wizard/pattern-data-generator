<?php

interface IPatternDataValidator extends IPatternDataOperator
{
	public function ValidateData($Data);
	public function ValidateDataAgainst($Data, $Pattern);
}

