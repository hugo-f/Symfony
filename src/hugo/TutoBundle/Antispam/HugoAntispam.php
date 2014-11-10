<?php

namespace hugo\TutoBundle\Antispam;

class HugoAntispam extends \Twig_Extension
{
	private $mailer;
	private $locale;
	private $minLength;

public function __construct(\Swift_Mailer $mailer, $minLength)
{
	$this->mailer = $mailer;
	// $this->locale = $locale;
	$this->minLength = (int) $minLength;
}
	/**
	 * @param  string $text
	 * @return  bool
	 */
	public function isSpam($text){
		return strlen($text) < $this->minLength;
	}

	public function getFunctions()
	{
		return array(
			'checkIfSpam' => new \Twig_Function_Method($this, 'isSpam')
		);
	}

	public function getName() {
		return "HugoAntispam";
	}

	public function setLocale ($locale){
		$this->locale = $locale;
	}
}
