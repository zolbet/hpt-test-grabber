<?php

namespace App;

interface IOutput
{
    /**
    * @param mixed $row
    */
    public function addRow($row);

    /**
	 * @return string
	 */
	public function getJson(): string;
}
