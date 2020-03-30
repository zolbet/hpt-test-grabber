<?php

namespace App;

use Symfony\Component\DomCrawler\Crawler;
use App\Exception;

class HtmlGrabber implements IGrabber
{
    /**
    * HTML page URI
    *
    * @var string
    */
    protected $uri;

    /**
    * Placeholder in $uri
    *
    * @var string
    */
    protected $uriPlaceholder;

    /**
    * Product price xpath
    *
    * @var string
    */
    protected $priceXPath;

    /**
    * @param string $uri HTML page URI (e.g. http://mypage.com/{PRODUCT_ID})
    * @param string $uriPlaceholder Placeholder in $uri (e.g. {PRODUCT_ID})
    */
    public function __construct(string $uri, string $uriPlaceholder)
    {
        if (strpos($uri, $uriPlaceholder) === false) {
			throw new Exception(sprint('Placeholder %s was not found in uri %s', $uriPlaceholder, $uri));
        }

    	$this->uri = $uri;
    	$this->uriPlaceholder = $uriPlaceholder;
	}

	/**
	* @param string $xPath xpath for product price
	*/
	public function setPriceXPath(string $xPath)
	{
		$this->priceXPath = $xPath;
	}

	/**
	* @param string $productId Product ID for URI
	* @param string $xPath xpath for current value
	*/
	protected function getProductValue(string $productId, string $xPath)
	{
		$uri = str_replace($this->uriPlaceholder, $productId, $this->uri);

		if (false === ($htmlContent = @file_get_contents($uri))) {
        	return null;
		}
        $crawler = new Crawler($htmlContent);
        $results = $crawler->evaluate($xPath); // teoreticky mozno pouzit @ a utlmit warningy v pripade nevadlidneho xpath

        if (count($results) === 1 && !empty($results[0])) {
			return $results[0];
        }

        return null;
	}

	/**
	* @param string $productId Product ID for URI
	*
	* @return float
	*/
	public function getPrice(string $productId): ?float
	{
		return $this->getProductValue($productId, $this->priceXPath);
	}
}