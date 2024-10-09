<?php

namespace RedSnapper\SwissRx\Tests\Unit;

use RedSnapper\SwissRx\SwissRxUser;
use RedSnapper\SwissRx\Tests\TestCase;

class SwissRxUserTest extends TestCase
{
    /** @test */
    public function can_get_access_groups()
    {
        $user = (new SwissRxUser())->setRaw([
            'AccGrp' => 'group1,group2,group3',
        ]);

        $accessGroups = $user->getAccessGroups();

        $this->assertEquals(['group1', 'group2', 'group3'], $accessGroups);
    }

    /** @test */
    public function empty_array_returned_if_access_group_string_is_empty()
    {
        $user = (new SwissRxUser())->setRaw([
            'AccGrp' => '',
        ]);

        $accessGroups = $user->getAccessGroups();

        $this->assertEquals([], $accessGroups);
    }

    /** @test */
    public function empty_array_returned_if_access_group_key_does_not_exist()
    {
        $user = (new SwissRxUser())->setRaw([]);

        $accessGroups = $user->getAccessGroups();

        $this->assertEquals([], $accessGroups);
    }

    /** @test */
    public function empty_array_returned_if_access_group_key_is_null()
    {
        $user = (new SwissRxUser())->setRaw([
            'AccGrp' => null,
        ]);

        $accessGroups = $user->getAccessGroups();

        $this->assertEquals([], $accessGroups);
    }

    /** @test */
    public function group_names_are_trimmed()
    {
        $user = (new SwissRxUser())->setRaw([
            'AccGrp' => 'group1, group2, group3',
        ]);

        $accessGroups = $user->getAccessGroups();

        $this->assertEquals(['group1', 'group2', 'group3'], $accessGroups);
    }
}
