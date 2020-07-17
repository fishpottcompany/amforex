<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{

    private $token;

    public function get_token()
	{   
        //echo "get_token: " . $this->token;
		return $this->token;
    }
    
    public function set_token($current_token)
	{

        //echo "set_token: " . $current_token;
		$this->token = $current_token;
    }
    
/*
|--------------------------------------------------------------------------
| LOGIN TESTS
|--------------------------------------------------------------------------
|
| Here is where we do all the tests relating to the getting an access token
|
*/

    public function test_that_login_web_page_works()
    {
        $response = $this->get('http://amforex/admin/login');
        $response->assertStatus(200);
    }

    public function test_that_unregistered_user_cannot_login()
    {
        $response = $this->post(
        "http://amforex/api/v1/admin/login", 
        [
            "admin_phone_number" => "0212345678",
            "password" => "12345678"
        ],
        [
            "HTTP_Accept" => "application/json"
        ]);

        $response->assertStatus(200)
        ->assertJson([
            "status" => "fail"
        ]);
    }

    public function test_that_registered_user_can_login()
    {
        $response = $this->post(
        "http://amforex/api/v1/admin/login", 
        [
            "admin_phone_number" => "0207393441",
            "password" => "12345678"
        ],
        [
            "HTTP_Accept" => "application/json"
        ]);

        $this->set_token($response["access_token"]);
        
        $response->assertStatus(200)
        ->assertJson([
            "status" => "success"
        ]);
    }

/*
|--------------------------------------------------------------------------
| PASSCODE VERIFICATION TESTS
|--------------------------------------------------------------------------
|
| Here is where we do all the tests relating to the passcode verifcation
|
*/

    public function test_that_verification_web_page_works()
    {
        $response = $this->get('/admin/verification');
        $response->assertStatus(200);
    }

    public function test_that_tokenless_admin_cannot_resend_verification_code()
    {
        $response = $this->get(
        "http://amforex/api/v1/admin/verification", 
        [
            "HTTP_Accept" => "application/json"
        ]);

        $response->assertStatus(401);
    }

    public function test_that_admin_with_token_can_resend_a_passcode()
    {
        //$this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
            
        $authorization = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMDRhYWI4Yjg1ZDFjOWFlYzgwY2EwM2U3ODUyMGU5Y2M4YjAzODA5YzdjODI5Y2M2MDRjZTc4Y2I3YWYyNGNhODhlM2FjMTViNWYwYTY3OTgiLCJpYXQiOjE1OTQ5MTk4MTcsIm5iZiI6MTU5NDkxOTgxNywiZXhwIjoxNjI2NDU1ODE3LCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.i3Bfwy1qSdgndMbtoIUyQj4BkXkMixsg3tDSqr4YkQgRoBM2obiwNmQIShZqhtMixCGozWX8J_ykD3IDqONm7n9Cg8r4vF3J_XZxyHTYiNvgeYwgZQEqSxW5cJdlW0eah1MZYalcaE78h8v4TJqFWpGEc5M7Jstcoxuv62FxS2sfyddkF72RsuXX3o5bXzFs_9kV3PPFja_SpOx52XQaRU9gpx2Y-kuUO6-9D-J0J9xZhRreIvGa--5ZQZyii_CIg1_RpHxaRwDonPDMgpHYuA0VSctlSRGOzRqTbuyFaBuSYocM1TIprZJPURNKlDk12Nhi6d3eohcMky9BvzpsypBmroo9dAopzDjq8VNMI7lWdu_x-Q-XMYyaDR-lA3XuBX0VSg9Evw4eR7Qqr7WVJAsjKVp1IJerMeJKBugYvKGvc6fOL2EekDYOatus2pPBklIC4dkz7O5VtZOvW3lJ92r4_l0aUFO9cw19np9MH94Q9dkYEbzJ_q9XlfjvvaS_37K02xm_tBNfJbaCvOu4Mrz2t8n17yAEuPlYpWKaXH0M_xcotMTVLl8t62mRPI3uby5yyFMpBB3MvMhynY5rIRCbWbIfUHTtizUbS5KeYbeN-KWSoZyzoCI0wH7RqCEUeykGoUEMvZmh_ogSk2ZLa4fBIzEMVXa3apFBI5PzPMw";
        echo "authorization: " . $authorization;

        $response = $this->get(
        "http://amforex/api/v1/admin/resend", 
        [
            "HTTP_Authorization" => $authorization,
            "HTTP_Accept" => "application/json"
        ]);

        $response->assertStatus(200)
        ->assertJson([
            "status" => "success"
        ]);
    }

    public function test_that_tokenless_admins_cannot_access_passcode_verfication_api()
    {
        $response = $this->post(
        "http://amforex/api/v1/admin/verification", 
        [
            
        ],
        [
            "HTTP_Accept" => "application/json"
        ]);

        $response->assertStatus(405);
    }
}
