<?php

namespace App;

use App\Exception;

class ProductList implements \Iterator
{
    protected $productCodes = [];

    protected $position = 0;

    /**
     * @param string $file  CSV file with product IDs
     */
    public function __construct(string $file)
    {
		if (!file_exists($file)) {
			throw new Exception(sprintf('File not found "%s"', $file));
		}

        if (false === ($fileContent = @file_get_contents($file))) {
            throw new Exception(sprintf('Failed to load file %s', $file));
        }

        $this->productCodes = str_getcsv($fileContent, PHP_EOL);
    }

    public function current()
    {
    	return $this->productCodes[$this->position];
    }

    public function key()
    {
    	return $this->position;
    }

    public function next()
    {
		++$this->position;
    }

    public function rewind()
    {
    	$this->position = 0;
    }

    public function valid()
	{
		return isset($this->productCodes[$this->position]);
	}
}

