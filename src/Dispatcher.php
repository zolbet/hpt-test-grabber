<?php

namespace App;

class Dispatcher
{
	/**
	 * @var IGrabber
	 */
	private $grabber;
	/**
	 * @var IOutput
	 */
	private $output;

	/**
	 * @param IGrabber $grabber
	 * @param IOutput $output
	 */
	public function __construct(IGrabber $grabber, IOutput $output)
	{
		$this->grabber = $grabber;
		$this->output = $output;
	}

	/**
	 * @return string JSON
	 */
	public function run(): string
	{
        $products = new ProductList(__DIR__ . '/../vstup.txt');

        foreach($products as $productId) {
        	$this->output->addRow([
        		$productId => [
                	'price' => $this->grabber->getPrice($productId),
        		],
        	]);
        }

        return $this->output->getJson();
	}

}
