@extends ('layouts.app')

@section('content')

<header class="flex items-center justify-between mb-3 py-4">
    <h2 class="text-gray-400 text-sm font-normal">My projects</h2>
    <a href="/projects/create" class="button">Create project</a>
</header>


<main class="lg:flex lg:flex-wrap -mx-3">

    @forelse ($projects as $project)
    <div class="lg:w-1/3 px-3 pb-6">
        <div class="bg-white rounded-lg shadow p-5" style="height: 200px;">
            <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-300 pl-4">
                <a href="{{ $project->path() }}" class="text-black no-underline">{{ $project->title }}</a>
            </h3>
            <div class="text-gray-500">{{ Str::limit($project->description, 300) }}</div>
        </div>
    </div>

    @empty

    <div>No projects yet.</div>

    @endforelse

</main>

@endsection