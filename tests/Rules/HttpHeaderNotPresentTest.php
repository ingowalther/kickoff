<?php
namespace Frickelbruder\KickOff\Tests\Rules;

use Frickelbruder\KickOff\Http\HttpResponse;
use Frickelbruder\KickOff\Rules\HttpHeaderNotPresent;

class HttpHeaderNotPresentTest extends \PHPUnit_Framework_TestCase {

    public function testValidate() {
        $response = new HttpResponse();
        $response->setHeaders(array('X-Test' => 'Valid'));

        $rule = new HttpHeaderNotPresent();
        $rule->setHttpResponse($response);
        $rule->setHeaderToSearchFor('X-Test');

        $result = $rule->validate();
        $this->assertFalse($result);
    }

    public function testValidateDoesNotFindHeader() {
        $response = new HttpResponse();
        $response->setHeaders(array('X-Other-Test' => 'Valid'));

        $rule = new HttpHeaderNotPresent();
        $rule->setHttpResponse($response);
        $rule->setHeaderToSearchFor('X-Test');

        $result = $rule->validate();
        $this->assertTrue($result);
    }

    public function testValidateFindsHeaderCI() {
        $response = new HttpResponse();
        $response->setHeaders(array('X-tEsT' => 'Valid'));

        $rule = new HttpHeaderNotPresent();
        $rule->setHttpResponse($response);
        $rule->setHeaderToSearchFor('X-Test');

        $result = $rule->validate();
        $this->assertFalse($result);
    }

    public function testValidateDoesNotFindHeaderInPartialMatch() {
        $response = new HttpResponse();
        $response->setHeaders(array('X-Test' => 'Valid'));

        $rule = new HttpHeaderNotPresent();
        $rule->setHttpResponse($response);
        $rule->setHeaderToSearchFor('Test');

        $result = $rule->validate();
        $this->assertTrue($result);
    }
}
