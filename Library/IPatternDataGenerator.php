<?php

interface IPatternDataGenerator extends IPatternDataOperator
{
	public function GenerateData();
	public function GenerateDataFrom($Pattern);
}

