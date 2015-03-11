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
 * @category   CpfCnpjValidator.php
 * @package    SimBase\Validator
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */

namespace SimBase\Validator;

use Zend\Validator\AbstractValidator;

class CpfCnpjValidator extends AbstractValidator {
	const CPF_INVALID = "CPFInvalido";
	const CNPJ_INVALID = "CNPJInvalido";

	/**
	 * Validation failure message template definitions
	 *
	 * @var array
	 */
	protected $messageTemplates = array (
			self::CPF_INVALID => "CPF inválido.",
			self::CNPJ_INVALID => "CNPJ inválido."
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
		$cpfValidator = new CpfValidator ();
		if ($cpfValidator->isValid ( $value )) {
			return true;
		}

		$cnpjValidator = new CnpjValidator ();
		if ($cnpjValidator->isValid ( $value )) {
			return true;
		}

		if (strlen ( $value ) == 14) {
			$this->error ( self::CPF_INVALID );
		} elseif (strlen ( $value ) == 18) {
			$this->error ( self::CNPJ_INVALID );
		}

		return false;
	}
}
