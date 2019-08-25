<?php

namespace Tests\Unit;

use App\Edgar\Activity\Exceptions\ActivityNotFoundException;
use App\Edgar\Activity\Repositories\ActivityRepository;
use App\Edgar\Activity\Activity;
use Tests\TestCase;

class ActivityUnitTest extends TestCase
{
    /** @test */
    public function it_can_list_all_the_activities()
    {
        factory(Activity::class, 20)->create();

        $activityRepo = new ActivityRepository(new Activity);
        $lists = collect($activityRepo->listAllActivities())->all();

        $this->assertCount(20, $lists);
    }

    /** @test */
    public function it_can_delete_the_activity()
    {
        $activity = factory(Activity::class)->create();

        $activityRepo = new ActivityRepository($activity);
        $activityRepo->deleteActivity();

        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
    }

    /** @test */
    public function it_errors_when_the_activity_is_not_found()
    {
        $this->expectException(ActivityNotFoundException::class);

        $activityRepo = new ActivityRepository(new Activity);
        $activityRepo->findActivityById(999);
    }

    /**
     * @test
     * @throws ActivityNotFoundException
     */
    public function it_can_show_the_activity()
    {
        $activity = factory(Activity::class)->create();

        $activityRepo = new ActivityRepository(new Activity);
        $found = $activityRepo->findActivityById($activity->id);

        $this->assertEquals($activity->description, $found->description);
        $this->assertEquals($activity->email, $found->email);
    }

    /** @test */
    public function it_can_update_the_activity()
    {
        $activity = factory(Activity::class)->create();

        $update = [
            'description' => $this->faker->firstName
        ];

        $activityRepo = new ActivityRepository($activity);
        $activityRepo->updateActivity($update);

        $this->assertEquals($update['description'], $activity->description);
    }

    /** @test */
    public function it_can_create_the_activity()
    {
        $data = [
            'description' => $this->faker->text,
        ];

        $activityRepo = new ActivityRepository(new Activity);
        $activity = $activityRepo->createActivity($data);

        $this->assertEquals($data['description'], $activity->description);
    }
}