@extends('layouts.app')

@section('title', 'About Us')

@section('content')


            <div class="about-section">
                <h1>About Us Page</h1>
                <p>Meet the team behind SmokeyGlasses.</p>
            </div>
            <h2 style="text-align:center">Our Team</h2>
            <div class="row">
                <div class="column">
                    <div class="card py-3 px-3 mb-3">
                        <h3>José Ramos</h3>
                        <p class="title">Master of HTML</p>
                        <p>jose@example.com</p>
                    </div>

                </div>
                <div class="column">
                    <div class="card py-3 px-3 mb-3">
                        <h2>Bea Cruz</h2>
                        <p class="title">Bender of javascript</p>
                        <p>bea@example.com</p>
                    </div>
                </div>
                <div class="column">
                    <div class="card py-3 px-3 mb-3">
                        <h2>Henrique Ferreira</h2>
                        <p class="title">3º colaborator</p>
                        <p>henrique2@example.com</p>
                    </div>
                </div>
            </div>

@endsection
