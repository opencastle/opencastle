<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 30.11.15
 * Time: 20:49
 */

namespace OpenCastle\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class HasSenderOrReceiverValidator
 * Handles validation of the HasSenderOrReceiverConstraint
 *
 * @package OpenCastle\CoreBundle\Validator\Constraints
 */
class HasSenderOrReceiverValidator extends ConstraintValidator
{
    /**
     * @param \OpenCastle\CoreBundle\Entity\GameEventLog $gameEventLog
     * @param Constraint $constraint
     */
    public function validate($gameEventLog, Constraint $constraint)
    {
        if (is_null($gameEventLog->getSenderId()) && is_null($gameEventLog->getReceiverId())) {
            // If you're using the new 2.5 validation API (you probably are!)
            $this->context->buildViolation($constraint->message)
                ->setParameter('%type%', $gameEventLog->getType())
                ->addViolation();
        }
    }
}