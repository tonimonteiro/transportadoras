<?php
/**
 * Sim Tecnologia Application
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.simtecnologia.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   CnpjValidator.php
 * @package    SimBase\Validator
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\Validator;

use Zend\Validator\AbstractValidator;

class CnpjValidator extends AbstractValidator {

	const INVALID = "CNPJInvalido.";

	/**
	 * Validation failure message template definitions
	 *
	 * @var array
	 */
	protected $messageTemplates = array (
			self::INVALID => "Número do CNPJ informado é inválido!"
	);

	/**
	 * Returns true if and only if $value meets the validation requirements
	 *
	 * If $value fails validation, then this method returns false, and
	 * getMessages() will return an array of messages that explain why the
	 * validation failed.
	 *
	 * @param mixed $value
	 * @return boolean
	 * @throws Exception\RuntimeException If validation of $value is impossible
	 */
	public function isValid($value) {
		$cnpj = $this->trimCNPJ ( $value );
		if ($this->respectsRegularExpression ( $cnpj ) != 1) {
			$this->error ( self::INVALID );
			return false;
		} else {
			$x = strlen ( $cnpj ) - 2;
			if ($this->applyingCnpjRules ( $cnpj, $x ) == 1) {
				$x = strlen ( $cnpj ) - 1;
				if ($this->applyingCnpjRules ( $cnpj, $x ) == 1) {
					return true;
				} else {
					$this->error ( self::INVALID );
					return false;
				}
			} else {
				$this->error ( self::INVALID );
				return false;
			}
		}
	}

	/**
	 *
	 * @param $cnpj
	 * @return string
	 */
	private function trimCNPJ($cnpj) {
		$cnpj = preg_replace ( '/[.,-]/', '', $cnpj );

		return $cnpj;
	}

	/**
	 *
	 * @param $cnpj
	 * @return bool
	 */
	private function respectsRegularExpression($cnpj) {
		$regularExpression = "[0-9]{2,3}\\.?[0-9]{3}\\.?[0-9]{3}/?[0-9]{4}-?[0-9]{2}";

		if (! @ereg ( "^" . $regularExpression . "\$", $cnpj )) {
			return false;
		}

		return true;
	}

	/**
	 *
	 * @param $cnpj
	 * @param $x
	 * @return bool
	 */
	private function applyingCnpjRules($cnpj, $x) {
		$VerCNPJ = 0;
		$ind = 2;

		for($y = $x; $y > 0; $y --) {
			$VerCNPJ += ( int ) substr ( $cnpj, $y - 1, 1 ) * $ind;
			if ($ind > 8) {
				$ind = 2;
			} else {
				$ind ++;
			}
		}

		$VerCNPJ %= 11;
		if (($VerCNPJ == 0) || ($VerCNPJ == 1)) {
			$VerCNPJ = 0;
		} else {
			$VerCNPJ = 11 - $VerCNPJ;
		}

		if ($VerCNPJ != ( int ) substr ( $cnpj, $x, 1 )) {
			return false;
		} else {
			return true;
		}
	}
}
