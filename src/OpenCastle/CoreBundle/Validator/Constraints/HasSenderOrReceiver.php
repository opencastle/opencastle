<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 30.11.15
 * Time: 20:46.
 */
namespace OpenCastle\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class HasSenderOrReceiver
 * Constraint to validate presence of either senderId or receiverId in a GameEventLog object.
 *
 * @Annotation
 */
class HasSenderOrReceiver extends Constraint
{
    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public $message = 'Le GameEvent de type %type% n\'a ni sender, ni receiver.
                        Merci de spécifier au moins une des deux valeurs.';
}
