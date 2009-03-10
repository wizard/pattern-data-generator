<?php

interface IPatternDataFormatter extends IPatternFormatOperator
{
	public function FormatData($Data);
	public function FormatDataAs($Data, $Format);
}

