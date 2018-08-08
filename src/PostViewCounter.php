<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 8/8/18
 * Time: 12:26 PM
 */

namespace abdujabbor\counter;

use abdujabbor\counter\io\IOStream;

class PostViewCounter extends AbstractEventCounter implements ICounter
{
    protected $requiredFields = ['id'];

    public function __construct(IOStream $io, array $args = [])
    {
        parent::__construct($io, $args);
        $this->setEvent(EventTypes::EVENT_VIEW);
    }


    public function generateKey(): string
    {
        $this->key = (string) $this->args['id'];
        return $this->key;
    }

    public function generateRecord(): array
    {
        $browser = get_browser();
        return [
            'id' => $this->key,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'browser' => $browser['browser'],
            'platform' => $browser['platform'],
            'version' => $browser['version'],
            'time' => time(),
        ];
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function incrementAmount(): void
    {
        if ($this->availableForIncrement()) {
            $this->amount++;
        }
    }

    public function availableForIncrement(): bool
    {
        return true;
    }

    public function validateInputParams(): bool
    {
        return parent::validateInputParams(); // TODO: Change the autogenerated stub
    }
}
