<?php

namespace Tests\Unit;

use App\Http\Middleware\ValidateToken;
use App\Models\Token;
use Illuminate\Http\Request;
use ReflectionClass;
use Tests\TestCase;

class ValidateTokenTest extends TestCase
{

    /**
     * Test token in header.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function test_token_in_header(): void
    {
        $request = new Request();
        $request->headers->set('token', 'test');

        $hasTokenInHeader = $this->getMethod('hasTokenInHeader')->invokeArgs(new ValidateToken(), [$request]);
        $this->assertTrue($hasTokenInHeader);
    }

    /**
     * Test no token in header.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function test_no_token_in_header(): void
    {
        $hasTokenInHeader = $this->getMethod('hasTokenInHeader')->invokeArgs(new ValidateToken(), [new Request()]);
        $this->assertFalse($hasTokenInHeader);
    }

    /**
     * Test no token in database.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function test_no_token_in_database(): void
    {
        $request = new Request();
        $request->headers->set('token', 'test');

        $hasTokenInDb = $this->getMethod('hasTokenInDatabase')->invokeArgs(new ValidateToken(), [$request]);
        $this->assertNull($hasTokenInDb);
    }


    /**
     * Test token in database.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function test_token_in_database(): void
    {
        $request = new Request();
        $token = Token::factory()->create();
        $request->headers->set('token', $token->value);

        $hasTokenInDb = $this->getMethod('hasTokenInDatabase')->invokeArgs(new ValidateToken(), [$request]);
        $this->assertEquals($hasTokenInDb->id, $token->id);
    }

    /**
     * Test token expired
     *
     * @return void
     * @throws \ReflectionException
     */
    public function test_token_expired()
    {
        $token = Token::factory()->create([
            'expires_at' => now()->subMinute(),
        ]);

        $tokenExpired = $this->getMethod('hasTokenExpired')->invokeArgs(new ValidateToken(), [$token]);
        $this->assertTrue($tokenExpired);
    }

    /**
     * Test token not expired
     *
     * @return void
     * @throws \ReflectionException
     */
    public function test_token_not_expired()
    {
        $token = Token::factory()->create();

        $tokenExpired = $this->getMethod('hasTokenExpired')->invokeArgs(new ValidateToken(), [$token]);
        $this->assertFalse($tokenExpired);
    }

    /**
     * Set private methods as accessible for unit testing
     *
     * @param $name
     * @return \ReflectionMethod
     * @throws \ReflectionException
     */
    private function getMethod($name): \ReflectionMethod
    {
        $class = new ReflectionClass(ValidateToken::class);
        $method = $class->getMethod($name);
        return $method;
    }
}
