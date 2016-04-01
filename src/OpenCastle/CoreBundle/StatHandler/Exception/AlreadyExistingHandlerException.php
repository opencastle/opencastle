<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 22.03.16
 * Time: 22:07.
 */

namespace OpenCastle\CoreBundle\StatHandler\Exception;

/**
 * Class AlreadyExistingHandlerException.
 */
class AlreadyExistingHandlerException extends \Exception
{
    /**
     * InvalidNameException constructor.
     *
     * @param mixed          $message
     * @param int            $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct('StatHandler with name '.$message.' already exists', $code, $previous);
    }
}
