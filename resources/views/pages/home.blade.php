@extends('layouts.app')

@section('title', 'Micrandria — Technology, Architecture & Digital Products')

@section('content')

<section class="bg-white">
    <x-ui.container class="py-24 md:py-32">

        <div class="max-w-4xl">

            <p class="text-sm font-medium uppercase tracking-[0.2em] text-zinc-500">
                Technology · Architecture · Digital Products
            </p>

            <h1 class="mt-6 text-5xl font-semibold tracking-tight text-zinc-950 md:text-7xl">
                Building reliable digital experiences with software and technology.
            </h1>

            <p class="mt-8 max-w-2xl text-lg leading-8 text-zinc-600">
                Personal website, technical playground and professional blog
                focused on software engineering, architecture, DevOps,
                automation and digital products.
            </p>

        </div>

    </x-ui.container>
</section>

@endsection