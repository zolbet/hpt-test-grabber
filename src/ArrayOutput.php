<?php

namespace App;

class ArrayOutput implements IOutput
{
    /** @var array */
    protected $rows = [];

    /**
    * @param mixed $row
    */
    public function addRow($row)
    {
    	$this->rows[] = $row;
	}

	/**
	 * @return string
	 */
	public function getJson(): string
	{
		return json_encode($this->rows);
	}
}
