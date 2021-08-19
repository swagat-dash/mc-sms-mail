<?php

namespace Plivo\Tests\Resources;
use Plivo\Http\PlivoRequest;
use Plivo\Http\PlivoResponse;
use Plivo\Tests\BaseTestCase;

/**
 * Class PowerpackTest
 * @package Plivo\Tests\Resources
 */
class PowerpackTest extends BaseTestCase {
    // list the powerpack detail
    function testPowerpackList()
    {
        $request = new PlivoRequest(
            'GET',
            'Account/MAXXXXXXXXXXXXXXXXXX/Powerpack/',
            []);
        $body = file_get_contents(__DIR__ . '/../Mocks/powerpackListResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));

        $actual = $this->client->powerpacks->list();

        $this->assertRequest($request);

        self::assertNotNull($actual);
    }

   // update powerpack name
    function testUpdatePowerpack(){
        $uuid = '5ec4c8c9-cd74-42b5-9e41-0d7670d6bb46';
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Powerpack/' . $uuid . '/',
            [
                'name' => "powerpackname",
            ]);
        $body = file_get_contents(__DIR__ . '/../Mocks/powerpackResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));
    }

     // list the powerpack numbers 
    function testNumberpoolList()
    {
        $uuid = "8711d367-469e-497d-9b26-ff79390bcfe8";
        $request = new PlivoRequest(
            'GET',
            'Account/MAXXXXXXXXXXXXXXXXXX/Numberpool/ca5fd1f2-26c0-43e9-a7e4-0dc426e9dd2f/Number/',
            []);
        $body = file_get_contents(__DIR__ . '/../Mocks/numberpoolListResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));

        $powerpack = $this->client->powerpacks->get($uuid);
        $actual = $powerpack->list_numbers();
        //$actual = $powerpack->number_pool->numbers->list();
        $this->assertRequest($request);

        self::assertNotNull($actual);
    }

    //List the shortcode
    function testShortcodeList()
    {
        $uuid = "8711d367-469e-497d-9b26-ff79390bcfe8";
        $request = new PlivoRequest(
            'GET',
            'Account/MAXXXXXXXXXXXXXXXXXX/Numberpool/ca5fd1f2-26c0-43e9-a7e4-0dc426e9dd2f/Shortcode/',
            []);
        $body = file_get_contents(__DIR__ . '/../Mocks/shortcodeListResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));

        $powerpack = $this->client->powerpacks->get($uuid);
        $actual = $powerpack->list_shortcodes();
        //$actual = $powerpack->number_pool->shortcodes->list();
        $this->assertRequest($request);

        self::assertNotNull($actual);
    }

    // add a numbers to powerpack
    function testAddNumber()
    {
        $number = "17025295199";
        $uuid = "8711d367-469e-497d-9b26-ff79390bcfe8";
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Numberpool/ca5fd1f2-26c0-43e9-a7e4-0dc426e9dd2f/Number/'. $number .'/',
            []);
        $body = file_get_contents(__DIR__ . '/../Mocks/numberpoolResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));

        $powerpack = $this->client->powerpacks->get($uuid);
        $actual = $powerpack->add_number($number);
        // $actual = $powerpack->number_pool->numbers->add($number);
        $this->assertRequest($request);
        self::assertNotNull($actual);
    }

    // remove numbers from powerpack
    function testRemoveNumber()
    {
        $uuid = "8711d367-469e-497d-9b26-ff79390bcfe8";
        $number = "17025295199";
        $request = new PlivoRequest(
            'Delete',
            'Account/MAXXXXXXXXXXXXXXXXXX/Numberpool/ca5fd1f2-26c0-43e9-a7e4-0dc426e9dd2f/Number/'. $number .'/',
            []);
        $body = file_get_contents(__DIR__ . '/../Mocks/powerpackDeleteResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));

        $powerpack = $this->client->powerpacks->get($uuid);
        
        $actual = $powerpack->remove_number($number);
        // $actual = $powerpack.number_pool->numbers->remove($number)
        $this->assertRequest($request);
        self::assertNotNull($actual);
    }
    
    //delete powerpack
    function testDeletePowerpack()
    {
        $uuid = "8711d367-469e-497d-9b26-ff79390bcfe8";
        $request = new PlivoRequest(
            'Delete',
            'Account/MAXXXXXXXXXXXXXXXXXX/Powerpack/'. $uuid .'/',
            []);
        $body = file_get_contents(__DIR__ . '/../Mocks/powerpackDeleteResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));

        $powerpack = $this->client->powerpacks->get($uuid);
        $deleteResponse = $powerpack->delete();

        $this->assertRequest($request);

        self::assertNotNull($deleteResponse);
    }

}