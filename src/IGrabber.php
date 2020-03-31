<?php

namespace App;

interface IGrabber
{
	/**
	 * @param string $productId
	 * @return float
	 */
	public function getPrice(string $productId): ?float;

	/**
	 * @param string $productId
	 * @return string
	 */
	public function getTitle(string $productId): ?string;

	/**
	 * @param string $productId
	 * @return int
	 */
	public function getRating(string $productId): ?int;
}
