<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 13.03.16
 * Time: 14:23.
 */

namespace OpenCastle\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class SendNotificationEvent.
 */
class SendNotificationEvent extends Event
{
    private $template;
    private $data;
    private $type;

    /**
     * SendNotificationEvent constructor.
     *
     * @param int    $type
     * @param string $template
     * @param array  $data
     *
     * @throws \Exception
     */
    public function __construct($type, $template, array $data)
    {
        if (!is_int($type)) {
            throw new \Exception('Invalid type given: '.$type);
        }
        $this->type = $type;

        if (!is_string($template)) {
            throw new \Exception('Invalid template given: '.$template);
        }

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
