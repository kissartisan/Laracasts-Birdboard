<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;
use App\Project;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */ // Testing relationships
    public function it_belongs_to_a_project()
    {
        $task = factory(Task::class)->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_has_a_path()
    {
        $task = factory(Task::class)->create();

        $this->assertEquals('/projects/' . $task->project->getKey() . '/tasks/' . $task->getKey(), $task->path());
    }

    /** @test **/
    public function it_can_be_completed()
    {
        $task = factory(Task::class)->create();

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }

    /** @test **/
    public function it_can_be_mark_as_incomplete()
    {
        $task = factory(Task::class)->create(['completed' => false]);

        $this->assertFalse($task->completed);

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);
    }
}
