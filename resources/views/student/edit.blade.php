@extends('layout.main')
 
@section('title')
    Edit Student
@endsection
 
@section('content') 
<div class="container">
    <h2 class="text-center mt-3">Edit Student</h2>
    <form action="{{ route('student.update', $student->id) }}"  method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $student->name }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>         
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $student->email }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>           
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ $student->city }}">
            @error('city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div> 
        <button type="submit" class="btn btn-primary">Update</button> 
    </form>
</div> 
@endsection
