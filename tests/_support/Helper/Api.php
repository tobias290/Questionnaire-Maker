<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Exception\ModuleException;

class Api extends \Codeception\Module {
    /**
     * Get the response from the sent request.
     *
     * @return array|null
     */
    public function getResponse() {
        try {
            return json_decode($this->getModule("REST")->response, true);
        } catch (ModuleException $e) {
            return null;
        }
    }
}
