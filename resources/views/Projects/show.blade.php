@extends ('layouts.app')

@section('content')

<header class="flex items-end justify-between mb-3 py-4">
    <p class="text-gray-400 text-sm font-normal">
        <a class="text-gray-400 text-sm font-normal no-underline" href="/projects">My projects</a> / {{ $project->title }}
    </p>
    <a href="/projects/create" class="button">Create project</a>
</header>



<main>
    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-6">


            <div class="mb-8">
                <h2 class="text-lg text-gray-400 font-normal mb-3">Tasks</h2>

                @forelse ($project->tasks as $task)

                    <div class="card mb-3">{{ $task->body }}</div>

                @empty

                    <div>No tasks yet.</div>

                @endforelse

            </div>

            <div>
                <h2 class="text-lg text-gray-400 font-normal mb-3">General Notes</h2>

                <textarea class="card w-full" style="min-height: 200px;">Lorem ipsum.</textarea>
                <!-- General notes -->
            </div>
        </div>
        <div class="lg:w-1/4 px-3">
            @include ('projects.card')
        </div>
    </div>
</main>



@endsection