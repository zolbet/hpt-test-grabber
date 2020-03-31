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
    * Product title xpath
    *
    * @var string
    */
    protected $titleXPath;

    /**
    * Product rating xpath
    *
    * @var string
    */
    protected $ratingXPath;

	/**
	* Last loaded URI
	*
	* @var string
	*/
    private $lastUri;

    /**
    * Last loaded document
    *
    * @var mixed
    */
    private $lastDocument;

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
	* @param string $xPath xpath for product title
	*/
	public function setTitleXPath(string $xPath)
	{
		$this->titleXPath = $xPath;
	}

	/**
	* @param string $xPath xpath for product rating
	*/
	public function setRatingXPath(string $xPath)
	{
		$this->ratingXPath = $xPath;
	}

	/**
	* @param string $productId Product ID for URI
	* @param string $xPath xpath for current value
	*/
	protected function getProductValue(string $productId, string $xPath)
	{
		$uri = str_replace($this->uriPlaceholder, $productId, $this->uri);

        $crawler = new Crawler($this->getDocument($uri));
        $results = $crawler->evaluate($xPath); // teoreticky mozno pouzit @ a utlmit warningy v pripade nevadlidneho xpath

        if (count($results) === 1 && !empty($results[0])) {
			return $results[0];
        }

        return null;
	}

    /**
    * Get HTML document from URI or from "cache"
    *
    * @param string $uri
    */
	private function getDocument(string $uri)
	{
		if ($this->lastUri !== $uri) {
			$this->lastUri = $uri;
			if (false === ($this->lastDocument = @file_get_contents($uri))) {
        		return null;
			}
		}

		return $this->lastDocument;
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

	/**
	* @param string $productId Product ID for URI
	*
	* @return string
	*/
	public function getTitle(string $productId): ?string
	{
		return $this->getProductValue($productId, $this->titleXPath);
	}

	/**
	* @param string $productId Product ID for URI
	*
	* @return int
	*/
	public function getRating(string $productId): ?int
	{
		return $this->getProductValue($productId, $this->ratingXPath);
	}
}