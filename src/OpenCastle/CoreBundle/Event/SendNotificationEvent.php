<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 13.03.16
 * Time: 14:23
 */

namespace OpenCastle\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class SendNotificationEvent
 * @package OpenCastle\CoreBundle\Event
 */
class SendNotificationEvent extends Event
{
    private $template;
    private $data;
    private $type;

    /**
     * SendNotificationEvent constructor.
     * @param string $template
     * @param array $data
     */
    public function __construct($type, $template, array $data)
    {
        // TODO: add type checks
        $this->type = $type;
        $this->template = $template;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}
