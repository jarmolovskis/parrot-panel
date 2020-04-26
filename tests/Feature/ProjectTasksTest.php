<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }


    /** @test */
    public function only_the_owner_of_a_project_may_add_task()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task`s text'])

            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }


    /** @test */
    public function only_the_owner_of_a_project_may_update_a_task()
    {
        $this->signIn();
        

        $project = factory('App\Project')->create();

        $task = $project->addTask('New task`s test text');

        $this->patch($task->path(), ['body' => 'Updated Test task`s text'])

            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Updated Test task`s text']);
    }

    
    /** @test */
    public function a_project_can_have_tasks()
    {

        $this->signIn();

        // $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $this->post($project->path() . '/tasks', ['body' => 'Test task`s text']);

        $this->get($project->path())
            ->assertSee('Test task`s text');
    }


    


    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $task = $project->addTask('Test tasks text');
        
        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'Updated tasks text',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Updated tasks text',
            'completed' => true
        ]);

    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
