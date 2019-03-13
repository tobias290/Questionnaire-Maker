<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor {
    use _generated\FunctionalTesterActions;

    /**
     * Extends "\Codeception\Actor::amOnPage" by adds the necessary part to show the page on the front end.
     *
     * @param $page - Page URL.
     */
    public function amOnFrontEndPage($page) {
        $I = $this;

        if (substr($page, 0, 1)  == "/")
            $I->amOnPage("/frontend/dist/frontend/#$page");
        else
            $I->amOnPage("/frontend/dist/frontend/#/$page");
    }
}
